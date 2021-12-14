<?php
// sdemon72 20200703
use Bitrix\Main\Type\DateTime;

// _sdemon72 20200703


class CGC1C
{

	function exportUsers()
	{
		$dbUsers = CUser::GetList(
			($order = "ID"),
			($desc = "DESC"),
			array(
				"UF_EXPORTED_1C" => "",
				//"UF_EXPORTED_1C" => "Y",
			),
			array(
				"SELECT" => array(
					"ID",
					"NAME",
					"EMAIL",
					"UF_INN",
					"UF_BIK",
					"UF_BILL",
					"WORK_COMPANY",
					"WORK_PHONE",
					"WORK_CITY",
					"TIMESTAMP_X",
					"SECOND_NAME",
					"UF_PROFILES",
					"WORK_ZIP",
					"WORK_STATE",
					"WORK_CITY",
					"WORK_STREET",
					"WORK_COMPANY",
					"XML_ID",
					"UF_USER_TYPE",
					"UF_PROFILE_COMPLETE",
					"UF_SUBSCRIBE_PARTNER",
					// sdemon72 20200703
					"UF_PRICE_ID",
					"UF_NDS",
					"UF_MANAGER",
					// _sdemon72 20200703
					"UF_REGISTER_PROMO"),
			)
		);
		$arUsers = array();
		$arUsersIDs = [];

		$arUserTypes = CGCUser::getUserTypes();
		//deb($arUserTypes);

		while ($arUser = $dbUsers->Fetch()) {
			//deb($arUser);
			if (!$arUser["XML_ID"]) {
				//deb($arUserItem);
				$arUser["XML_ID"] = htmlspecialcharsbx(trim($arUser["ID"] . "#" . $arUser["LOGIN"] . "#"));

				$dbUser = new CUser;
				$dbUser->Update($arUser["ID"], array(
					"XML_ID" => $arUser["XML_ID"],
				));
			}

			// Получение агентов пользователя
			$arUserAgents = CGCHelper::getHlElements(2, array(
				"ID" => $arUser["UF_PROFILES"]
			));

			// sdemon72 20200703 Получить менеджера
			$arUserManagers = CGCHelper::getHlElements(3, array(
				"ID" => $arUser["UF_MANAGER"]
			));
			if (count($arUserManagers) > 0) {
				$arUserManager = $arUserManagers[0];
			}
			// _sdemon72 20200703

			/*if($arUserAgents) {
                deb($arUserAgents);
            }*/

			$arUsers[] = array(
				"ID" => $arUser["XML_ID"], // Ид
				"BX_ID" => $arUser["ID"],
				"DATE_REGISTER" => $arUser["DATE_REGISTER"],
				"DATE_UPDATE" => $arUser["TIMESTAMP_X"], // ДатаОбновления
				"ACTIVE" => ($arUser["ACTIVE"] == "Y" ? 0 : 1), // ПометкаУдаления
				"LOGIN" => $arUser["LOGIN"], // Наименование
				"LAST_NAME" => $arUser["LAST_NAME"], // Фамилия
				"NAME" => $arUser["NAME"], // Имя
				"SECOND_NAME" => $arUser["SECOND_NAME"], // Отчество
				"EMAIL" => $arUser["EMAIL"], // Электронная почта
				"INN" => $arUser["UF_INN"], // ИНН
				"BIK" => $arUser["UF_BIK"], // Бик
				"BILL" => $arUser["UF_BILL"], // НомерСчета
				"COMPANY" => $arUser["WORK_COMPANY"], // ОфициальноеНаименование
				"PHONE" => $arUser["WORK_PHONE"], // Телефон рабочий
				"CITY" => $arUser["WORK_CITY"], // Город
				"AGENTS" => $arUserAgents, // Агенты,
				"WORK_COMPANY" => $arUser["WORK_COMPANY"], // Название компании
				"WORK_ZIP" => $arUser["WORK_ZIP"],
				"WORK_STATE" => $arUser["WORK_STATE"],
				"WORK_CITY" => $arUser["WORK_CITY"],
				"WORK_STREET" => $arUser["WORK_STREET"],

				"USER_TYPE" => ($arUser["UF_USER_TYPE"] ? $arUserTypes[$arUser["UF_USER_TYPE"]]["XML_ID"] : "SIMPLE"),
				"PROFILE_COMPLETE" => $arUser["UF_PROFILE_COMPLETE"], // заполнен профиль юзера
				"SUBSCRIBE_PARTNER" => $arUser["UF_SUBSCRIBE_PARTNER"], // поставлена галочка на получение рассылки
				// sdemon72 20200703
				"PRICE_ID" => $arUser["UF_PRICE_ID"], // Ид типа цены
				"NDS" => $arUser["UF_NDS"], // Способ начисления НДС
				"MANAGER" => $arUserManager, // Менеджер
				// _sdemon72 20200703

				"REGISTER_PROMO" => $arUser["UF_REGISTER_PROMO"], // промокод при регистрации

			);
			$arUsersIDs[] = $arUser["ID"];
		}
		//deb($arUsers);

		if ($arUsers) {
			return [
				"IDS" => $arUsersIDs,
				"DATA" => $arUsers,
			];
		}

	}

	public function makeXMLFromTemplate($arUsers, $addHeader = true, $addFooter = true)
	{
		$xml = "";

		if ($addHeader) {
			$xml .= '<?xml version="1.0" encoding="windows-1251"?>' . PHP_EOL .
				'<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
				' ВерсияСхемы="3.1" ДатаФормирования="' . date(DATE_ISO8601, time()) . '">' .
				'<Контрагенты СодержитТолькоИзменения="true">';
		}

		if ($arUsers) {
			foreach ($arUsers as $arUser) {
				$arXmlAddress = [$arUser["WORK_ZIP"], $arUser["WORK_STATE"], $arUser["WORK_CITY"], $arUser["WORK_STREET"]];
				$strXmlAddress = "";
				foreach ($arXmlAddress as $i => $arXmlAddressItem) {
					$arXmlAddressItem = trim($arXmlAddressItem);
					if ($arXmlAddressItem) {
						$strXmlAddress .= $arXmlAddressItem . ", ";
					}
				}
				unset($arXmlAddressItem);
				$strXmlAddress = substr($strXmlAddress, 0, strlen($strXmlAddress) - 2);


				$xml .= '<Контрагент>' .
					'<Ид>' . $arUser["ID"] . '</Ид>' .
					'<ДатаРегистрации>' . $arUser["DATE_REGISTER"] . '</ДатаРегистрации>' .
					'<ДатаОбновления>' . $arUser["DATE_UPDATE"] . '</ДатаОбновления>' . // sdemon72 20200703
					'<ПометкаУдаления>' . $arUser["ACTIVE"] . '</ПометкаУдаления>' .
					'<Наименование>' . $arUser["LOGIN"] . '</Наименование>' .
					'<ПолноеНаименование>' . htmlspecialcharsbx($arUser["WORK_COMPANY"]) . '</ПолноеНаименование>' .
					'<Роль>Покупатель</Роль>' .
					'<ИНН>' . $arUser["INN"] . '</ИНН>' .
					'<Фамилия>' . $arUser["LAST_NAME"] . '</Фамилия>' .
					'<Имя>' . $arUser["NAME"] . '</Имя>' .
					'<Отчество>' . $arUser["SECOND_NAME"] . '</Отчество>' .

					'<ТипПользователя>' . $arUser["USER_TYPE"] . '</ТипПользователя>' .
					'<ЗаполненПрофильПартнера>' . $arUser["PROFILE_COMPLETE"] . '</ЗаполненПрофильПартнера>' .
					'<ПодпискаНаРассылку>' . $arUser["SUBSCRIBE_PARTNER"] . '</ПодпискаНаРассылку>' .

					// sdemon72 20200703
					'<ТипЦен>' . $arUser["PRICE_ID"] . '</ТипЦен>' .
					'<НДС>' . $arUser["NDS"] . '</НДС>' .
					'<Менеджер>' . ($arUser["MANAGER"] ? $arUser["MANAGER"]["UF_XML_ID"] : "") . '</Менеджер>' .
					// _sdemon72 20200703

					'<ПромокодПриРегистрации>' . $arUser["REGISTER_PROMO"] . '</ПромокодПриРегистрации>';

				if ($strXmlAddress || $arUser["CITY"]) {
					$xml .= '<Адрес>';
					if ($strXmlAddress) {
						$xml .= '<Представление>' . $strXmlAddress . '</Представление>';
					}
					if ($arUser["CITY"]) {
						$xml .= '<АдресноеПоле>' .
							'<Тип>Город</Тип>' .
							'<Значение>' . $arUser["CITY"] . '</Значение>' .
							'</АдресноеПоле>';
					}
					$xml .= '</Адрес>';
				}

				if ($arUser["EMAIL"] || $arUser["PHONE"]) {
					$xml .= '<Контакты>';
					if ($arUser["EMAIL"]) {
						$xml .= '<Контакт>' .
							'<Тип>Электронная почта</Тип>' .
							'<Значение>' . $arUser["EMAIL"] . '</Значение>' .
							'</Контакт>';
					}
					if ($arUser["PHONE"]) {
						$xml .= '<Контакт>' .
							'<Тип>Телефон рабочий</Тип>' .
							'<Значение>' . $arUser["PHONE"] . '</Значение>' .
							'</Контакт>';
					}
					$xml .= '</Контакты>';
				}

				if ($arUser["AGENTS"]) {
					$xml .= '<Представители>';
					foreach ($arUser["AGENTS"] as $arUserAgent) {
						$xml .= '<Представитель>' .
							'<Отношение>Грузополучатель</Отношение>' .
							'<Ид>' . $arUserAgent["UF_XML_ID"] . '</Ид>' .
							'<Наименование>' . $arUserAgent["UF_NAME"] . '</Наименование>' .
							'<ИНН>' . $arUserAgent["UF_INN"] . '</ИНН>' .
							'<КПП>' . $arUserAgent["UF_KPP"] . '</КПП>' .
							'</Представитель>';
					}
					$xml .= '</Представители>';

				}


				$xml .= '</Контрагент>';
			}
			unset($arUser);
		}

		if ($addFooter) {
			$xml .= '</Контрагенты>' .
				'</КоммерческаяИнформация>';
		}

		return $xml;
	}

	function importUsers($xmlFileName)
	{

		CModule::IncludeModule("iblock");

		\Bitrix\Main\Diag\Debug::dumpToFile($xmlFileName);
		// Массив полей адреса
		$arAddressFields = [
			"Почтовый индекс" => "ZIP",
			"Страна" => "COUNTRY",
			"Регион" => "REGION",
			"Район" => "DISTRICT",
			"Город" => "CITY",
			"Населенный пункт" => "LOCALITY",
			"Улица" => "STREET",
			"Дом" => "HOUSE",
			"Корпус" => "BUILDING",
			"Квартира" => "APT",
		];

		// Получение типов пользователей
		$arUserTypes = CGCUser::getUserTypesByCodes();

		// Формирование массива пользователей из XML файла
		$arUsers = [];
		$xml = simplexml_load_file($xmlFileName);
		foreach ($xml->Контрагенты->Контрагент as $contr) {
			$arTmpUser = [
				"ID" => (string)$contr->Ид,
				"DEL" => ((string)$contr->ПометкаУдаления == "false" ? 0 : 1),
				"EMAIL" => (string)$contr->Наименование,
				"INN" => (string)$contr->ИНН,
				"NAME" => (string)$contr->Имя,
				"LAST_NAME" => (string)$contr->Фамилия,
				"SECOND_NAME" => (string)$contr->Отчество,
				"WORK_COMPANY" => (string)$contr->ПолноеНаименование,
			];
			// Адрес
			if ($contr->Адрес) {
				$arTmpUser["ADDRESS"] = [];
				foreach ($contr->Адрес->АдресноеПоле as $contrAddress) {
					$arTmpUser["ADDRESS"][$arAddressFields[(string)$contrAddress->Тип]] = (string)$contrAddress->Значение;
				}
			}
			// Контакты
			if ($contr->Контакты) {
				foreach ($contr->Контакты->Контакт as $contrContact) {
					switch ($contrContact->Тип) {
						case "Телефон рабочий":
							$arTmpUser["WORK_PHONE"] = (string)$contrContact->Значение;
							break;
						case "Электронная почта":
							$arTmpUser["EMAIL"] = (string)$contrContact->Значение;
							break;
					}
				}
			}
			// Контрагенты
			if ($contr->Представители) {
				$arTmpUser["AGENTS"] = [];
				foreach ($contr->Представители->Представитель as $agent) {
					$arTmpUser["AGENTS"][] = [
						"ID" => (string)$agent->Ид,
						"NAME" => (string)$agent->Наименование,
						"DESCRIPTION" => (string)$agent->ОфициальноеНаименование,
						"INN" => (string)$agent->ИНН,
						"OKPO" => (string)$agent->ОКПО,
						"KPP" => (string)$agent->КПП,
						"COMMENTS" => (string)$agent->Комментарий,
					];
				}
			}
			// Менеджер
			if ($contr->Менеджер) {
				$arTmpUser["MANAGER"] = [
					"ID" => (string)$contr->Менеджер->Ид,
					"NAME" => (string)$contr->Менеджер->ФИО
				];
				if ($contr->Менеджер->Контакты) {
					foreach ($contr->Менеджер->Контакты->Контакт as $managerContact) {
						switch ($managerContact->Тип) {
							case "Электронная почта":
								$arTmpUser["MANAGER"]["EMAIL"] = (string)$managerContact->Значение;
								break;
							// sdemon72 20200710
							case "Телефон рабочий":
								$arTmpUser["MANAGER"]["PHONE"] = (string)$managerContact->Значение;
								break;    // _sdemon72 20200710
							case "Телефон":
								$arTmpUser["MANAGER"]["PHONE"] = (string)$managerContact->Значение;
								break;
						}
					}
				}

			}
			if ($contr->ИдТипаЦены) {
				$arTmpUser["PRICE_ID"] = (string)$contr->ИдТипаЦены;
			}

			if ($contr->СпособНачисленияНДС) {
				$arTmpUser["NDS"] = (string)$contr->СпособНачисленияНДС;
			}

			if ($contr->УдалитьНаСайте) {
				$arTmpUser["HARD_DELETE"] = ((string)$contr->УдалитьНаСайте == "false" ? "N" : "Y");
			}

			if ($contr->ДоступенПредзаказ == 'true') {
				$arTmpUser["PRE_ORDER"] = "Y";
			}else{
				$arTmpUser["PRE_ORDER"] = "N";
			}

			if ($contr->ТипПользователя) {
				$arTmpUser["USER_TYPE"] = $arUserTypes[(string)$contr->ТипПользователя]["ID"];
			}

			if ($contr->ЗаполненПрофильПартнера) {
				$arTmpUser["PROFILE_COMPLETE"] = ((string)$contr->ЗаполненПрофильПартнера == "false" ? "0" : "1");
			}

			if ($contr->ПодпискаНаРассылку) {
				$arTmpUser["SUBSCRIBE_PARTNER"] = ((string)$contr->ПодпискаНаРассылку == "false" ? "0" : "1");
			}

			$arUsers[] = $arTmpUser;
		}

		// Логируем количество пользователей в файле
		CEventLog::Add([
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "PARTNERS_EXCHANGE",
			"MODULE_ID" => "main",
			"ITEM_ID" => "",
			"DESCRIPTION" => "В файле " . $xmlFileName . " было найдено " . count($arUsers) . " пользователей",
		]);

		// Формируем страны для сохранения в юзере
		$arCountries = [];
		$arTmpCountries = GetCountryArray();
		foreach ($arTmpCountries["reference"] as $refCode => $refValue) {
			$arCountries[$refValue] = $arTmpCountries["reference_id"][$refCode];
		}

		// sdemon72 20200703 небольшой рефакторинг
		//AddMessage2Log($arUsers, "CGC1C->importUsers::arUsers"); // sdemon72

		foreach ($arUsers as $arUser) {

			// Получить данные пользователя из БД
			$dbBxUser = CUser::GetList(
				($order = "ID"),
				($desc = "DESC"),
				array(
					"XML_ID" => $arUser["ID"]
				),
				array(
					"SELECT" => array(
						"ID",
						"NAME",
						"XML_ID",
						"UF_EXPORTED_1C", // sdemon72 20200703
						"UF_PROFILES",
						"UF_INN",
						"UF_MANAGER",
						"UF_NDS",
						"UF_PRICE_ID",
						"UF_HARD_DELETE",
						"ACTIVE",
						"LAST_NAME",
						"SECOND_NAME",
						"WORK_PHONE",
						"WORK_COMPANY",
						"WORK_ZIP",
						"WORK_CITY",
						"WORK_STREET",
						"WORK_STATE", "
						WORK_COUNTRY"
					),
					"NAV_PARAMS" => array(
						"nTopCount" => "1"
					)
				)
			);
			$arBxUser = $dbBxUser->Fetch();


			// sdemon72 20200703 Если пользователь помечен на выгрузку - не загружать из файла
			if ($arBxUser && $arBxUser["UF_EXPORTED_1C"] != "Y") {
				continue;
			}

			// Общий массив для обновления и добавления контрагента
			$arUserAddUpdate = [
				"NAME" => $arUser["NAME"],
				"EMAIL" => $arUser["EMAIL"],
				"LAST_NAME" => $arUser["LAST_NAME"],
				"SECOND_NAME" => $arUser["SECOND_NAME"],
				"WORK_PHONE" => $arUser["WORK_PHONE"],
				"ACTIVE" => ($arUser["DEL"] ? "N" : "Y"),
				"XML_ID" => $arUser["ID"],
				"UF_NDS" => ($arUser["NDS"] ? $arUser["NDS"] : false),
				"UF_HARD_DELETE" => ($arUser["HARD_DELETE"] ? $arUser["HARD_DELETE"] : false),
				"WORK_COMPANY" => $arUser["WORK_COMPANY"],
				"UF_USER_TYPE" => $arUser["USER_TYPE"],
				"UF_PROFILE_COMPLETE" => $arUser["PROFILE_COMPLETE"],
				"UF_SUBSCRIBE_PARTNER" => $arUser["SUBSCRIBE_PARTNER"],
			];

			// Заполнение адреса (узел адреса может не присутствовать в файле)
			if ($arUser["ADDRESS"]) {
				$arUserAddUpdate["WORK_COUNTRY"] = $arCountries[$arUser["ADDRESS"]["COUNTRY"]];
				$arUserAddUpdate["WORK_ZIP"] = $arUser["ADDRESS"]["ZIP"];
				$arUserAddUpdate["WORK_STATE"] = $arUser["ADDRESS"]["REGION"];
				$arUserAddUpdate["WORK_CITY"] = [];
				$arUserAddUpdate["WORK_STREET"] = [];

				$arCustomUserAddress = [
					"WORK_CITY" => ["DISTRICT", "CITY", "LOCALITY"],
					"WORK_STREET" => ["STREET", "HOUSE", "BUILDING", "APT"]
				];
				foreach ($arCustomUserAddress as $customUserAddressCode => $arCustomUserAddressItem) {
					foreach ($arCustomUserAddressItem as $arCustomUserAddressItemCode) {
						if ($arUser["ADDRESS"][$arCustomUserAddressItemCode]) {
							$arUserAddUpdate[$customUserAddressCode][] = $arUser["ADDRESS"][$arCustomUserAddressItemCode];
						}
					}
					$arUserAddUpdate[$customUserAddressCode] = join(", ", $arUserAddUpdate[$customUserAddressCode]);
				}
			}

			// Массив для логирования изменений
			$arUserUpdatedFields = [];

			// Если юзера нужно создать
			if (!$arBxUser) {
				$password = substr(md5($arUser["EMAIL"]), 0, 10);
				$arBxUser = [
					"LOGIN" => $arUser["EMAIL"],
					"PASSWORD" => $password,
					"UF_DEFAULT_PASSWORD" => $password
				];
				$dbUser = new CUser;
				$arBxUser["ID"] = $dbUser->Add(array_merge($arBxUser, $arUserAddUpdate));
				//AddMessage2Log($arBxUser, "CGC1C->importUsers::arBxUser"); // sdemon72
				unset($dbUser);

				CEventLog::Add([
					"SEVERITY" => "INFO",
					"AUDIT_TYPE_ID" => "PARTNERS_EXCHANGE",
					"MODULE_ID" => "main",
					"ITEM_ID" => "",
					"DESCRIPTION" => "Был создан пользователь<br />" . str_replace('[', '<br />[', print_r($arBxUser, true)) . "<br />Со следующими параметрами из файла обмена:<br />" . str_replace('[', '<br />[', print_r($arUser, true)),
				]);

				// Если юзер уже присутствует в Битриксе
			} else {
				// Если что-либо в юзере поменялось
				if (count(array_diff_assoc($arUserAddUpdate, $arBxUser)) > 0) // sdemon72 20200703 так не затираются поля, отсутствующие в файле обмена (адрес)
					/*
                    ($arBxUser["ACTIVE"] != $arUserAddUpdate["ACTIVE"]) ||
                    ($arBxUser["NAME"] != $arUserAddUpdate["NAME"]) ||
                    ($arBxUser["XML_ID"] != $arUserAddUpdate["XML_ID"]) ||
                    ($arBxUser["UF_INN"] != $arUserAddUpdate["UF_INN"]) ||
                    ($arBxUser["UF_NDS"] != $arUserAddUpdate["UF_NDS"]) ||
                    ($arBxUser["UF_HARD_DELETE"] != $arUserAddUpdate["UF_HARD_DELETE"]) ||
                    ($arBxUser["LAST_NAME"] != $arUserAddUpdate["LAST_NAME"]) ||
                    ($arBxUser["SECOND_NAME"] != $arUserAddUpdate["SECOND_NAME"]) ||
                    ($arBxUser["WORK_PHONE"] != $arUserAddUpdate["WORK_PHONE"]) ||
                    ($arBxUser["WORK_COMPANY"] != $arUserAddUpdate["WORK_COMPANY"]) ||
                    ($arBxUser["WORK_CITY"] != $arUserAddUpdate["WORK_CITY"]) ||
                    ($arBxUser["WORK_COUNTRY"] != $arUserAddUpdate["WORK_COUNTRY"]) ||
                    ($arBxUser["WORK_ZIP"] != $arUserAddUpdate["WORK_ZIP"]) ||
                    ($arBxUser["WORK_STATE"] != $arUserAddUpdate["WORK_STATE"]) ||
                    ($arBxUser["WORK_STREET"] != $arUserAddUpdate["WORK_STREET"]))
                    */ {
					$dbUser = new CUser;
					$dbUser->Update($arBxUser["ID"], $arUserAddUpdate);

					// Флаг обновления
					$arUserUpdatedFields[] = "BASE (" . implode(" | ", array_keys($arUserAddUpdate)) . ") " . $dbUser->LAST_ERROR;

					unset($dbUser);
				}
			}

			// Обновляем представителей контрагента
			if ($arUser["AGENTS"]) {
				// Получаем список текущих контрагентов пользователя
				$arBxUserAgentsTmp = CGCHelper::getHlElements(2, array(
					"ID" => $arBxUser["UF_PROFILES"]
				));
				foreach ($arBxUserAgentsTmp as $arBxUserAgentsTmpItem) {
					$arBxUserAgents[$arBxUserAgentsTmpItem["UF_XML_ID"]] = $arBxUserAgentsTmpItem;
				}

				$arUserAgentsNew = array();

				foreach ($arUser["AGENTS"] as $arUserAgent) {

					// Массив для обновления и добавления контрагента
					$arAgentAddUpdate = [
						"UF_XML_ID" => $arUserAgent["ID"],
						"UF_INN" => $arUserAgent["INN"],
						"UF_NAME" => $arUserAgent["NAME"],
						"UF_DESCRIPTION" => $arUserAgent["DESCRIPTION"],
						"UF_KPP" => $arUserAgent["KPP"],
						"UF_KODPOOKPO" => $arUserAgent["OKPO"],
						"UF_KOMMENTARIY" => $arUserAgent["COMMENTS"],
					];

					// Если контрагент уже присутствует в списке контрагентов данного юзера
					if (array_key_exists($arUserAgent["ID"], $arBxUserAgents)) {

						// Обновление контрагента
						CGCHelper::updateHLElement(2, $arBxUserAgents[$arUserAgent["ID"]]["ID"], $arAgentAddUpdate);

						$arUserAgentsNew[] = $arBxUserAgents[$arUserAgent["ID"]]["ID"];

						// Если контрагента нет в списке контрагентов данного юзера
					} else {

						// Проверяем наличие контагента в базе
						$arBxAgent = CGCHelper::getHlElements(2, array(
							"UF_XML_ID" => $arUserAgent["ID"]
						));

						// Если контрагента нет в базе, то добавляем его в ИБ
						if (!$arBxAgent) {
							$arBxAgentID = CGCHelper::addHLElement(2, $arAgentAddUpdate);
						} else {
							$arBxAgentID = $arBxAgent[0]["ID"];

							// Обновление контрагента
							CGCHelper::updateHLElement(2, $arBxAgentID, $arAgentAddUpdate);
						}
						$arUserAgentsNew[] = $arBxAgentID;

						// Если контрагент присутствует в базе контрагентов, либо же был успешно добавлен
						if ($arBxAgentID) {
							array_push($arBxUser["UF_PROFILES"], $arBxAgentID);
						}

						// Фиксируем обновления юзера
						$arUserUpdatedFields[] = "AGENTS";
					}
				}

				// Обновление списка контрагентов пользователя
				$user = new CUser;
				$user->Update($arBxUser["ID"], array(
					"UF_PROFILES" => $arUserAgentsNew,
				));
				unset($user);
			}

			// Обновляем информацию о менеджере
			if ($arUser["MANAGER"]) {

				$managerAddUpdate = [
					"UF_XML_ID" => $arUser["MANAGER"]["ID"],
					"UF_NAME" => $arUser["MANAGER"]["NAME"],
					"UF_PHONE" => $arUser["MANAGER"]["PHONE"],
					"UF_EMAIL" => $arUser["MANAGER"]["EMAIL"],
				];

				// Получаем менеджера из базы
				$arBxManager = CGCHelper::getHlElements(3, array(
					"UF_XML_ID" => $arUser["MANAGER"]["ID"]
				));

				if (!$arBxManager) {
					// Добавляем нового менеджера в БД
					$arBxManagerID = CGCHelper::addHLElement(3, $managerAddUpdate);
				} else {
					// Обновляем менеджера
					CGCHelper::updateHLElement(3, $arBxManager[0]["ID"], $managerAddUpdate);
					// AddMessage2Log($arBxManager[0], "CGC1C->importUsers::arBxManager"); // sdemon72
					$arBxManagerID = $arBxManager[0]["ID"];
				}

				// Если у пользователя нет менеджера, либо он не такой
				if (!$arBxUser["UF_MANAGER"] || $arBxUser["UF_MANAGER"] != $arBxManagerID) {
					$user = new CUser;
					$user->Update($arBxUser["ID"], array(
						"UF_MANAGER" => $arBxManagerID,
					));
					unset($user);

					$arUserUpdatedFields[] = "MANAGER";
				}
			}

			// sdemon72 рефакторинг и исправление недочетов

			// Обновление типа цены
			if ($arBxUser["UF_PRICE_ID"] != $arUser["PRICE_ID"]) {
				// sdemon72 сразу обновить ид цены
				$user = new CUser;
				$user->Update($arBxUser["ID"], array(
					"UF_PRICE_ID" => $arUser["PRICE_ID"],
				));
				unset($user);

				$arUserUpdatedFields[] = "PRICE";
			}

			// Массив текущих групп юзера
			$arUserGroupsID = CUser::GetUserGroup($arBxUser["ID"]);
			// Массив новых групп
			$arUserNewGroups = [];

			// Добавление текущих групп, кроме ценовых
			foreach ($arUserGroupsID as $userGroupID) {
				$arUserGroup = CGroup::GetByID($userGroupID, false)->Fetch();
				if ($arUserGroup["C_SORT"] != 1000) {
					$arUserNewGroups[] = $arUserGroup["ID"];
				}
			}

			// Поиск нужной ценовой группы
			// Ценовая групппа должна быть предварительно создана
			if (!empty($arUser["PRICE_ID"])) {
				$dbGroup = CGroup::GetList($by = "sort", $order = "asc", ["STRING_ID" => $arUser["PRICE_ID"]]);
				$arGroup = $dbGroup->Fetch();
				if ($arGroup) {
					$arUserNewGroups[] = $arGroup["ID"];
				}
			}

			// Если изменился состав групп, то записать
			if (count(array_diff($arUserNewGroups, $arUserGroupsID)) > 0 || count(array_diff($arUserGroupsID, $arUserNewGroups)) > 0) {
				CUser::SetUserGroup($arBxUser["ID"], $arUserNewGroups);
				$arUserUpdatedFields[] = "UserGroups";
			}

			// 1cBit
			$userGroups = \Bitrix\Main\UserTable::getUserGroupIds($arBxUser["ID"]);

			if ($arUser["PRE_ORDER"] == "Y") {
				$userGroups[] = strval(preorder_id_group);
				$userGroups[] = strval(preorder_id_group_preview);
			}else{
				unset($userGroups[array_search(preorder_id_group, $userGroups)]);
				unset($userGroups[array_search(preorder_id_group_preview, $userGroups)]);
			}
//dumps($userGroups, $arBxUser["ID"]);
			CUser::SetUserGroup($arBxUser["ID"], $userGroups);

			// _sdemon72
			// Логируем обновления у пользователя
			if ($arUserUpdatedFields) {
				CEventLog::Add([
					"SEVERITY" => "INFO",
					"AUDIT_TYPE_ID" => "PARTNERS_EXCHANGE",
					"MODULE_ID" => "main",
					"ITEM_ID" => "",
					"DESCRIPTION" => "Поля пользователя " . $arBxUser["ID"] . " были обновлены:<br />" . implode(" | ", $arUserUpdatedFields),
				]);
			}

		}

		// Логируем завершение обработки файла
		CEventLog::Add([
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "PARTNERS_EXCHANGE",
			"MODULE_ID" => "main",
			"ITEM_ID" => "",
			"DESCRIPTION" => "Файл " . $xmlFileName . " был успешно обработан",
		]);

	}


	// sdemon72 20200703
	function getDateTime($stringvalue)
	{
		$date = str_replace("T", " ", $stringvalue);
		$datevalue = new DateTime(\CAllDatabase::FormatDate($date, "YYYY-MM-DD HH:MI:SS", \CAllSite::GetDateFormat("FULL", LANG)));
		return $datevalue;

	} // _sdemon72 20200703

}