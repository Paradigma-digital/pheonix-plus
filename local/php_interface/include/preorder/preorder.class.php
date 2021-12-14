<?php

use Bitrix\Main\UserTable;
use Bitrix\Sale\Order;

class Preorder
{
    private function getBasketObj(): object
    {
        return Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    }

    /**
     * @param $cart
     * @param $id
     * @param $quantity
     * @throws \Bitrix\Main\ArgumentException
     */
    static function updateUserBasket($cart, $id, $quantity, $increase = "Y")
    {
        $cartArr = $result = [];
        $cartItems = (new Preorder)->getUserCart($cart);
        if ($cartItems[$cart]) {
            $cartArr = \Bitrix\Main\Web\Json::decode($cartItems[$cart]);
        }

        if (isset($cartArr)) {
            if ($increase == "Y") {
                $cartArr[$id] = $cartArr[$id] + $quantity;
            } else {
                $cartArr[$id] = $quantity;
            }
        } else {
            $cartArr[$id] = $quantity;
        }

        if ($quantity == 0) {
            unset($cartArr[$id]);
        }

        $result[$cart] = $cartArr;
        self::setUserBaskets($result);
    }

    /**
     * @param Order $order
     */
    static public function OnSaleComponentOrderCreatedHandler($order)
    {
        $paymentCollection = $order->getPaymentCollection();
        if ($_REQUEST["mode"] == "pre_order") {
            foreach ($paymentCollection as $payment) {
                $payment->delete();
            }
            $service = \Bitrix\Sale\PaySystem\Manager::getObjectById(preorder_paysystem);
            $paymentCollection->createItem($service);
        }
    }

    /**
     * @param \Bitrix\Main\Event $event
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function OnSaleOrderSavedHandler(\Bitrix\Main\Event $event)
    {
        $res = [];
        $cart = '';
        $isNew = $event->getParameter("IS_NEW");
        if ($isNew) {
            $order = $event->getParameter("ENTITY");
            $order->getId();
            $basket = $order->getBasket();

            foreach ($basket as $basketItem) {
                $res[$basketItem->getProductId()] = $basketItem->getQuantity();
            }

            foreach (Preorder::getUserCarts() as $key => $userCart) {
                $result = array_intersect_key($userCart, $res);
                if (!empty($result) && count($result) == count($res)) {
                    $cart = $key;
                }
            }

            if ($order->getPersonTypeId() == 2) {
                $preOrder = preorder_physical;
            } else {
                $preOrder = preorder_legal;
            }

            $propertyCollection = $order->getPropertyCollection();
            $somePropValue = $propertyCollection->getItemByOrderPropertyId($preOrder);

            if ($cart == "UF_PRE_ORDER_CART") {
                $somePropValue->setValue("Y");
                self::setUserBaskets(["UF_PRE_ORDER_CART" => []]);
            } else {
                $somePropValue->setValue("N");
                self::setUserBaskets(["UF_USER_CART" => []]);
            }

            $order->save();
        }
    }

    static public function updateCatalog($props): array
    {
        global $USER;
        $arItem = [];
        $arUserSale = CGCUser::getSaleInfo($USER->GetID());

        if ($props['PROPERTIES']["PRE_ORDER"]["VALUE"] == "Да") {
            $arItem["SHOW_PRE_ORDER"] = "Y";
            if ($props["PRICES"]["Канц Анонс"]["VALUE"] > 0) {
                $arItem["MIN_PRICE"] = $props["PRICES"]["Канц Анонс"];
            }
        } else {
            foreach ($arUserSale["GROUP"]["PRICE"]["CODE"] as $name) {
                if($name == "Канц Анонс") continue;
                $arItem["MIN_PRICE"] = $props["PRICES"][$name];
            }
        }

        if ($props['PROPERTIES']["MAIN_COLLECTION"]["VALUE"] == 'Да') {
            $arItem["SHOW_MAIN_COLLECTION"] = "Y";

            foreach ($arUserSale["GROUP"]["PRICE"]["CODE"] as $name) {
                if($name == "Канц Анонс") continue;
                $arItem["MIN_PRICE"] = $props["PRICES"][$name];
            }
        }

        return $arItem;
    }

    /**
     * @throws \Bitrix\Main\ArgumentException
     */
    static public function setUserBaskets($items)
    {
        if (!empty($items)) {
            global $USER;
            $fields = [];
            $user = new \CUser;

            foreach ($items as $key => $item) {
                $enc_value = \Bitrix\Main\Web\Json::encode($item, $options = null);
                $fields[$key] = $enc_value;
            }
            $user->Update($USER->GetID(), $fields);
        }
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function getUserCarts(): array
    {
        global $USER;
        $result = [];
        $userResult = \Bitrix\Main\UserTable::getList(array(
            'filter' => array(
                'ID' => $USER->GetID(),
            ),
            'limit' => 1,
            'select' => array('ID', 'UF_USER_CART', 'UF_PRE_ORDER_CART'),
        ))->fetch();


		if($userResult["UF_USER_CART"] != "" ){
			$result["UF_USER_CART"] = \Bitrix\Main\Web\Json::decode($userResult["UF_USER_CART"]);
		}

        if ($userResult["UF_PRE_ORDER_CART"] != "") {
            $result["UF_PRE_ORDER_CART"] = \Bitrix\Main\Web\Json::decode($userResult["UF_PRE_ORDER_CART"]);
        }
		
        return $result;
    }

    private function getUserCart($cart)
    {
        global $USER;
        return \Bitrix\Main\UserTable::getList(array(
            'filter' => array(
                '=ID' => $USER->GetID(),
            ),
            'limit' => 1,
            'select' => array('ID', $cart),
        ))->fetch();
    }

    static public function checkCardProperty($id)
    {
        $result = \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
            'select' => ['ID', 'NAME', 'IBLOCK_ID', 'PREDZAKAZ_' => 'PREDZAKAZ', 'OSNOVNAYA_KOLLEKTSIYA_' => 'OSNOVNAYA_KOLLEKTSIYA'],
            'filter' => ['ACTIVE' => 'Y', "ID" => $id],
            'limit' => 1
        ])->fetch();

        return [
               'PRE_ORDER' => $result["PREDZAKAZ_VALUE"],
               'MAIN_COLLECTION' => $result["OSNOVNAYA_KOLLEKTSIYA_VALUE"],
            ];
    }


    static public function separateCart(): array
    {
        $result = [];
        $basket = (new Preorder)->getBasketObj();

        foreach ($basket as $item) {
            if ((new Preorder)->checkCardProperty($item->getProductId())) {
                $result["UF_PRE_ORDER_CART"][$item->getProductId()] = $item->getQuantity();
            } else {
                $result["UF_USER_CART"][$item->getProductId()] = $item->getQuantity();
            }
        }

//        (new Preorder)->setUserBaskets($result);

        return $result;
    }

    private function clearCart($basket)
    {
        foreach ($basket as $item) {
            $item->delete();
        }
        $basket->save();
    }

    static public function replaceCart($cart)
    {
        global $USER;

        $fUser = Bitrix\Sale\Fuser::getId();
        $basket = Bitrix\Sale\Basket::loadItemsForFUser($fUser, Bitrix\Main\Context::getCurrent()->getSite());
        (new Preorder)->clearCart($basket);

        $cartItems = (new Preorder)->getUserCart($cart);

        if ($cartItems[$cart]) {
            $cartArr = \Bitrix\Main\Web\Json::decode($cartItems[$cart]);
            $arUserSale = CGCUser::getSaleInfo($USER->GetID());
            foreach ($cartArr as $productItem => $quantity) {
                if (!$basket->getExistsItem('catalog', $productItem)) {

                    $res = self::checkCardProperty($productItem);

                    if($res["PRE_ORDER"] != '' && $res["PRE_ORDER"] > 0 && $cart != "UF_USER_CART"){
                        $priceID = preorder_id_price_preview;
                    }

                    if($res["MAIN_COLLECTION"] != '' && $res["MAIN_COLLECTION"] > 0 || $cart == "UF_USER_CART"){
                        foreach ($arUserSale["GROUP"]["PRICE"]["CODE"] as $priceTypeId => $name) {
                            if(preorder_id_price_preview == $priceTypeId) continue;
//                            if($name == "BASE") continue;
                            $priceID = $priceTypeId;
                        }
                    }

                    $rsPrice = \Bitrix\Catalog\PriceTable::getList(array(
                        'filter' => array('CATALOG_GROUP.ID' => $priceID, 'PRODUCT_ID' => $productItem),
                        'limit' => 1
                    ));

                    if ($arPrice = $rsPrice->fetch()) {
                        $item = $basket->createItem('catalog', $productItem);
                        $item->setFields(array(
                            'QUANTITY' => $quantity,
                            'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                            'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
                            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                            'PRICE' => $arPrice["PRICE"],
                            'CUSTOM_PRICE' => 'Y',
                        ));
                    }
                }
            }

            $basket->save();
        }
    }

    static public function getProductProps($productId){


    }

    static public function defaultBasketAfterAuth($arUser)
    {
        if ($arUser["USER_ID"] > 0) {
            $id = $arUser["USER_ID"];
        } else {
            $id = $arUser["user_fields"]["ID"];
        }

        $basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        $user = \Bitrix\Main\UserTable::getList(array(
            'filter' => array(
                '=ID' => $id,
            ),
            'limit' => 1,
            'select' => array('ID', "UF_USER_CART"),
        ))->fetch();

        foreach ($basket as $item) {
            if (!in_array($item->getProductId(), $user["UF_USER_CART"])) {
                $item->delete();
            }
        }

        foreach ($user["UF_USER_CART"] as $cart) {
            if (!$basket->getExistsItem('catalog', $cart)) {
                $item = $basket->createItem('catalog', $cart);
                $item->setFields(['QUANTITY' => 1, 'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider']);
            }
        }
        $basket->save();

    }

    /**
     * Определяем принадлежность пользователя к группе Предзаказ
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function inPreorderGroup(): bool
    {
        $dbUserGroup = CGroup::GetByID(preorder_id_group);
        $arUserGroup = $dbUserGroup->Fetch();
        if($arUserGroup["ACTIVE"] == "N") return false;

        return UserTable::getList(array(
                "select" => ["ID", "ACTIVE", "G_" => "GROUP"],
                "filter" => ["ID" => $GLOBALS['USER']->GetID(), "G_GROUP_ID" => preorder_id_group],
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
            ))->fetch()["G_GROUP_ID"] == preorder_id_group;
    }
}