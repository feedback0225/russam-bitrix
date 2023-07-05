<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arEventFields = [];
foreach($_POST as $pKey=>$pValue){
    $arEventFields[mb_strtoupper($pKey)] = $pValue;
    $PROP[mb_strtoupper($pKey)] = $pValue;
}

foreach (\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SEND_EMAIL_TO") as $email){
    $arEventFields['EMAIL'] = $email;
    CEvent::Send($_POST['mailTemplate'],"s1",$arEventFields,"N","","","");
    CEvent::CheckEvents();
}

echo json_encode('1');

die();