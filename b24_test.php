<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use \App\Bitrix24\Bitrix24API;

// $webhookURL = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/';
// $bx24 = new Bitrix24API($webhookURL);

function exportProductsBX24Manual(){
    CModule::IncludeModule('catalog');

    $webhookURL = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/';
    $bx24 = new Bitrix24API($webhookURL);
    $db_res = CCatalogProduct::GetList(
            array("QUANTITY" => "DESC"),
            array(),
            false,
            array("nTopCount" => 100),
            array('ID')
        );
        
    while ($ar_res = $db_res->Fetch())
    {
        echo $ar_res['ID'];
        $mxResult = CCatalogSku::GetProductInfo($ar_res['ID']);
        $product = false;
        $props = [];
        $rsElement = CIBlockElement::GetList(
            $arOrder  = array("SORT" => "ASC"),
            $arFilter = array(
                "ID" => $ar_res['ID'],
                "IBLOCK_ID" => [5, 6]
            ),
            false,
            false,
            $arSelectFields = array("*", "PROPERTY_*")
        );
        if($ob = $rsElement->GetNextElement()) {
            $props = $ob->GetProperties();
        }
        if (is_array($mxResult))
        {
            $element = CIBlockElement::GetByID($mxResult['ID'])->GetNext();
        }
        else{
            $element = CIBlockElement::GetByID($ar_res['ID'])->GetNext();
        }
            $generator = $bx24->getProductList(['XML_ID' => $ar_res['ID']]);
            
        foreach ($generator as $arItems) {
            foreach($arItems as $arItem) {
                $product = true;
                $arFields = [
                    "PRODUCT_NAME" => $element['NAME'].' '.$ar_res['ELEMENT_NAME'] . ' ' . $props['SERIES_ID_PROPERTY']['VALUE'],
                    "NAME"        => $element['NAME'].' '.$ar_res['ELEMENT_NAME']. ' '.$props['SERIES_ID_PROPERTY']['VALUE'],
                    "CURRENCY_ID" => "RUB",
                    "PRICE"       => (int)CPrice::GetBasePrice($ar_res['ID'])['PRICE'],
                    "SORT"        => 500,
                    "XML_ID" => $ar_res['ID'],
                    'DETAIL_PICTURE' => $element['DETAIL_PICTURE'] && !$arItem['DETAIL_PICTURE'] ? ["fileData" => [$arItem['CODE'].'_detail.jpg', base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($element['DETAIL_PICTURE'])))]] : '',
                    'PREVIEW_PICTURE' => $element['PREVIEW_PICTURE'] && !$arItem['PREVIEW_PICTURE'] ? ["fileData" => [$arItem['CODE'].'_preview.jpg', base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($element['PREVIEW_PICTURE'])))]] : '',
                    'ACTIVE' => $ar_res['AVAILABLE'],
                    'PROPERTY_137' => ['VALUE' => $ar_res['AVAILABLE'] ? 93 : ''],
                    'PROPERTY_139' => ['VALUE' => $ar_res['AVAILABLE'] ? '' : 95],
                    'PROPERTY_125' => $props['SERIES_WIDTH']['VALUE'],
                    'PROPERTY_127' => $props['SERIES_HEIGHT']['VALUE'],
                    'PROPERTY_123' => $props['SERIES_LENGTH']['VALUE'],
                    'PROPERTY_121' => $props['SERIES_WEIGHT']['VALUE'],
                    'PROPERTY_119' => $props['SERIES_RING_SIZE']['VALUE'],
                    'PROPERTY_117' => $props['SERIES_INSERT']['VALUE'],
                    'PROPERTY_115' => $props['SERIES_ID_PROPERTY']['VALUE'] ?? $props['ARTICLE']

                ];
                AddMessage2Log($arFields);
                $bx24->updateProduct($arItem['ID'], $arFields);
                
            }
        }
        if(!$product){
            $bx24->addProduct([
                "PRODUCT_NAME" => $element['NAME'].' '.$ar_res['ELEMENT_NAME'] . ' '. $props['SERIES_ID_PROPERTY']['VALUE'],
                "NAME"        => $element['NAME'].' '.$ar_res['ELEMENT_NAME'] . ' '. $props['SERIES_ID_PROPERTY']['VALUE'],
                "CURRENCY_ID" => "RUB",
                "PRICE"       => (int)CPrice::GetBasePrice($ar_res['ID'])['PRICE'],
                "SORT"        => 500,
                "XML_ID" => $ar_res['ID'],
                'DETAIL_PICTURE' => $element['DETAIL_PICTURE'] ? ["fileData" => [$arItem['CODE'].'_detail.jpg', base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($element['DETAIL_PICTURE'])))]] : '',
                'PREVIEW_PICTURE' => $element['PREVIEW_PICTURE'] ? ["fileData" => [$arItem['CODE'].'_preview.jpg', base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($element['PREVIEW_PICTURE'])))]] : '',
                'ACTIVE' => $ar_res['AVAILABLE'],
                'PROPERTY_137' => ['VALUE' => $ar_res['AVAILABLE'] ? 93 : ''],
                'PROPERTY_139' => ['VALUE' => $ar_res['AVAILABLE'] ? '' : 95],
                'PROPERTY_125' => $props['SERIES_WIDTH']['VALUE'],
                'PROPERTY_127' => $props['SERIES_HEIGHT']['VALUE'],
                'PROPERTY_123' => $props['SERIES_LENGTH']['VALUE'],
                'PROPERTY_121' => $props['SERIES_WEIGHT']['VALUE'],
                'PROPERTY_119' => $props['SERIES_RING_SIZE']['VALUE'],
                'PROPERTY_117' => $props['SERIES_INSERT']['VALUE'],
                'PROPERTY_115' => $props['SERIES_ID_PROPERTY']['VALUE'] ?? $props['ARTICLE']
            ]);
        }
        // echo 1;
    }
    return "exportProductsBX24();";
}

// $reflector = new \ReflectionClass($bx24);
// $file = $reflector->getFileName();

// echo "<pre>";print_r($bx24->getDeal(212505));echo"</pre>";
// echo "<pre>";print_r($bx24->getDeal(212505));echo"</pre>";

// global $USER;
// if($USER->IsAdmin()) {

	// echo "<pre>";print_r($db_res -> SelectedRowsCount());echo"</pre>";

// }

// exportProductsBX24Manual();


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 