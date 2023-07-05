<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {

	
	
    // $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y',"ID" => [96631],'PROPERTY_PREVIEW_IMAGES' => false);
    $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y',"ID" => [113099]);
    $res = CIBlockElement::GetList(Array(), $arrFilter, false,["nPageSize"=>10000,'iNumPage' => 1]);
    global $checkDirectoryForImg;
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        $mainProductID = $arProps['MAIN_PRODUCT_ID']['VALUE'];
        writeToLogs($mainProductID,'$updatesNewImages');
        $updatesNewImages = [];

        $resultImages = [];
        $imageCount = 0;
        for($imageCounter = 0;$imageCounter < 30;$imageCounter++){
            $tempProductID = $mainProductID.(($imageCounter>=1) ? '_'.$imageCounter:'');
            global $checkDirectoryForImg;
            $img = checkExistFileAndGetExtension('/home/bitrix/www',$checkDirectoryForImg,$tempProductID);
            if($img['exists']) {
                // writeToLogs('https://market.russam.ru' . $img['position'],'$updatesNewImages');
                $resultImages[] = 'https://market.russam.ru' . $img['position'];
            }
        }
		
		echo"<pre>";print_r($resultImages);echo"</pre>";
		


        $addedImageCount = 0;
		
        // foreach($resultImages as $rImage){
            // $fileID = '';
            // $fileName = explode('/', $rImage)[count(explode('/', $rImage)) - 1];
            // $fileName = strtok($fileName, '?');
            // $resFile = CFile::GetList(array("FILE_SIZE" => "desc"), array("ORIGINAL_NAME" => $fileName));
            // while ($resF = $resFile->GetNext()) {
                // $fileID = $resF['ID'];
            // }

            // if($fileID) {
                // CFile::Delete($fileID);
                // $file = CFile::MakeFileArray($rImage);
                // $file['MODULE_ID'] = 'iblock';
                // $fileID = CFile::SaveFile($file, "products");
            // } else {
                // $file = CFile::MakeFileArray($rImage);
                // $file['MODULE_ID'] = 'iblock';
                // $fileID = CFile::SaveFile($file, "products");
            // }
            // if($fileID > 0){
                // $newProductImg = 'https://market.russam.ru' . imageX2($fileID,'300')[0];
                // $updatesNewImages['n' . ($addedImageCount++)] = CFile::MakeFileArray($newProductImg);
            // }
        // }
		
		// echo"<pre>";print_r($updatesNewImages);echo"</pre>";

        if($updatesNewImages){
            // writeToLogs($updatesNewImages,'$updatesNewImages');
            // CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'],['PREVIEW_IMAGES' => $updatesNewImages]);
        }
		
		
    }
	// CModule::IncludeModule("iblock");
	// $element = new CIBlockElement;
	// $arLoadProductArray = Array(
		// "MODIFIED_BY"    => 2533,
	// );
	// $result = $element->Update(90722, $arLoadProductArray);
	
	// echo"<pre>";print_r($result);echo"</pre>";
	// global $checkDirectoryForImg;
	// echo "<pre>";print_r($checkDirectoryForImg);echo"</pre>";
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 