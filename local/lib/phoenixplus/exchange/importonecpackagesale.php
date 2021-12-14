<?php
// sdemon72 20190905
// Скопирован из класса \Bitrix\Sale\Exchange\ImportOneCPackageSale (/bitrix/modules/sale/lib/exchange/importonecpackagesale.php)
namespace Bitrix\Sale\Exchange;


use Bitrix\Main\Error;
use Bitrix\Sale\Cashbox\Cashbox1C;
use Bitrix\Sale\Cashbox\Internals\CashboxCheckTable;
use Bitrix\Sale\Exchange\Entity\OrderImport;
use Bitrix\Sale\Exchange\Entity\PaymentImport;
use Bitrix\Sale\Exchange\OneC\DocumentType;
use Bitrix\Sale\Exchange\OneC\OrderDocument;
use Bitrix\Sale\Exchange\OneC\ShipmentDocument;
use Bitrix\Sale\Result;
use Bitrix\Sale\ResultWarning;


final class ImportOneCPackageSalePhoenixplus extends ImportOneCPackage
{
	// Скопированные и измененные функции
	
	// Скопирована из класса \Bitrix\Sale\Exchange\ImportPattern (/bitrix/modules/sale/lib/exchange/importpattern.php)
	public function process(array $rawData)
    {
		// входной параметр - многоуровневый массив, повторяющий структуру xml
		// AddMessage2Log($rawData, 'ImportOneCPackageSalePhoenixplus->process::rawData'); // sdemon72

        // Чтение входящих данных. Заполняет объекты OrderDocument, ShipmentDocument и т.п. (см.Bitrix\Sale\Exchange\OneC\DocumentImportFactory::create())
        // Объекты содержат только входящие данные
        $r = $this->parse($rawData);
        if(!$r->isSuccess())
            return $r;
        $documents = $r->getData(); // Bitrix\Sale\Exchange\OneC\OrderDocument
		// AddMessage2Log($documents, 'ImportOneCPackageSalePhoenixplus->process::documents'); // sdemon72
        
        // Дополнение необходимыми данными для загрузки в БД
        $r = $this->convert($documents);
        if(!$r->isSuccess())
            return $r;
        
        $entityItems = $r->getData(); // Bitrix\Sale\Exchange\Entity\OrderImport
		// AddMessage2Log($entityItems, "ImportOneCPackageSalePhoenixplus->process::entityItems"); // sdemon72
		
		// Добавление свойств заказа
		$r = $this->addOrderProps($rawData, $entityItems);
        if(!$r->isSuccess())
            return $r;
        $entityItems = $r->getData();
		// AddMessage2Log($entityItems, 'ImportOneCPackageSalePhoenixplus->process::entityItems'); // sdemon72

        // Сохранение данных
		$r = $this->import($entityItems);
        
        // Сохранение лога
        $this->logger($entityItems);

        return $r;
    }

	
	

	// Скопирована из класса \Bitrix\Sale\Exchange\ImportOneCPackageSale (/bitrix/modules/sale/lib/exchange/importonecpackagesale.php)
	// не добавляет ненужных документов
	protected function convert(array $documents)
	{
		/* здесь был код добавления */
		
		return parent::convert($documents);
	}

	
	
	// Скопирована из класса \Bitrix\Sale\Exchange\ImportOneCPackage (/bitrix/modules/sale/lib/exchange/importonecpackage.php)
    // Исправлена обработка свойств заказа
    protected function import(array $items)
    {
        $result = new Result();

		$items = $this->sortItems($items);
		// Загрузка данных из существующего заказа
		$itemParent = $this->loadParent($items);
		
        if($itemParent->getEntityId()>0)
        {
        	$r = $this->UpdateCashBoxChecks($itemParent, $items);
			if($r->isSuccess())
			{
				$this->save($itemParent, $items);
				return $result;
			}

            $r = $this->onBeforeEntityModify($itemParent, $items);
            if($r->hasWarnings())
                $this->marker($itemParent, $r);
        }

		if(!$this->hasCollisionErrors($items))
		{
			/** Only sorted items */
			foreach($items as $item)
			{
				if($item->getOwnerTypeId() == EntityType::USER_PROFILE)
				{
					/** @var Exchange\Entity\UserImportBase $item */
					$r = new Result();
					if($itemParent->getEntityId() == null)
					{
						$params = $item->getFieldValues();
						$fields = $params['TRAITS'];

						$personalTypeId = $params['TRAITS']['PERSON_TYPE_ID'] = $item->resolvePersonTypeId($fields);

						$property = $params['ORDER_PROPS'];
						if(!empty($property))
						{
							$params['ORDER_PROP'] = $item->getPropertyOrdersByConfig($personalTypeId, array(), $property);
						}

						unset($params['ORDER_PROPS']);
						$item->setFields($params);

						$r = $item->load($fields);

						if(intval($personalTypeId)<=0)
							$r->addError(new Error(GetMessage("SALE_EXCHANGE_PACKAGE_ERROR_PERSONAL_TYPE_IS_EMPTY", array("#DOCUMENT_ID#"=>$fields['XML_ID'])), "PACKAGE_ERROR_PERSONAL_TYPE_IS_EPMTY"));

						if($r->isSuccess())
						{
							if(!$this->importableItems($item))
							{
								return new Result();
							}

							$r = $this->modifyEntity($item);

							if(intval($item->getId())<=0)
								$r->addError(new Error(GetMessage("SALE_EXCHANGE_PACKAGE_ERROR_USER_IS_EMPTY", array("#DOCUMENT_ID#"=>$fields['XML_ID'])), "PACKAGE_ERROR_USER_IS_EPMTY"));

							if($r->isSuccess())
							{
								/** prepare for import Order */
								$paramsOrder = $itemParent->getFieldValues();
								$fieldsOrder = &$paramsOrder['TRAITS'];

								if(!empty($property))
								{
									// sdemon72
									// $fieldsOrder['ORDER_PROP'] = $params['ORDER_PROP'];
									$fieldsOrder['ORDER_PROP'] = $fieldsOrder['ORDER_PROP'] + $params['ORDER_PROP'];
									// _sdemon72
								}

								$fieldsOrder['USER_ID'] = $item->getId();
								$fieldsOrder['PERSON_TYPE_ID'] = $personalTypeId;
								$itemParent->setFields($paramsOrder);
							}
						}
					}
				}
				elseif($item->getOwnerTypeId() == static::getParentEntityTypeId())
				{
					if(!$this->importableItems($itemParent))
					{
						return new Result();
					}
					$r = $this->modifyEntity($itemParent);
				}
				else
				{
					/** @var Exchange\Entity\PaymentImport|Exchange\Entity\ShipmentImport $item */
					/** @var Order $order */
					$order = $itemParent->getEntity();
					$params = $item->getFieldValues();
					$fields = $params['TRAITS'];

					$r = $this->orderIsLoad($order, $itemParent);
					if(!$r->hasWarnings())
					{
						static::load($item, $fields, $order);

						$r = $this->checkParentById($fields['ID'], $item);
						if(!$r->hasWarnings())
						{
							$isShipped = $order->isShipped();

							$r = $this->modifyEntity($item);

							if($r->isSuccess())
							{
								if($item->getOwnerTypeId() == static::getShipmentEntityTypeId())
								{
									if(!$isShipped && $order->isShipped())
										$this->onAfterShipmentModifyChangeStatusOnDelivery($itemParent);
								}
							}
						}
					}
				}

				if(!$r->isSuccess())
				{
					$result->addErrors($r->getErrors());
					break;
				}
				elseif($r->hasWarnings())
				{
					$result->addWarnings($r->getWarnings());
					break;
				}
			}

			if($result->isSuccess() && !$result->hasWarnings() && !$this->hasCollisionErrors($items))
			{
				$r = $this->onAfterEntitiesModify($itemParent, $items);
				if(!$r->isSuccess())
					$result->addErrors($r->getErrors());
				if($r->hasWarnings())
					$result->addWarnings($r->getWarnings());
			}
		}

        if($result->isSuccess())
        {
            $r = $this->save($itemParent, $items);
			if(!$r->isSuccess())
				$result->addErrors($r->getErrors());
			if($r->hasWarnings())
				$result->addWarnings($r->getWarnings());
        }

        return $result;
    }


	// Скопирована из класса \Bitrix\Sale\Exchange\ImportOneCPackage (/bitrix/modules/sale/lib/exchange/importonecpackage.php)
	// не удаляет оплаты и отгрузки
    protected function onBeforeEntityModify(OrderImport $orderImport, array $items)
    {
		// AddMessage2Log($items, 'ImportOneCPackageSalePhoenixplus->onBeforeEntityModify::items'); // sdemon72
        $result = new Result();
		$paymentResult = new Result();

		$basketItemsResult = $this->onBeforeBasketModify($orderImport, $items);

		/* здесь был код удаления отгрузок и оплат */

		if(!$basketItemsResult->isSuccess())
			$result->addWarning(new ResultWarning(GetMessage('SALE_EXCHANGE_PACKAGE_ERROR_ORDER_CANNOT_UPDATE'), "PACKAGE_ERROR_ORDER_CANNOT_UPDATE"));

        return $result;
    }







	//////////////////////
	// sdemon72
	// Собственные функции
	
	
	// добавляет в объекты свойства, считанные из XML-файла обмена
    private function addOrderProps(array $rawData, array $items)
    {
        $result = new Result();
		
		// Прочитать свойства заказа из XML
		$arOrdersProps = $this->parseOrdersProps($rawData);

		// Прочитать типы пользователя из XML
		$userTypes = $this->parseUserTypes($rawData);
		
		
		// Перенести данные в объекты
		foreach($items as $item)
		{
			$fields = $item->getField('TRAITS');
			
			if($item->getOwnerTypeId() == static::getParentEntityTypeId())
			// Если это заказ, то поместить свойства
			{
				//$params = $item->getFieldValues();
				//$fields = $params['TRAITS'];
				
				$props = $this->getOrderProps($arOrdersProps, $fields);
				$fields['ORDER_PROP'] = $props;
				
				//$item->setFields(array('TRAITS'=>$fields));
				$item->setField('TRAITS',$fields);
			}
			elseif($item->getOwnerTypeId() == EntityType::USER_PROFILE)
			// Если это пользователь, то поместить тип пользователя
			{
				//$params = $item->getFieldValues();
				//$fields = $params['TRAITS'];
				
				if($userTypes[$fields['XML_ID']] == 'SIMPLE')
				{
					$fields['TYPE'] = 'FIZ';
				}
				else
				{
					$fields['TYPE'] = 'UR';
				}
				//$item->setFields(array('TRAITS'=>$fields));
				$item->setField('TRAITS',$fields);
			}
		}
		// AddMessage2Log($fields, 'ImportOneCPackageSalePhoenixplus->addOrderProps::fields'); // sdemon72

		$result->setData($items);
		return $result;
		
	}

	// Получает массив значений свойств для каждого заказа, считанный из XML
	private function parseOrdersProps(array $rawData)
	{
		
		foreach($rawData as $arXmlOrder)
		{
			// Прочитать свойства для ордера
			$arXmlOrderProps = $arXmlOrder["#"]["СвойстваЗаказа"][0]["#"]["СвойствоЗаказа"];

			$arOrderProps = array();
			foreach($arXmlOrderProps as $arXmlOrderProp)
			{
				$dbRes = \Bitrix\Sale\Property::getList(['filter' => [
				'NAME' => $arXmlOrderProp["#"]["Наименование"][0]["#"]
				]]);
				
				while ($property = $dbRes->fetch())
				{
					$arOrderProps[$property['ID']] = $arXmlOrderProp["#"]["Значение"][0]["#"];
				}
			}
			
			// Добавить в общий массив
			$arOrdersProps[] = [
			"ID_1C" => $arXmlOrder["#"]["Ид"][0]["#"],
			"PROPS" => $arOrderProps,
			];
		}
		
		return $arOrdersProps; 
		
	}
	
	// Получает массив свойств для конкретного заказа
	private function getOrderProps(array $arOrdersProps,array $fields)
	{
		foreach($arOrdersProps as $arOrderProps)
		{
			if ($arOrderProps['ID_1C'] = $fields['ID_1C'])
			{
				return $arOrderProps['PROPS'];
			}
		}
		return array();
	}

	// Получает тип пользователя для каждого заказа, считанный из XML
	private function parseUserTypes(array $rawData)
	{
		$arUserTypes = array();

		foreach($rawData as $arXmlOrder)
		{
			// Узел "Контрагенты"
			$arUsersNode = $arXmlOrder["#"]["Контрагенты"];
			foreach($arUsersNode as $arUsers)
			{
				// Узел "Контрагент"
				$arUserNode = $arUsers["#"]["Контрагент"];
				foreach($arUserNode as $arUser)
				{
					$arUserId = $arUser["#"]["Ид"][0]["#"];
					$arUserType = $arUser["#"]["ТипПользователя"][0]["#"];
					$arUserTypes[$arUserId] = $arUserType;
				}
			}
		}
		return $arUserTypes; 
	}




	/////////////////////
	// sdemon72
	// Скопированы без изменения (для совместимости):
	
	
	 
	// Скопирована из класса \Bitrix\Sale\Exchange\ImportOneCPackage (/bitrix/modules/sale/lib/exchange/importonecpackage.php)
	private function importableItems($item)
	{
		if($item->getId() == null && !$item->isImportable())
		{
			switch ($item->getOwnerTypeId())
			{
				case static::getParentEntityTypeId():
				case EntityType::USER_PROFILE:
					return false;
					break;
			}
		}

		return true;
	}


	/////////////////////////
	// Все нижеследующее скопировано из класса \Bitrix\Sale\Exchange\ImportOneCPackageSale (/bitrix/modules/sale/lib/exchange/importonecpackagesale.php)
	

	/**
	 * @param OneC\OrderDocument $document
	 * @return null|string
	 */
	protected function getDefaultTrackingNumber(OneC\OrderDocument $document)
	{
		$fields = $document->getFieldValues();
		return isset($fields['REK_VALUES']['1C_TRACKING_NUMBER'])?$fields['REK_VALUES']['1C_TRACKING_NUMBER']:null;
	}

	/**
	 * @param OneC\OrderDocument $document
	 * @return null|int
	 */
	protected function getDefaultPaySystem(OneC\OrderDocument $document)
	{
		$fields = $document->getFieldValues();
		return isset($fields['REK_VALUES']['PAY_SYSTEM_ID'])?$fields['REK_VALUES']['PAY_SYSTEM_ID']:null;
	}

	/**
	 * @param OneC\OrderDocument $document
	 * @return null|int
	 */
	protected function getDefaultDeliverySystem(OneC\OrderDocument $document)
	{
		$fields = $document->getFieldValues();
		return isset($fields['REK_VALUES']['DELIVERY_SYSTEM_ID'])?$fields['REK_VALUES']['DELIVERY_SYSTEM_ID']:null;
	}

	/**
	 * @param OrderImport $orderImport
	 * @param array $items
	 * @return Result
	 * @deprecated
	 */
	protected function UpdateCashBoxChecks(OrderImport $orderImport, array $items)
	{
		$result = new Result();
		$bCheckUpdated = false;

		$order = $orderImport->getEntity();

		foreach ($items as $item)
		{
			/** @var PaymentImport $item */

			if($item->getOwnerTypeId() == static::getPaymentCashEntityTypeId() ||
				$item->getOwnerTypeId() == static::getPaymentCashLessEntityTypeId() ||
				$item->getOwnerTypeId() == static::getPaymentCardEntityTypeId()
			)
			{
				/** @var  $params */
				$params = $item->getFieldValues();
				static::load($item, $params['TRAITS'], $order);

				if($item->getEntityId()>0)
				{
					$entity = $item->getEntity();

					if(isset($params['CASH_BOX_CHECKS']))
					{
						$fields = $params['CASH_BOX_CHECKS'];

						if($fields['ID']>0)
						{
							$res = CashboxCheckTable::getById($fields['ID']);
							if ($data = $res->fetch())
							{
								if($data['STATUS']<>'Y')
								{
									$applyResult = Cashbox1C::applyCheckResult($params['CASH_BOX_CHECKS']);
									$bCheckUpdated = $applyResult->isSuccess();
								}
							}
							else
							{
								$item->setCollisions(EntityCollisionType::PaymentCashBoxCheckNotFound, $entity);
							}
						}
					}
				}
			}
		}

		/** @var OneC\CollisionOrder $collision */
		$collision = $orderImport->getCurrentCollision(EntityType::ORDER);
		$collisionTypes = $collision->getCollision($orderImport);

		if(count($collisionTypes)>0 && $bCheckUpdated)
		{
			return $result;
		}
		else
		{
			$result->addError(new Error('', 'CASH_BOX_CHECK_IGNORE'));
		}

		return $result;
	}

}
