<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$el = new CIBlockElement;
$PROP = array();
$arEventFields = [];
$elementName = 'Резерв в салоне';

foreach ($_POST as $pKey => $pValue) {
	$arEventFields[mb_strtoupper($pKey)] = $pValue;
	$PROP[mb_strtoupper($pKey)] = $pValue;
}


if (!empty($_POST['storeEmail'])) {
	$arEventFields['EMAIL'] = $_POST['storeEmail'][0];
	CEvent::Send('PRODUCT_RESERVE', "s1", $arEventFields, "N", "", "", "");
	CEvent::CheckEvents();
}
//foreach (\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SEND_EMAIL_TO") as $email){
//    $arEventFields['EMAIL'] = $email;
//    CEvent::Send($_POST['mailTemplate'],"s1",$arEventFields,"N","","","");
//    CEvent::CheckEvents();
//}


if ($_POST['product']) {
	$productID = str_replace(' ', '', (explode("]", $_POST['product'])[0]));
	$productID = explode(':', $productID)[1];
	createLead(['TITLE' => 'Резерв в салоне', 'PHONE' => $_POST['phoneNumber'], 'PRODUCTS_ID' => [$productID]]);
	echo 'Резерв';
}
