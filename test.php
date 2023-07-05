<?php exit();
if(!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
}
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/autoupdate/config.php');

$resIblock = CIBlockElement::GetList(
    array('ID' => 'ASC'),
    array(
        'IBLOCK_ID' => '5',
        'PROPERTY_55_9306171' => 95788
    ),
    false,
    false,
    array('ID', 'CODE', 'PROPERTY_55_9306171_VALUE')
);

while($arID = $resIblock->Fetch()) {
    $productID = $arID['ID'];
}

$results = CCatalogSKU::getOffersList(
    $productID, // массив ID товаров
    5, // указываете ID инфоблока только в том случае, когда ВЕСЬ массив товаров из одного инфоблока и он известен
    array('ACTIVE' => 'Y'),
    array('PROPERTY_41_VALUE', 'PROPERTY_40_VALUE', 'PROPERTY_46_VALUE', 'PROPERTY_44_VALUE', 'PROPERTY_45_13901793_VALUE'),
    array('ID')
);

debug($results);