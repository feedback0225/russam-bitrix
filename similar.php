<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {
	CModule::IncludeModule("iblock");
	//174597
	
	function setSimilarProductsByID2($elementID) {
		CModule::IncludeModule("iblock");
		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"ID"=>$elementID), false, Array("nPageSize"=>1), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_RELATED_ARTICUL_NEW","PROPERTY_ARTICLE"));
		if($ob = $res->GetNextElement()){ 
			$baseElement = $ob->GetFields();  
		}
		$baseArticle = $baseElement["PROPERTY_ARTICLE_VALUE"];
		$elementsToUpdate = preg_replace('/\s+/', '', explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']));
		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"PROPERTY_ARTICLE"=>$elementsToUpdate), false, Array("nPageSize"=>100), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_ARTICLE"));
		while($ob = $res->GetNextElement()){ 
			$element = $ob->GetFields();  
			$similar = array();
			$similar[] = $baseArticle;
			foreach ($elementsToUpdate as $article) {
				if($article != $element["PROPERTY_ARTICLE_VALUE"]) {
					$similar[] = $article;
				}
			}
			$updateString = implode(", ",$similar);
			echo"<pre>";print_r($toUpdateStr);echo"</pre>";
			// CIBlockElement::SetPropertyValuesEx($element["ID"], false, array("RELATED_ARTICUL_NEW"=> $updateString));
		}
	}
	
	// setSimilarProductsByID2(174597);
	
	//
	
	/*
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"ID"=>174597), false, Array("nPageSize"=>1), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_RELATED_ARTICUL_NEW","PROPERTY_ARTICLE"));
	if($ob = $res->GetNextElement()){ 
		$baseElement = $ob->GetFields();  
	}
	
	$baseArticle = $baseElement["PROPERTY_ARTICLE_VALUE"];
	

	$elementsToUpdate = preg_replace('/\s+/', '', explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']));
	

	
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"PROPERTY_ARTICLE"=>$elementsToUpdate), false, Array("nPageSize"=>100), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_ARTICLE"));
	while($ob = $res->GetNextElement()){ 
		$element = $ob->GetFields();  
		//echo"<pre>";print_r($element);echo"</pre>";
		// $prepareToUpdate[]
		$similar = array();
		$similar[] = $baseArticle;
		foreach ($elementsToUpdate as $article) {
			if($article != $element["PROPERTY_ARTICLE_VALUE"]) {
				$similar[] = $article;
			}
		}
		$element["TO_UDPATE"] = $similar;
		$toUpdateStr = implode(",",$similar);
		echo"<pre>";print_r($toUpdateStr);echo"</pre>";
	}
	*/
	
	// foreach($elementsToUpdate as $element) {
		
	// }
	
	
	// echo"<pre>";print_r($elements);echo"</pre>";
	// echo"<pre>";print_r($baseElement);echo"</pre>";
	// $iterator = CIBlockElement::GetPropertyValues(183201, array('ACTIVE' => 'Y'), true, array('ID' => array(10, 14)));
	
	
	// CIBlockElement::SetPropertyValuesEx(183201, false, array("RELATED_ARTICUL_NEW"=> "54252, 54285, 88946, 54256, 54095, 54094"));
	
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
	
	// $offersExist = CCatalogSKU::getExistOffers($products);
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