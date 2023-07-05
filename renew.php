<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {


function setSimilarProductsByID2($elementID) {
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"ID"=>$elementID), false, Array("nPageSize"=>1), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_RELATED_ARTICUL_NEW","PROPERTY_ARTICLE"));
	if($ob = $res->GetNextElement()){ 
		$baseElement = $ob->GetFields();  
	}
	$baseArticle = $baseElement["PROPERTY_ARTICLE_VALUE"];
	// $elementsToUpdate = preg_replace('/\s+/', '', explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']));
	$elementsBase = explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']);
	$elementsToUpdate = array();
	foreach ($elementsBase as $element) {
		$elementsToUpdate[] = $element;
		$elementsToSearch[] = $element;
		$elementsToSearch[] = $element."000000";
	}
	
	// echo"<pre>";print_r($elementsToUpdate);echo"</pre>";
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"PROPERTY_ARTICLE"=>$elementsToSearch), false, Array("nPageSize"=>100), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_ARTICLE"));
	while($ob = $res->GetNextElement()){ 
		$element = $ob->GetFields();  
		echo"<pre>";print_r($element["PROPERTY_ARTICLE_VALUE"]);echo"</pre>";
		$similar = array();
		$similar[] = $baseArticle;
		$dopArticle = str_replace('000000','',$element["PROPERTY_ARTICLE_VALUE"]);
		foreach ($elementsToUpdate as $article) {
			if($article != $element["PROPERTY_ARTICLE_VALUE"] && $article != $dopArticle) {
				$similar[] = $article;
			}
		}
		$updateString = implode(",",$similar);
		// echo"<pre>";print_r($updateString);echo"</pre>";
		// CIBlockElement::SetPropertyValuesEx($element["ID"], false, array("RELATED_ARTICUL_NEW"=> $updateString));
	}
}





setSimilarProductsByID2(165293);






}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 