<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$el = new CIBlockElement;
$PROP = array();
$arEventFields = [];
$elementName = 'Подарочная карта';

foreach($_POST as $pKey=>$pValue){
    $arEventFields[mb_strtoupper($pKey)] = $pValue;
    $PROP[mb_strtoupper($pKey)] = $pValue;
}

//if($_POST['storeEmail']){
//    $arEventFields['EMAIL'] = $_POST['storeEmail'];
//    CEvent::Send('PRODUCT_RESERVE',"s1",$arEventFields,"N","","","");
//    CEvent::CheckEvents();
//}

CEvent::Send('CARD_GIFT',"s1",$arEventFields,"N","","","");
CEvent::CheckEvents();





//if($_POST['product']){
//    $productID = str_replace(' ','',(explode("]",$_POST['product'])[0]));
//    $productID = explode(':',$productID)[1];
//    createLead(['TITLE' => 'Резерв в салоне','PHONE' => $_POST['phoneNumber'],'PRODUCTS_ID' => [$productID]]);
//    echo 'Резерв';
//}