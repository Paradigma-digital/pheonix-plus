<?

use Bitrix\Main\Application;

define('PUBLIC_AJAX_MODE', true);
define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('BX_SECURITY_SHOW_MESSAGE', true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$request = Application::getInstance()->getContext()->getRequest();
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"] = "N";
$APPLICATION->ShowIncludeStat = false;

if ($request->isAjaxRequest()) {
    $data = [];
    switch ($_REQUEST["action"]) {
        case "addToCart":
            Preorder::updateUserBasket($_REQUEST["mode"], $_REQUEST["id"], $_REQUEST["quantity"], $_REQUEST["increase"]);
            break;

        case "changeFromUserCartOrder":
            $mode = $_REQUEST["mode"] == "order" ? "UF_USER_CART" : "UF_PRE_ORDER_CART";

            Preorder::updateUserBasket($mode, $_REQUEST["id"], $_REQUEST["quantity"], $_REQUEST["increase"]);
            break;
    }

    if (!empty($data)) {
        echo \Bitrix\Main\Web\Json::encode($data);
    }
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");