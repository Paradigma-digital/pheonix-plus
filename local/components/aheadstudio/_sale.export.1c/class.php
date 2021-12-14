<?php
class CSaleExport2 extends CSaleExport {
	static function ExportOrders2Xml($arFilter = Array(), $nTopCount = 0, $currency = "", $crmMode = false, $time_limit = 0, $version = false, $arOptions = Array())
	{
		$lastOrderPrefix = '';
		$arCharSets = array();

	    self::setVersionSchema($version);
		self::setCrmMode($crmMode);
		self::setCurrencySchema($currency);

		$count = false;
		if(IntVal($nTopCount) > 0)
			$count = Array("nTopCount" => $nTopCount);

		$end_time = self::getEndTime($time_limit);

		if(IntVal($time_limit) > 0)
		{
			if(self::$crmMode)
			{
				$lastOrderPrefix = md5(serialize($arFilter));
				if(!empty($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && IntVal($nTopCount) > 0)
					$count["nTopCount"] = $count["nTopCount"]+count($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]);
			}
		}

		if(!self::$crmMode)
			$arFilter = static::prepareFilter($arFilter);

		self::$arResultStat = array(
			"ORDERS" => 0,
			"CONTACTS" => 0,
			"COMPANIES" => 0,
		);

		$bExportFromCrm = self::isExportFromCRM($arOptions);

		$arStore = self::getCatalogStore();
		$arMeasures = self::getCatalogMeasure();
		self::setCatalogMeasure($arMeasures);
		$arAgent = self::getSaleExport();

		if (self::$crmMode)
		{
			self::setXmlEncoding("UTF-8");
			$arCharSets = self::getSite();
		}

		echo self::getXmlRootName();?>

<<?=CSaleExport::getTagName("SALE_EXPORT_COM_INFORMATION")?> 




<?=self::getCmrXmlRootNameParams()?>>



		<?
        // Get users. Custom development
        $dbUsersList = CUser::GetList(
	       $order,
	        $tmp,
	        Array(
		        "UF_EXPORTED_1C" => "",
		        //"UF_EXPORTED_1C" => "Y",
	        ),
	        Array(
		        "SELECT" => Array("ID", "NAME", "EMAIL", "UF_INN", "UF_BIK", "UF_BILL", "WORK_COMPANY", "PERSONAL_PHONE", "WORK_CITY", "TIMESTAMP_X", "SECOND_NAME")
	        )
        );
        $arUsersList = Array();
        while($arUserItem = $dbUsersList->Fetch()) {
	       //deb($arUserItem);
	       if(!$arUserItem["XML_ID"]) {
		   		//deb($arUserItem);
		   		$arUserItem["XML_ID"] = htmlspecialcharsbx(substr($arUserItem["ID"]."#".$arUserItem["LOGIN"]."#".$arUserItem["LAST_NAME"]." ".$arUserItem["NAME"]." ".$arUserItem["SECOND_NAME"], 0, 80));
		   		$user = new CUser;
		   		$user->Update($arUserItem["ID"], Array(
			   		"XML_ID" => $arUserItem["XML_ID"],
		   		));
	       }
	       
	        $arUsersList[] = Array(
		        "ID" => $arUserItem["XML_ID"], // Ид
		        "BX_ID" => $arUserItem["ID"],
		        "DATE_REGISTER" => $arUserItem["DATE_REGISTER"],
				"DATE_UPDATE" => $arUserItem["TIMESTAMP_X"], // ДатаОбновления
				"ACTIVE" => ($arUserItem["ACTIVE"] == "Y" ? 0 : 1), // ПометкаУдаления
				"LOGIN" => $arUserItem["LOGIN"], // Наименование
				"LAST_NAME" => $arUserItem["LAST_NAME"], // Фамилия
		        "NAME" => $arUserItem["NAME"], // Имя
		        "SECOND_NAME" => $arUserItem["SECOND_NAME"], // Отчество
		        "EMAIL" => $arUserItem["EMAIL"], // Электронная почта
				"INN" => $arUserItem["UF_INN"], // ИНН
				"BIK" => $arUserItem["UF_BIK"], // Бик
				"BILL" => $arUserItem["UF_BILL"], // НомерСчета
				"COMPANY" => $arUserItem["WORK_COMPANY"], // ОфициальноеНаименование
				"PHONE" => $arUserItem["PERSONAL_PHONE"], // Телефон рабочий
				"CITY" => $arUserItem["WORK_CITY"], // Город
	        );
        }
        unset($user);
       //deb($arUsersList);
        self::OutputXmlDocument("Users", $arUsersList, Array(), false);
       // die;
       // echo "<pre>"; print_r($dbOrderList->Fetch()); echo "</pre>"; die;
       foreach($arUsersList as $arUserItem) {
	   		$user = new CUser;
	   		$user->Update($arUserItem["BX_ID"], Array(
		   		"UF_EXPORTED_1C" => "Y",
	   		));
       }
       unset($arUserItem);
	   // //
	   ?>


<?

		$arOrder = array("DATE_UPDATE" => "ASC");

		$arSelect = array(
			"ID", "LID", "PERSON_TYPE_ID", "PAYED", "DATE_PAYED", "EMP_PAYED_ID", "CANCELED", "DATE_CANCELED",
			"EMP_CANCELED_ID", "REASON_CANCELED", "STATUS_ID", "DATE_STATUS", "PAY_VOUCHER_NUM", "PAY_VOUCHER_DATE", "EMP_STATUS_ID",
			"PRICE_DELIVERY", "ALLOW_DELIVERY", "DATE_ALLOW_DELIVERY", "EMP_ALLOW_DELIVERY_ID", "PRICE", "CURRENCY", "DISCOUNT_VALUE",
			"SUM_PAID", "USER_ID", "PAY_SYSTEM_ID", "DELIVERY_ID", "DATE_INSERT", "DATE_INSERT_FORMAT", "DATE_UPDATE", "USER_DESCRIPTION",
			"ADDITIONAL_INFO",
			"COMMENTS", "TAX_VALUE", "STAT_GID", "RECURRING_ID", "ACCOUNT_NUMBER", "SUM_PAID", "DELIVERY_DOC_DATE", "DELIVERY_DOC_NUM", "TRACKING_NUMBER", "STORE_ID",
			"ID_1C", "VERSION",
			"USER.XML_ID"
		);

		$bCrmModuleIncluded = false;
		if ($bExportFromCrm)
		{
			$arSelect[] = "UF_COMPANY_ID";
			$arSelect[] = "UF_CONTACT_ID";
			if (IsModuleInstalled("crm") && CModule::IncludeModule("crm"))
				$bCrmModuleIncluded = true;
		}

		$arFilter['RUNNING'] = 'N';

		$filter = array(
			'select' => $arSelect,
			'filter' => $arFilter,
			'order'  => $arOrder,
			'limit'  => $count["nTopCount"]
		);

		if (!empty($arOptions['RUNTIME']) && is_array($arOptions['RUNTIME']))
		{
			$filter['runtime'] = $arOptions['RUNTIME'];
		}

        $dbOrderList = \Bitrix\Sale\Internals\OrderTable::getList($filter);
$order = array('sort' => 'asc');
$tmp = 'sort'; // параметр проигнорируется методом, но обязан быть
        
        
        
        






		while($arOrder = $dbOrderList->Fetch())
		{
		    $order = \Bitrix\Sale\Order::load($arOrder['ID']);
			$arOrder['DATE_STATUS'] = $arOrder['DATE_STATUS']->toString();
		    $arOrder['DATE_INSERT'] = $arOrder['DATE_INSERT']->toString();
		    $arOrder['DATE_UPDATE'] = $arOrder['DATE_UPDATE']->toString();

			foreach($arOrder as $field=>$value)
			{
			    if(self::isFormattedDateFields('Order', $field))
			    {
			        $arOrder[$field] = self::getFormatDate($value);
			    }
			}

			if (self::$crmMode)
			{
				if(self::getVersionSchema() > self::DEFAULT_VERSION && is_array($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && in_array($arOrder["ID"], $_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && empty($arFilter["ID"]))
					continue;
				ob_start();
			}

			self::$arResultStat["ORDERS"]++;

			$agentParams = (array_key_exists($arOrder["PERSON_TYPE_ID"], $arAgent) ? $arAgent[$arOrder["PERSON_TYPE_ID"]] : array() );

            $arResultPayment = self::getPayment($arOrder);
            $paySystems = $arResultPayment['paySystems'];
            $arPayment = $arResultPayment['payment'];

			$arResultShipment = self::getShipment($arOrder);
			$arShipment = $arResultShipment['shipment'];
			$delivery = $arResultShipment['deliveryServices'];

			self::setDeliveryAddress('');
			self::setSiteNameByOrder($arOrder);

			$arProp = self::prepareSaleProperty($arOrder, $bExportFromCrm, $bCrmModuleIncluded, $paySystems, $delivery, $locationStreetPropertyValue);
			$agent = self::prepareSalePropertyRekv($order, $agentParams, $arProp, $locationStreetPropertyValue);

			$arOrderTax = CSaleExport::getOrderTax($arOrder["ID"]);
			$xmlResult['OrderTax'] = self::getXMLOrderTax($arOrderTax);
			self::setOrderSumTaxMoney(self::getOrderSumTaxMoney($arOrderTax));

			$xmlResult['Contragents'] = self::getXmlContragents($arOrder, $arProp, $agent, $bExportFromCrm ? array("EXPORT_FROM_CRM" => "Y") : array());
			
			
			//echo "<pre>"; print_r($xmlResult['Contragents']); echo "</pre>"; die;
			
			
			$xmlResult['OrderDiscount'] = self::getXmlOrderDiscount($arOrder);
			$xmlResult['SaleStoreList'] = $arStore;
			$xmlResult['ShipmentsStoreList'] = self::getShipmentsStoreList($order);
			// self::getXmlSaleStoreBasket($arOrder,$arStore);
			$basketItems = self::getXmlBasketItems('Order', $arOrder, array('ORDER_ID'=>$arOrder['ID']), array(), $arShipment);

            $numberItems = array();
            foreach($basketItems['result'] as $basketItem)
            {
                $number = self::getNumberBasketPosition($basketItem["ID"]);

                if(in_array($number, $numberItems))
                {
                    $order->setField('MARKED','Y');
                    $order->setField('REASON_MARKED', GetMessage("SALE_EXPORT_REASON_MARKED_BASKET_PROPERTY").'1C_Exchange:Order.export.basket.properties');
                    $order->save();
                    break;
                }
                else
                {
                    $numberItems[] = $number;
                }
            }

			$xmlResult['BasketItems'] = $basketItems['outputXML'];
			$xmlResult['SaleProperties'] = self::getXmlSaleProperties($arOrder, $arShipment, $arPayment, $agent, $agentParams, $bExportFromCrm);
			$xmlResult['RekvProperties'] = self::getXmlRekvProperties($agent, $agentParams);


			if(self::getVersionSchema() >= self::CONTAINER_VERSION)
            {
				echo '<'.CSaleExport::getTagName("SALE_EXPORT_CONTAINER").'>';
            }

			self::OutputXmlDocument('Order', $xmlResult, $arOrder);

			if(self::getVersionSchema() >= self::PARTIAL_VERSION)
			{
				self::OutputXmlDocumentsByType('Payment',$xmlResult, $arOrder, $arPayment, $order, $agentParams, $arProp, $locationStreetPropertyValue);
				self::OutputXmlDocumentsByType('Shipment',$xmlResult, $arOrder, $arShipment, $order, $agentParams, $arProp, $locationStreetPropertyValue);
				self::OutputXmlDocumentRemove('Shipment',$arOrder);
			}

			if(self::getVersionSchema() >= self::CONTAINER_VERSION)
			{
				echo '</'.CSaleExport::getTagName("SALE_EXPORT_CONTAINER").'>';
			}

			if (self::$crmMode)
			{
				$c = ob_get_clean();
				$c = CharsetConverter::ConvertCharset($c, $arCharSets[$arOrder["LID"]], "utf-8");
				echo $c;
				$_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix][] = $arOrder["ID"];
			}
			else
			{
				static::saveExportParams($arOrder);
			}

			if(self::checkTimeIsOver($time_limit, $end_time))
			{
				break;
			}
		}
		?>

	</<?=CSaleExport::getTagName("SALE_EXPORT_COM_INFORMATION")?>><?

		return self::$arResultStat;
	}
	
	
	static function OutputXmlDocument($typeDocument,$xmlResult, $document=array(), $displayDocument = true)
	{
		global $DB;
		?>
		
		<?php if($displayDocument): ?>
	<<?=CSaleExport::getTagName("SALE_EXPORT_DOCUMENT")?>>
		<?php endif; ?>
	<?
		switch($typeDocument)
		{
			case 'Order':
		?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>><?=$document["ID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER")?>><?=self::getAccountNumberShopPrefix();?><?=$document["ACCOUNT_NUMBER"]?></<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>><?=$DB->FormatDate($document["DATE_INSERT_FORMAT"], CSite::GetDateFormat("FULL"), "YYYY-MM-DD")?></<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM_ORDER")?></<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_ROLE")?>><?=CSaleExport::getTagName("SALE_EXPORT_SELLER")?></<?=CSaleExport::getTagName("SALE_EXPORT_ROLE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY")?>><?=htmlspecialcharsbx(((strlen(self::$currency)>0)?substr(self::$currency, 0, 3):substr($document["CURRENCY"], 0, 3)))?></<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY_RATE")?>>1</<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY_RATE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$document["PRICE"]?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
				<?
				if(self::getVersionSchema() > self::DEFAULT_VERSION)
				{
					?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_VERSION")?>><?=(IntVal($document["VERSION"]) > 0 ? $document["VERSION"] : 0)?></<?=CSaleExport::getTagName("SALE_EXPORT_VERSION")?>><?
					if(strlen($document["ID_1C"]) > 0)
					{
						?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_ID_1C")?>><?=htmlspecialcharsbx($document["ID_1C"])?></<?=CSaleExport::getTagName("SALE_EXPORT_ID_1C")?>><?
					}
				}
				if (self::$crmMode)
				{
			?><DateUpdate><?=$DB->FormatDate($document["DATE_UPDATE"], CSite::GetDateFormat("FULL"), "YYYY-MM-DD HH:MI:SS");?></DateUpdate><?
				}
				echo $xmlResult['Contragents'];
			?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>><?=$DB->FormatDate($document["DATE_INSERT_FORMAT"], CSite::GetDateFormat("FULL"), "HH:MI:SS")?></<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_COMMENTS")?>><?=htmlspecialcharsbx($document["COMMENTS"])?></<?=CSaleExport::getTagName("SALE_EXPORT_COMMENTS")?>>
			<?	echo $xmlResult['OrderTax'];
				echo $xmlResult['OrderDiscount'];
				echo self::getXmlSaleStore(array_unique($xmlResult['ShipmentsStoreList'], SORT_NUMERIC), $xmlResult['SaleStoreList']);
				//$storeBasket = self::getXmlSaleStoreBasket($document,$arStore);
				echo $xmlResult['BasketItems'];
				echo $xmlResult['SaleProperties'];
			break;
			
			
			
			
			
			
			
			case 'Users': ?>
				<Контрагенты>
				<?php foreach($xmlResult as $arXmlItem): ?>
					<Контрагент>
						<Ид><?php echo $arXmlItem["ID"]; ?></Ид>
						<ДатаОбновления><?php echo $arXmlItem["DATE_UPDATE"]; ?></ДатаОбновления>
						<ДатаРегистрации><?php echo $arXmlItem["DATE_REGISTER"]; ?></ДатаРегистрации>
						<ПометкаУдаления><?php echo $arXmlItem["ACTIVE"]; ?></ПометкаУдаления>
						<Наименование><?php echo $arXmlItem["LOGIN"]; ?></Наименование>
						<Фамилия><?php echo $arXmlItem["SURNAME"]; ?></Фамилия>
						<Имя><?php echo $arXmlItem["NAME"]; ?></Имя>
						<Отчество><?php echo $arXmlItem["SECOND_NAME"]; ?></Отчество>
						<ОфициальноеНаименование><?php echo $arXmlItem["COMPANY"]; ?></ОфициальноеНаименование>
						<ИНН><?php echo $arXmlItem["INN"]; ?></ИНН>
						<ЮридическийАдрес>
							<АдресноеПоле>
								<Тип>Город</Тип>
								<Значение><?php echo $arXmlItem["CITY"]; ?></Значение>
							</АдресноеПоле>
						</ЮридическийАдрес>
						<РасчетныеСчета>
							<РасчетныйСчет>
								<НомерСчета><?php echo $arXmlItem["BILL"]; ?></НомерСчета>
								<Банк>
									<Бик><?php echo $arXmlItem["BIK"]; ?></Бик>
								</Банк>
							</РасчетныйСчет>
						</РасчетныеСчета>
						<Контакты>
							<Контакт>
								<Тип>Телефон рабочий</Тип>
								<Значение><?php echo $arXmlItem["PHONE"]; ?></Значение>
							</Контакт>
							<Контакт>
								<Тип>Электронная почта</Тип>
								<Значение><?php echo $arXmlItem["EMAIL"]; ?></Значение>
							</Контакт>
						</Контакты>
					</Контрагент>
				<?php endforeach; unset($arXmlItem); ?>
				</Контрагенты>
			<?php break;
				
				
				
				
				
				

			case 'Payment':
			case 'Shipment':
			?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>><?=(strlen($document["ID_1C"])>0 ? $document["ID_1C"]:$document["ID"])?></<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER")?>><?=$document["ID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER")?>>
		<?	switch($typeDocument)
			{
				case 'Payment':
		?>

		<<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>><?=$DB->FormatDate($document["DATE_BILL"], CSite::GetDateFormat("FULL"), "YYYY-MM-DD")?></<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM_PAYMENT_".\Bitrix\Sale\PaySystem\Manager::getPsType($document['PAY_SYSTEM_ID']))?></<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>>
		<?		break;
				case 'Shipment':?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>><?=$DB->FormatDate($document["DATE_INSERT"], CSite::GetDateFormat("FULL"), "YYYY-MM-DD")?></<?=CSaleExport::getTagName("SALE_EXPORT_DATE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM_SHIPMENT")?></<?=CSaleExport::getTagName("SALE_EXPORT_HOZ_OPERATION")?>>
		<?		break;
			}?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_ROLE")?>><?=CSaleExport::getTagName("SALE_EXPORT_SELLER")?></<?=CSaleExport::getTagName("SALE_EXPORT_ROLE")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY")?>><?=htmlspecialcharsbx(((strlen(self::$currency)>0)?substr(self::$currency, 0, 3):substr($document["CURRENCY"], 0, 3)))?></<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY_RATE")?>>1</<?=CSaleExport::getTagName("SALE_EXPORT_CURRENCY_RATE")?>>
		<?	switch($typeDocument)
			{
				case 'Payment':
		?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$document['SUM']?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
		<?		break;
				case 'Shipment':
                    $price = 0;
                    if(count($document['BasketResult'])>0)
                    {
                        foreach($document['BasketResult'] as $basketItem)
                        {
                            $price = $price + $basketItem['PRICE'] * $basketItem['SALE_INTERNALS_BASKET_SHIPMENT_ITEM_QUANTITY'];
                        }
                    }
		?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$price+intval($document['PRICE_DELIVERY'])?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
		<?		break;
			}?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_VERSION")?>><?=(IntVal($document["VERSION"]) > 0 ? $document["VERSION"] : 0)?></<?=CSaleExport::getTagName("SALE_EXPORT_VERSION")?>>
		<<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER_BASE")?>><?=$document['ORDER_ID']?></<?=CSaleExport::getTagName("SALE_EXPORT_NUMBER_BASE")?>>
		<?=$xmlResult['Contragents'];?>
		<?	switch($typeDocument)
			{
				case 'Payment':
		?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>><?=$DB->FormatDate($document["DATE_BILL"], CSite::GetDateFormat("FULL"), "HH:MI:SS")?></<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>>
		<?		break;
				case 'Shipment':?>
				<?=$xmlResult['OrderTax'];?>
				<?
				if(isset($xmlResult['ShipmentsStoreList'][$document["ID"]]))
				{
				    $storId = $xmlResult['ShipmentsStoreList'][$document["ID"]];
				    echo self::getXmlSaleStore(array($document["ID"]=>$storId), $xmlResult['SaleStoreList']);
				}?>

		<<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>><?=$DB->FormatDate($document["DATE_INSERT"], CSite::GetDateFormat("FULL"), "HH:MI:SS")?></<?=CSaleExport::getTagName("SALE_EXPORT_TIME")?>>
		<?		break;
			}?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_COMMENTS")?>><?=htmlspecialcharsbx($document["COMMENTS"])?></<?=CSaleExport::getTagName("SALE_EXPORT_COMMENTS")?>>

		<?	switch($typeDocument)
			{
				case 'Payment':

					$checkData = false;
				    $cashBoxOneCId = self::getCashBoxOneCId();
					if(isset($cashBoxOneCId) && $cashBoxOneCId>0)
                    {
                        $checks = \Bitrix\Sale\Cashbox\CheckManager::getPrintableChecks(array($cashBoxOneCId), array($document['ORDER_ID']));
						foreach($checks as $checkId=>$check)
                        {
							if($check['PAYMENT_ID']==$document["ID"])
                            {
								$checkData = $check;
                                break;
                            }
                        }
                    }
		?>
        <?
             if($checkData)
             {
        ?>
                 <<?=CSaleExport::getTagName("SALE_EXPORT_CASHBOX_CHECKS")?>>
                    <<?=CSaleExport::getTagName("SALE_EXPORT_CASHBOX_CHECK")?>>
                        <<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>><?=($checkData['ID'])?></<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>
                        <<?=CSaleExport::getTagName("SALE_EXPORT_PROP_VALUES")?>>
                            <<?=CSaleExport::getTagName("SALE_EXPORT_PROP_VALUE")?>>
                                <<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>PRINT_CHECK</<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>
                                <<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>true</<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
                            </<?=CSaleExport::getTagName("SALE_EXPORT_PROP_VALUE")?>>
                        </<?=CSaleExport::getTagName("SALE_EXPORT_PROP_VALUES")?>>
                    </<?=CSaleExport::getTagName("SALE_EXPORT_CASHBOX_CHECK")?>>
                 </<?=CSaleExport::getTagName("SALE_EXPORT_CASHBOX_CHECKS")?>>
        <?
             }
        ?>
		<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DATE_PAID")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DATE_PAID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_CANCELED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["CANCELED"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PAY_SYSTEM_ID")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["PAY_SYSTEM_ID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PAY_SYSTEM")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["PAY_SYSTEM_NAME"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PAY_PAID")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["PAID"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PAY_RETURN")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["IS_RETURN"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PAY_RETURN_REASON")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["PAY_RETURN_COMMENT"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<?self::OutputXmlSiteName($document);?>
            <?if(isset($xmlResult['RekvProperties']) && strlen($xmlResult['RekvProperties'])>0) echo $xmlResult['RekvProperties'];?>
		</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
			<?	break;

				case 'Shipment':
			?>

			<?
			echo $xmlResult['BasketItems'];
			?>

		<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
		    <<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PRICE_DELIVERY")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=(strlen($document["PRICE_DELIVERY"])>0? $document["PRICE_DELIVERY"]:"0.0000")?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DATE_ALLOW_DELIVERY")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DATE_ALLOW_DELIVERY"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY_LOCATION")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DELIVERY_LOCATION"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY_STATUS")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["STATUS_ID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY_DEDUCTED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["DEDUCTED"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DATE_DEDUCTED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DATE_DEDUCTED"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_REASON_UNDO_DEDUCTED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["REASON_UNDO_DEDUCTED"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_RESERVED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["RESERVED"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY_ID")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DELIVERY_ID"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DELIVERY_NAME"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_CANCELED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=($document["CANCELED"]=='Y'? 'true':'false')?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_DELIVERY_DATE_CANCEL")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["DATE_CANCELED"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=GetMessage("SALE_EXPORT_CANCEL_REASON")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["REASON_CANCELED"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_REASON_MARKED")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["REASON_MARKED"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
			</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
            <<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
                <<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_TRACKING_NUMBER")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
                <<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$document["TRACKING_NUMBER"]?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
            </<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
			<?self::OutputXmlSiteName($document);?>
			<?self::OutputXmlDeliveryAddress();?>
			<?if(isset($xmlResult['RekvProperties']) && strlen($xmlResult['RekvProperties'])>0) echo $xmlResult['RekvProperties'];?>
	</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
			<?
				break;
			}
		}
		?>
	
	<?php if($displayDocument): ?>
		</<?=CSaleExport::getTagName("SALE_EXPORT_DOCUMENT")?>>
	<?php endif; ?>
		
		
	<?
	}



}
?>