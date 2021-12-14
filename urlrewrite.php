<?php
$arUrlRewrite=array (
  20 => 
  array (
    'CONDITION' => '#^/personal/orders/([\\d\\-]+)/doc/([\\d\\-]+)/.*#',
    'RULE' => 'ORDER_ID=$1&UPD_ID=$2',
    'ID' => '',
    'PATH' => '/personal/orders/doc.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/personal/orders/([\\d\\-]+)/upd/([\\d\\-]+)/.*#',
    'RULE' => 'ORDER_ID=$1&UPD_ID=$2',
    'ID' => '',
    'PATH' => '/personal/orders/upd.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/catalog/product/imageByCode/([\\w\\-]+)/.*#',
    'RULE' => 'CODE=$1&TYPE=imageByCode',
    'ID' => '',
    'PATH' => '/tools/getProductInfo.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  51 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/personal/orders/cancel/([\\d\\-]+)/.*#',
    'RULE' => 'ORDER_ID=$1',
    'ID' => '',
    'PATH' => '/personal/orders/cancel.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/catalog/product/image/([\\w\\-]+)(.*)#',
    'RULE' => 'CODE=$1&TYPE=image',
    'ID' => '',
    'PATH' => '/tools/getProductInfo.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/catalog/product/find/([^.?]+)(.*)#',
    'RULE' => 'CODE=$1',
    'ID' => '',
    'PATH' => '/tools/findProductByArticle.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/catalog/product/card/([\\w\\-]+)/.*#',
    'RULE' => 'CODE=$1&TYPE=card',
    'ID' => '',
    'PATH' => '/tools/getProductInfo.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/personal/orders/([\\d\\-]+)/.*#',
    'RULE' => 'ORDER_ID=$1',
    'ID' => '',
    'PATH' => '/personal/orders/detail.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/personal/orders/receive/.*#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/personal/orders/receive.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  70 => 
  array (
    'CONDITION' => '#^/partnerlink/([\\w\\-]+)/.*#',
    'RULE' => 'CODE=$1',
    'ID' => '',
    'PATH' => '/partnerlink/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/sendconfirm/([\\d\\-]+)/.*#',
    'RULE' => 'USER_ID=$1',
    'ID' => '',
    'PATH' => '/sendconfirm/index.php',
    'SORT' => 100,
  ),
  50 => 
  array (
    'CONDITION' => '#^/download/([\\w\\-]+)/.*#',
    'RULE' => 'SECTION_CODE=$1',
    'ID' => '',
    'PATH' => '/download/section.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  60 => 
  array (
    'CONDITION' => '#^/qr/([\\w\\-]+)/.*#',
    'RULE' => 'QR_CODE=$1',
    'ID' => '',
    'PATH' => '/qr/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/personal/lists/#',
    'RULE' => '',
    'ID' => 'bitrix:lists',
    'PATH' => '/personal/lists/index.php',
    'SORT' => 100,
  ),
  73 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'aheadstudio:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  71 => 
  array (
    'CONDITION' => '#^/forum/#',
    'RULE' => '',
    'ID' => 'bitrix:forum',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  72 => 
  array (
    'CONDITION' => '#^/wiki/#',
    'RULE' => '',
    'ID' => 'bitrix:wiki',
    'PATH' => '/wiki/index.php',
    'SORT' => 100,
  ),
);
