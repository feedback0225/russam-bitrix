<?php

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::includeModule('highloadblock');
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

const HL_SALEPRODUCTS = 22;

//активные скидки
$dbProductDiscounts = CCatalogDiscount::GetList(
	array("SORT" => "ASC"),
	array(
		"ACTIVE" => "Y",
		"!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", \CSite::GetDateFormat("FULL")),
		"!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS",  \CSite::GetDateFormat("FULL")),
		"COUPON" => "",
		"ID" => 28
	),
	false,
	false,
	array("*")
);
while ($arProductDiscounts = $dbProductDiscounts->Fetch()) {
	$activeDiscountsId = $arProductDiscounts;
}

/* if ($activeDiscountsId) {
	$hlClass = GetHLClass(HL_SALEPRODUCTS);
	$rsData = $hlClass::getList(array(
		'select' => array('*'),
		'filter' => array('UF_XML_ID' => $activeDiscountsId)
	));
	while ($el = $rsData->fetch()) {
		$oldProducts[$el['UF_XML_ID']] = $el;
	}
} */


echo "<pre>";
print_r(unserialize($activeDiscountsId['CONDITIONS']));
echo "</pre>";
die();

//foreach ($activeDiscountsId as $dId) {
	$res = CCatalogDiscount::GetDiscountProductsList(array(), array("PRODUCT_ID" => 75677), false, false, array()); //">=DISCOUNT_ID" => 31, "<DISCOUNT_ID" => 32
	while ($ob = $res->Fetch()) {
		/* if (!in_array($ob["PRODUCT_ID"], $arDiscountElementID)) {
			$arDiscountElementID[] = $ob["PRODUCT_ID"];
		} */
		echo "<pre>";
		var_dump($ob);
		echo "</pre>";
	}
//}



function GetHLClass($HlBlockId)
{
	if (empty($HlBlockId) || $HlBlockId < 1) {
		return false;
	}
	$hlblock = HLBT::getById($HlBlockId)->fetch();
	$entity = HLBT::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	return $entity_data_class;
}
