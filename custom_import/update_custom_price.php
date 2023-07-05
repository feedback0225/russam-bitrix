<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

$arSelect = array("ID", "NAME", "IBLOCK_ID", "TYPE" => 1, "SCALED_PRICE_1", "PROPERTY_CUSTOM_PRICE");
$arFilter = array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "!PROPERTY_CUSTOM_PRICE" => false, "<SCALED_PRICE_1" => 100);
$res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
while ($ob = $res->Fetch()) {
	$arFields = array(
		"PRODUCT_ID" => $ob['ID'],
		"CATALOG_GROUP_ID" => 1,
		"PRICE" => $ob["PROPERTY_CUSTOM_PRICE_VALUE"],
		"CURRENCY" => "RUB",
	);
	$resPrice = CPrice::GetList(array(), array("PRODUCT_ID" => $ob['ID']));
	if ($arPrice = $resPrice->Fetch()) {
		CPrice::Update($arPrice["ID"], $arFields);
		echo $ob['NAME'] . " [" . $ob['ID'] . "], обновление цены " . $ob["PROPERTY_CUSTOM_PRICE_VALUE"] . "<br/>";
	} else {
		CPrice::Add($arFields);
		echo $ob['NAME'] . " [" . $ob['ID'] . "], установка цены " . $ob["PROPERTY_CUSTOM_PRICE_VALUE"] . "<br/>";
	}
}

echo "<br/><br/>Готово.";
