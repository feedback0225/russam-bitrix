<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  24 => 
  array (
    'CONDITION' => '#^/wishlist/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1&$2',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/wishlist/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/video([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  50 => 
  array (
    'CONDITION' => '#^/search/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1&$2',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/search/index.php',
    'SORT' => 100,
  ),
  54 => 
  array (
    'CONDITION' => '#^/stati/([^\\/]+)/([^\\/]+)/($|\\?.*)#',
    'RULE' => 'SECTION_CODE=$1&ELEMENT_CODE=$2',
    'ID' => '',
    'PATH' => '/stati/detail.php',
    'SORT' => 100,
  ),
  48 => 
  array (
    'CONDITION' => '#^/new/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1&$2',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/new/index.php',
    'SORT' => 100,
  ),
  31 => 
  array (
    'CONDITION' => '#^/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  55 => 
  array (
    'CONDITION' => '#^/stati/([^\\/]+)/($|\\?.*)#',
    'RULE' => 'SECTION_CODE=$1',
    'ID' => '',
    'PATH' => '/stati/section.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/login/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/login/order/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/collections/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/collections/index.php',
    'SORT' => 100,
  ),
  36 => 
  array (
    'CONDITION' => '#^/materials/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/materials/index.php',
    'SORT' => 100,
  ),
  35 => 
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  59 => 
  array (
    'CONDITION' => '#^/products/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/products/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/login/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/login/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 100,
  ),
  58 => 
  array (
    'CONDITION' => '#^/stati/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/stati/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
  38 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  46 => 
  array (
    'CONDITION' => '#^/sale/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/sale/index.php',
    'SORT' => 100,
  ),
  52 => 
  array (
    'CONDITION' => '#^/p/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/p/index.php',
    'SORT' => 100,
  ),
);
