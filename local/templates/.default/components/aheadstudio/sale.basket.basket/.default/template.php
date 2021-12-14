<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */
?>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<script>
    BX.Currency.setCurrencyFormat("RUB", <?php echo CUtil::PhpToJSObject(CCurrencyLang::GetFormatDescription("RUB"), false, true); ?>);

    var phoenixOrderConstants = (function () {
        var consts = {
            "api_url": "/local/components/aheadstudio/sale.basket.basket/ajax.php",
            "fastadd_url": "/cart/add/",
            "nds_info": <?php echo json_encode($arParams["NDS_INFO"]); ?>,
            "user_info": <?php echo json_encode($arParams["USER_INFO"]); ?>,
            "enable_gifts": "<?php echo $arParams["ENABLE_GIFTS"]; ?>",
            "user_type": "<?php echo $arParams["USER_TYPE"]; ?>"
        };
        return ({
            get: function (name) {
                return consts[name];
            }
        });
    }());

    var phoenixOrderUtils = {

        // Подготовка запроса
        prepareQuery: function (params) {
            var formData = new FormData();

            // Базовые параметры
            formData.append("site_id", "<?php echo SITE_ID; ?>");
            formData.append("sessid", "<?php echo bitrix_sessid(); ?>");
            formData.append("price_vat_show_value", "Y");

            // Дополнительные параметры
            for (var code in params) {
                formData.append(code, params[code]);
            }

            return formData;
        }
    };
</script>


<?php
include __DIR__ . "/blocks/fastadd.php";
include __DIR__ . "/blocks/app.php";
include __DIR__ . "/blocks/basket_item.php";

$mode = "order";
if (Preorder::inPreorderGroup()) {
    $style = "style='color:#fff;background-color: #4c497b;'";
    if ($_REQUEST["mode"] == "pre_order") {
        Preorder::replaceCart("UF_PRE_ORDER_CART");
        $mode = "pre_order";
    } else {
        Preorder::replaceCart("UF_USER_CART");
    }
    ?>
    <div class="page-inner page-inner--w1" id="orderMode" data-mode="<?= $mode ?>">
        <a href="?mode=pre_order"
           class="catalog-item-buy btn btn--gray" <?= $_REQUEST["mode"] == "pre_order" ? $style : "" ?>>
            Корзина предзаказа
        </a>
        <a href="?mode=order"
           class="catalog-item-buy btn btn--gray" <?= $_REQUEST["mode"] == "order" || !isset($_REQUEST["mode"]) ? $style : "" ?>>
            Корзина
        </a>
    </div>
    <?
}
?>
<div id="order-form"></div>