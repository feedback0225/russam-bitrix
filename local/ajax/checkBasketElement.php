<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
GLOBAL $APPLICATION;
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

$APPLICATION->RestartBuffer();
// Получаем корзину пользователя
$basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
    \Bitrix\Sale\Fuser::getId(),
    SITE_ID
);

echo json_encode(productInBasket($_POST['id']));
die();