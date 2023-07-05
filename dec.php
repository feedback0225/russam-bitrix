<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {
	

	// function deactivateGoodsFromList() {
		// $disableElementRes = CIBlockElement::GetList([], ['IBLOCK_ID' => 19, 'ACTIVE' => 'Y'], false, false, ['PREVIEW_TEXT']); 
		// if ($disableElement = $disableElementRes->GetNextElement()) {
			// $disableElementFields = $disableElement->GetFields();
			// $strings = preg_split('/\r\n|\r|\n/', $disableElementFields['PREVIEW_TEXT']);
			// foreach($strings as $num => $str) {
				// $value = intval($str);
				// if($str>0) {
					// $el = new CIBlockElement;
					// $el->Update($str, array('ACTIVE' => 'N'));
				// }
			// }
		// } else {
			
		// }
		
	// }
	
	// echo"<pre>";print_r($_SERVER["DOCUMENT_ROOT"]);echo"</pre>";
	// $connection = Bitrix\Main\Application::getConnection();
	// $id = 190670;
	// $result = $connection->query('DELETE FROM b_catalog_price WHERE ID='.$id);
	// echo "<pre>";print_r($result);echo"</pre>";
	// CPrice::Delete(190476);
	// CPrice::GetBasePrice(187547);
	
	// function deleteEmptyPrices() {
	// CModule::IncludeModule("sale");
	// $products = array();
	// $arSelect = Array("NAME", "ID", "ACTIVE", "XML_ID",  "DETAIL_PAGE_URL", "PROPERTY_SUB_TITLE", "CATALOG_GROUP_2","PROPERTY_SHOW_WITHOUT_OFFERS");
	// $arFilter = Array("IBLOCK_ID" => 5,'PROPERTY_SHOW_WITHOUT_OFFERS' => 25,"CATALOG_TYPE"=>3); //25 - N, 24 - Y
	// $res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, Array("nPageSize"=>5), $arSelect);
	// while ($element = $res->GetNext()) {
		// $arResult["ELEMENTS"][] = $element;
	// $products[] = $element["ID"];
		// $price = CPrice::GetBasePrice($element["ID"]);
		// if($price["PRICE"] == '0.00') {
		// CPrice::Delete($price["ID"]);
		// CPrice::SetBasePrice($element["ID"],0,"RUB");
		// }
		// echo "<pre>";print_r($element);echo"</pre>";
	// }
	
	// echo "<pre>";print_r(count($arResult["ELEMENTS"]));echo"</pre>";
	// echo "<pre>";print_r($products);echo"</pre>";
	
	// $offersExist = CCatalogSKU::getExistOffers(164593);
	// function deactivateCollectionsByProductID($PRODUCT_ID) {
		// $offers = CCatalogSKU::getOffersList($PRODUCT_ID);
		// foreach ($offers[$PRODUCT_ID] as $id => $offer) {
			// $el = new CIBlockElement;
			// $el->Update($id, ['ACTIVE'=>'N']);
		// }
	// }
	
	// deactivateCollectionsByProductID(164593);
	
	// deactivateCollectionsByProductID(164593);
	
	// echo "<pre>";print_r($offersExist);echo"</pre>";
	// foreach ($offersExist as $productID => $flag) {
		// echo "Товар с ID
	// }
	// }
	// CModule::IncludeModule("iblock");
	// CModule::IncludeModule("sale");
	// CModule::IncludeModule("Catalog");
	
	    // $db_res = CCatalogProduct::GetList(
            // array("QUANTITY" => "DESC"),
            // array(),
            // false,
            // false,
            // array('ID')
        // );
        
    // while ($ar_res = $db_res->Fetch())
    // {
		// echo "<pre>";print_r($ar_res);echo"</pre>";
	// }
		// echo "<pre>";print_r($db_res -> SelectedRowsCount());echo"</pre>";

}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 