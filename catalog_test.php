<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {
	// echo"<pre>";print_r($_SERVER["DOCUMENT_ROOT"]);echo"</pre>";
	// $connection = Bitrix\Main\Application::getConnection();
	// $id = 190670;
	// $result = $connection->query('DELETE FROM b_catalog_price WHERE ID='.$id);
	// echo "<pre>";print_r($result);echo"</pre>";
	// CPrice::Delete(190476);
	// CPrice::GetBasePrice(187547);
	
	// function deleteEmptyPrices() {
	$arSelect = Array("NAME", "ID", "XML_ID",  "DETAIL_PAGE_URL", "PROPERTY_SUB_TITLE", "CATALOG_GROUP_2","PROPERTY_CUSTOM_PRICE");
	$arFilter = Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "CATALOG_PRICE_1"=>0, "PROPERTY_CUSTOM_PRICE" => false);
	$res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
	while ($element = $res->GetNext()) {
		$arResult["ELEMENTS"][] = $element;
		// $price = CPrice::GetBasePrice($element["ID"]);
		// if($price["PRICE"] == '0.00') {
		// CPrice::Delete($price["ID"]);
		// CPrice::SetBasePrice($element["ID"],0,"RUB");
		// }
		// echo "<pre>";print_r($element);echo"</pre>";
	}
	
	echo "<pre>";print_r(count($arResult["ELEMENTS"]));echo"</pre>";
	
	// }


}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 