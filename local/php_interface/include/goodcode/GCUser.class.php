<?php

use Bitrix\Main\UserTable;

class CGCUser
{

    // Редирект на страницу авторизации если юзер не авторизован
    function loginIfNotAuth($user)
    {
        //deb($_SERVER);
        if (!$user) {
            LocalRedirect("/catalog/");
        }
        if ($user && !$user->isAuthorized()) {
            LocalRedirect("/catalog/");
        }
    }

    // Данные по пользователе
    function getUserInfo($arFields)
    {
        if (!$arFields["ID"]) {
            return false;
        }
        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
            "ID" => $arFields["ID"]
        ], [
            "SELECT" => ["ID", "NAME", "WORK_COMPANY", "UF_INN", "WORK_PHONE", "WORK_CITY", "UF_PROFILE_COMPLETE", "EMAIL", "UF_UPDATE_BASKET", "XML_ID",],
            "NAV_PARAMS" => [
                "nTopCount" => "1"
            ]
        ]);
        $arUser = $rsUsers->GetNext();

        return $arUser;
    }

    function getUserTypesByCodes()
    {
        $arTypes = [];
        $dbTypes = CUserFieldEnum::GetList(
            [
                "SORT" => "ASC",
            ],
            [
                "USER_FIELD_NAME" => "UF_USER_TYPE"
            ]
        );
        while ($arType = $dbTypes->GetNext()) {
            $arTypes[$arType["XML_ID"]] = $arType;
        }
        return $arTypes;
    }

    function getUserTypes()
    {
        $arTypes = [];
        $dbTypes = CUserFieldEnum::GetList(
            [
                "SORT" => "ASC",
            ],
            [
                "USER_FIELD_NAME" => "UF_USER_TYPE"
            ]
        );
        while ($arType = $dbTypes->GetNext()) {
            $arTypes[$arType["ID"]] = $arType;
        }
        return $arTypes;
    }

    function getUserType($arFields)
    {

        if (!$arFields["ID"]) {
            return "SIMPLE";
        }

        $arTypes = self::getUserTypes();

        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
            "ID" => $arFields["ID"]
        ], [
            "SELECT" => ["UF_USER_TYPE"],
            "NAV_PARAMS" => [
                "nTopCount" => "1"
            ]
        ]);
        $arUser = $rsUsers->GetNext();

        return ($arUser["UF_USER_TYPE"] ? $arTypes[$arUser["UF_USER_TYPE"]]["XML_ID"] : array_keys($arTypes)[0]);
    }

    function isUserBusiness($arFields)
    {
        $arTypes = self::getUserTypes();

        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
            "ID" => $arFields["ID"]
        ], [
            "SELECT" => ["UF_USER_TYPE"],
            "NAV_PARAMS" => [
                "nTopCount" => "1"
            ]
        ]);
        $arUser = $rsUsers->GetNext();

        if ($arUser["UF_USER_TYPE"]) {
            if ($arTypes[$arUser["UF_USER_TYPE"]]["XML_ID"] == "BUSINESS") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function sendEmailIfActivated(&$arFields)
    {
        //deb($arFields);
        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
            "ID" => $arFields["ID"]
        ], [
            "SELECT" => ["ACTIVE", "EMAIL", "NAME", "UF_MANAGER", "UF_NDS", "UF_PRICE_ID"],
            "NAV_PARAMS" => [
                "nTopCount" => "1"
            ]
        ]);
        $arUser = $rsUsers->GetNext();

        if ($arFields["ACTIVE"] == "Y" && $arUser["ACTIVE"] == "N") {
            $managerInfo = "";
            if ($arUser["UF_MANAGER"]) {
                $arUserManager = CGCHelper::getHlElements(3, array(
                    "ID" => $arUser["UF_MANAGER"]
                ));
                if ($arUserManager) {
                    $arUserManager = $arUserManager[0];
                }
                $managerInfo = "<p>
						По всем вопросам вы можете обращаться к вашему персональному менеджеру:<br />
						<b>" . $arUserManager["UF_NAME"] . "</b><br />";
                if ($arUserManager["UF_PHONE"]) {
                    $managerInfo .= "тел.: " . $arUserManager["UF_PHONE"] . "<br />";
                }
                if ($arUserManager["UF_EMAIL"]) {
                    $managerInfo .= "эл.почта: " . $arUserManager["UF_EMAIL"] . "<br />";
                }
                $managerInfo .= "</p>";
            }

            CEvent::Send(
                "USER_ACTIVATED",
                "s1",
                [
                    "EMAIL" => $arUser["EMAIL"],
                    "USER_NAME" => $arUser["NAME"],
                    "MANAGER_INFO" => $managerInfo,
                ]
            );
        }

        // Проверка на изменение типа НДС или типа цены
        if (
            (isset($arFields["UF_NDS"]) && $arFields["UF_NDS"] != $arUser["UF_NDS"]) ||
            (isset($arFields["UF_PRICE_ID"]) && $arFields["UF_PRICE_ID"] != $arUser["UF_PRICE_ID"])
        ) {
            $arFields["UF_UPDATE_BASKET"] = "Y";
        }
    }

    function sendRegisterEmail($arFields)
    {
        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
            "ID" => $arFields["ID"]
        ], [
            "SELECT" => ["ACTIVE", "UF_DEFAULT_PASSWORD", "WORK_COMPANY", "WORK_CITY", "UF_INN", "UF_BIK", "UF_BILL", "PERSONAL_PHONE"],
            "NAV_PARAMS" => [
                "nTopCount" => "1"
            ]
        ]);
        $arUser = $rsUsers->GetNext();

        //deb($arUser);

        CEvent::Send(
            "NEW_USER_CUSTOM",
            "s1",
            [
                "EMAIL" => $arUser["EMAIL"],
                "NAME" => $arUser["NAME"],
                "PASSWORD" => ($arUser["UF_DEFAULT_PASSWORD"] ? '<b>Пароль: ' . $arUser["UF_DEFAULT_PASSWORD"] . '</b><br>' : ""),
                "WORK_COMPANY" => $arUser["WORK_COMPANY"],
                "WORK_CITY" => $arUser["WORK_CITY"],
                "UF_INN" => $arUser["UF_INN"],
                "UF_BIK" => $arUser["UF_BIK"],
                "UF_BILL" => $arUser["UF_BILL"],
                "PERSONAL_PHONE" => $arUser["PERSONAL_PHONE"],
                "SALE_EMAIL" => COption::GetOptionString("sale", "order_email"),
            ]
        );
    }

    function changeExportedState(&$arFields)
    {
        /*deb($arFields);

        if($arFields["UF_EXPORTED_1C"] == "Y") {
            $dbUser = CUser::GetList(
                ($order = "ID"),
                ($desc = "DESC"),
                Array(
                    "ID" => $arFields["ID"],
                ),
                Array(
                    "SELECT" => Array("UF_EXPORTED_1C")
                )
            );
            $arFields["UF_EXPORTED_1C"] = "";
        }*/
    }

    // Get linked manager
    function getManager($userID)
    {
        $arResult = array();
        $dbUserInfo = CUser::GetList(
            ($by = "NAME"), ($order = "desc"),
            array(
                "ID" => $userID
            ),
            array(
                "SELECT" => array("NAME", "UF_MANAGER"),
                "FIELDS" => array("WORK_COMPANY", "WORK_CITY", "PERSONAL_PHONE")
            )
        );
        $arUserInfo = $dbUserInfo->Fetch();
        $arManager = CGCHelper::getHlElements(3, array("ID" => $arUserInfo["UF_MANAGER"]))[0];

        if ($arManager) {
            return [
                "NAME" => ($arManager["UF_SURNAME"] ? $arManager["UF_SURNAME"] . " " . $arManager["UF_NAME"] . " " . $arManager["UF_SECONDNAME"] : $arManager["UF_NAME"]),
                "PHONE" => $arManager["UF_PHONE"],
                "EMAIL" => $arManager["UF_EMAIL"]
            ];
        }
        return false;

    }

    // Get user linked profiles and manager
    function getProfiles($userId)
    {
        $arResult = array();
        $dbUserInfo = CUser::GetList(
            ($by = "NAME"), ($order = "desc"),
            array(
                "ID" => $userId
            ),
            array(
                "SELECT" => array("NAME", "UF_PROFILES", "UF_INN", "UF_BIK", "UF_BILL"),
                "FIELDS" => array("WORK_COMPANY", "WORK_CITY", "PERSONAL_PHONE")
            )
        );
        $arUserInfo = $dbUserInfo->Fetch();
        $arProfiles = $arUserInfo["UF_PROFILES"];

        /*$arResult[$arUserInfo["WORK_COMPANY"]] = Array(
            "COMPANY_CITY" => $arUserInfo["WORK_CITY"],
            "COMPANY_NAME" => $arUserInfo["WORK_COMPANY"],
            "COMPANY_INN" => $arUserInfo["UF_INN"],
            "BIK" => $arUserInfo["UF_BIK"],
            "COMPANY_BILL" => $arUserInfo["UF_BILL"]
        );*/

        //deb($arUserInfo["UF_PROFILES"]);

        foreach ($arUserInfo["UF_PROFILES"] as $profileId) {
            $arProfile = CGCHelper::getHlElements(2, array("ID" => $profileId))[0];
            $arResult[$arProfile["ID"]] = array(
                "COMPANY_CITY" => "",
                "COMPANY_TITLE" => $arProfile["UF_NAME"],
                "COMPANY_NAME" => $arProfile["UF_DESCRIPTION"],
                "COMPANY_INN" => $arProfile["UF_INN"],
                "COMPANY_KPP" => $arProfile["UF_KPP"],
                "COMPANY_OKPO" => $arProfile["UF_KODPOOKPO"],
                "COMPANY_ID" => $arProfile["UF_XML_ID"],
            );
        }
        //deb($arResult);
        return $arResult;
    }

    // Old function
    function getOldProfiles($userId)
    {
        $arResult = array();
        $dbProfiles = CIBlockElement::GetList(
            false,
            array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => "15",
                "PROPERTY_USER" => $userId
            ),
            false,
            false,
            array(
                "ID", "NAME",
                "PROPERTY_COMPANY", "PROPERTY_CITY", "PROPERTY_KPP", "PROPERTY_INN", "PROPERTY_BIK", "PROPERTY_ACCOUNT"
            )
        );

        $dbUserInfo = CUser::GetList(
            ($by = "NAME"),
            ($order = "DESC"),
            array(
                "ID" => $userId
            ),
            array(
                "SELECT" => array("UF_INN", "UF_BIK", "UF_BILL"),
                "FIELDS" => array("WORK_COMPANY", "WORK_CITY", "PERSONAL_PHONE")
            )
        );
        $arUserInfo = $dbUserInfo->Fetch();
        $arResult[$arUserInfo["WORK_COMPANY"]] = array(
            "COMPANY_CITY" => $arUserInfo["WORK_CITY"],
            "COMPANY_NAME" => $arUserInfo["WORK_COMPANY"],
            "COMPANY_INN" => $arUserInfo["UF_INN"],
            "BIK" => $arUserInfo["UF_BIK"],
            "COMPANY_BILL" => $arUserInfo["UF_BILL"]
        );

        while ($arProfile = $dbProfiles->Fetch()) {
            $arResult[$arProfile["PROPERTY_COMPANY_VALUE"]] = array(
                "COMPANY_CITY" => $arProfile["PROPERTY_CITY_VALUE"],
                "COMPANY_NAME" => $arProfile["PROPERTY_COMPANY_VALUE"],
                "COMPANY_INN" => $arProfile["PROPERTY_INN_VALUE"],
                "BIK" => $arProfile["PROPERTY_BIK_VALUE"],
                "COMPANY_BILL" => $arProfile["PROPERTY_ACCOUNT_VALUE"]
            );
        }

        return $arResult;
    }

    function getSaleInfo($userID, $ndsCode = false)
    {
        $arUserGroups = [];
        // Типы НДС
        $arNDSTypes = [
            "IN" => [ // НДС в сумме
                "TYPE" => "IN",
                "CHECK_VAL" => ["", "ВСумме"],

                "PRICE_VAT_INCLUDE" => "Y",
                "BASKET_COL_VAT_RATE" => [
                    "DISPLAY" => "Y",
                    "TITLE" => "Ставка НДС",
                ],
                "BASKET_COL_VAT_VALUE" => [
                    "DISPLAY" => "Y",
                    "TITLE" => "Сумма НДС",
                ],
                "BASKET_COL_SUMMARY_VALUE" => [
                    "DISPLAY" => "N",
                    "TITLE" => "",
                ],
                "SUMMARY_VAT_TITLE" => "В том числе НДС"
            ],
            "NO" => [ // Не начислять НДС
                "TYPE" => "NO",
                "CHECK_VAL" => ["НеНачислять"],


                "PRICE_VAT_INCLUDE" => "Y",
                "BASKET_COL_VAT_RATE" => [
                    "DISPLAY" => "N",
                    "TITLE" => "",
                ],
                "BASKET_COL_VAT_VALUE" => [
                    "DISPLAY" => "N",
                    "TITLE" => "",
                ],
                "BASKET_COL_SUMMARY_VALUE" => [
                    "DISPLAY" => "N",
                    "TITLE" => "",
                ],
                "SUMMARY_VAT_TITLE" => ""
            ],
            "OVER" => [ // НДС сверху
                "TYPE" => "OVER",
                "CHECK_VAL" => ["Сверху"],

                "PRICE_VAT_INCLUDE" => "N",
                "BASKET_COL_VAT_RATE" => [
                    "DISPLAY" => "Y",
                    "TITLE" => "Ставка НДС",
                ],
                "BASKET_COL_VAT_VALUE" => [
                    "DISPLAY" => "Y",
                    "TITLE" => "Сумма НДС",
                ],
                "BASKET_COL_SUMMARY_VALUE" => [
                    "DISPLAY" => "Y",
                    "TITLE" => "Сумма с НДС",
                ],
                "SUMMARY_VAT_TITLE" => "Сумма НДС"
            ]
        ];


        if ($ndsCode) {
            return $arNDSTypes[$ndsCode];
        }


        $arResult = [
            "GROUP" => [
                "GROUP" => "",
                "PRICE" => [
                    "CODE" => [
                        4 => "BASE"
                    ],
                ]
            ],
            "NDS" => $arNDSTypes["IN"],
        ];

        if (!$userID) {
            $priceCode = "2f235eaa-a0b9-11ea-80dc-002590ea7b7b";
            //$priceCode = "b2a6bdd3-7ee1-11e4-80ba-00155d000717";
            $dbGroup = CGroup::GetList($by = "sort", $order = "asc", ["STRING_ID" => $priceCode]);
            $arGroup = $dbGroup->Fetch();
            $dbUserPriceGroup = CCatalogGroup::GetList(
                false,
                [
                    "XML_ID" => $arGroup["STRING_ID"]
                ],
                false,
                [
                    "nTopCount" => "1"
                ]
            );
            $arUserPriceGroup = $dbUserPriceGroup->Fetch();

            if ($arGroup) {
                $arResult["GROUP"]["GROUP"] = $arGroup["ID"];
                $arResult["GROUP"]["PRICE"]["CODE"][$arUserPriceGroup["ID"]] = $arUserPriceGroup["NAME"];
//                $arResult["GROUP"]["PRICE"]["ID"] = $arUserPriceGroup["ID"];
            }

            return $arResult;
        }

        CModule::IncludeModule("catalog");

        // Получение групп пользователей
        $resGroups = UserTable::getList(array(
            "select" => ["ID", "G_" => "GROUP"],
            "filter" => ["ID" => $GLOBALS['USER']->GetID()],
            'runtime' =>
                [
                    new \Bitrix\Main\Entity\ReferenceField(
                        'GROUP',
                        \Bitrix\Main\UserGroupTable::getEntity(),
                        [
                            '=this.ID' => 'ref.USER_ID',
                        ]
                    ),
                ],
        ))->fetchAll();

        foreach ($resGroups as $group){
            $arUserGroups[] = $group["G_GROUP_ID"];
        }

        foreach ($arUserGroups as $userGroupID) {
            $dbUserGroup = CGroup::GetByID($userGroupID);
            $arUserGroup = $dbUserGroup->Fetch();
            if ($arUserGroup["C_SORT"] == 1000 && $arUserGroup["STRING_ID"]) {
                $arResult["GROUP"]["GROUP"] = $arUserGroup["ID"];

                $arUserPriceGroup = \Bitrix\Catalog\GroupTable::getList([
                    'select' => ['NAME', "ID"],
                    'filter' => ["XML_ID" => $arUserGroup["STRING_ID"]],
                ])->fetch();
                if ($arUserPriceGroup) {
                    $arResult["GROUP"]["PRICE"]["CODE"][$arUserPriceGroup["ID"]] = $arUserPriceGroup["NAME"];
                }
            }
        }
//op($arResult["GROUP"]["PRICE"]["CODE"]);
        // Получение НДС
        $dbUser = CUser::GetList(
            ($by = "NAME"), ($order = "desc"),
            [
                "ID" => $userID
            ],
            [
                "SELECT" => ["NAME", "UF_NDS"],
                "NAV_PARAMS" => [
                    "nTopCount" => "1",
                ]
            ]
        );
        $arUser = $dbUser->Fetch();
        if (isset($arUser["UF_NDS"])) {
            foreach ($arNDSTypes as $arNDSType) {
                if (in_array($arUser["UF_NDS"], $arNDSType["CHECK_VAL"])) {
                    $arResult["NDS"] = $arNDSType;
                    break;
                }
            }
        }
        if (!$arResult["NDS"]) {
            $arResult["NDS"] = $arNDSTypes["IN"];
        }

        return $arResult;
    }
}