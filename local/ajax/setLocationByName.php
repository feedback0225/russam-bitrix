<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
GLOBAL $APPLICATION;
$APPLICATION->RestartBuffer();

use \Rover\GeoIp\Location;


if($_POST['townName']){
    $userIP = Location::getCurIp();
    $userLocation = [];

    $obCache = new CPHPCache;
    $life_time = 60*60*24*7; //7 дней
    $cache_id = 'userIP: ' . $userIP;

    $obCache->Clean($cache_id);
    if($obCache->InitCache($life_time, $cache_id, "/")):

    else:
        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => array('=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => 'ru','=NAME.NAME' => $_POST['townName']),
            'select' => array('*')
        ));
        while ($item = $res->fetch()) {
            $userLocation = $item;
            $userLocation['NAME'] = $_POST['townName'];
            $userLocation['ZIP'] = CSaleLocation::GetLocationZIP($userLocation['ID'])->Fetch()['ZIP'];
        }
        if(empty($userLocation)){
            //Если не удалось узнать город, устанавливаем стандартно Москву
            $userLocation['NAME'] = 'Москва';
            $userLocation['ID'] = '216';
            $userLocation['CODE'] = '0000073738';
            $userLocation['ZIP'] = '101000';
        }
    endif;
    if($obCache->StartDataCache()):
        $obCache->EndDataCache($userLocation);
    endif;
}


