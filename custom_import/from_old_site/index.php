<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    require __DIR__.'/../../vendor/autoload.php';
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
CModule::IncludeModule('catalog');
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {return false;}
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class;
}
?>
<div class="container">
<?
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


$workbook = $reader->load("exportProducts.xlsx");

$d = $workbook->getSheet(0)->toArray();

//echo count($d);
$workBook = $workbook->getActiveSheet()->toArray();
$file_clmn = 1;
//unset($workBook[0]);

foreach ($workBook as $key=>$dt) {
    if($key == 0) continue;
    // process element here;
    //debug($workBook[0][0]);
    $productArrayInitial = [
        $workBook[0][0] => $dt[0],
        $workBook[0][1] => $dt[1],
        $workBook[0][2] => $dt[2],
        $workBook[0][3] => $dt[3],
        $workBook[0][4] => $dt[4],
        $workBook[0][5] => $dt[5],
        $workBook[0][6] => $dt[6],
        $workBook[0][7] => $dt[7],
        $workBook[0][8] => $dt[8],
        $workBook[0][9] => $dt[9],
        $workBook[0][10] => $dt[10],
        $workBook[0][11] => $dt[11],
        $workBook[0][12] => $dt[12],
        $workBook[0][13] => $dt[13],
        $workBook[0][14] => json_decode($dt[14]),
        $workBook[0][15] => $dt[15] ? $dt[15] : $dt[1],
        $workBook[0][16] => $dt[16],
        $workBook[0][17] => $dt[17],
        $workBook[0][18] => $dt[18],
        $workBook[0][19] => $dt[19],
        $workBook[0][20] => $dt[20],
        $workBook[0][21] => $dt[21],
        $workBook[0][22] => $dt[22],
        $workBook[0][23] => $dt[23],
        $workBook[0][24] => $dt[24],
        $workBook[0][25] => $dt[25],
    ];

    $curProductId = existProductWithProp('MAIN_PRODUCT_ID',$productArrayInitial[$workBook[0][15]],5);
    $element = new CIBlockElement;
    $PROP = array();

    foreach (json_decode($dt[14])->templates as $key1=>$vstavka){ //Шаблон_вставки
        $PROP['VSTAVKA'][] = $vstavka->каменьШаблонаВставки . ' - ' . $vstavka->количествоШаблонаВставок . ' ,огранка «' . $vstavka->формаОгранкиШаблонаВставки . '»,' . $vstavka->цветШаблонаВставкии;
    }
    if($productArrayInitial['Артикул']){
        $PROP['ARTICLE'] = $productArrayInitial['Артикул'];
    }
    if($productArrayInitial['Коллекция']){
        $rsParentSection = CIBlockSection::GetList(Array('sort' => 'asc'), Array('IBLOCK_ID' => 5, 'ACTIVE' => 'Y','NAME' => $productArrayInitial['Коллекция']));
        while ($arParentSection = $rsParentSection->GetNext())
        {
            $PROP['PRODUCT_COLLECTION'] = $arParentSection['ID'];
        }
    }
    if($productArrayInitial['Товары_гарнитура']){
        foreach (explode(';',$productArrayInitial['Товары_гарнитура']) as $value){
            $PROP['PRODUCT_HEADSET'][] = $value;
        }
    }
    if($productArrayInitial['Новинка'] == 1){
        $PROP['NEW']['VALUE'] = 18;
    } else {
        $PROP['NEW']['VALUE'] = 19;
    }
    if($productArrayInitial['Бестселлер'] == 1){
        $PROP['BESTSELLER']['VALUE'] = 20;
    } else {
        $PROP['BESTSELLER']['VALUE'] = 21;
    }
    if($productArrayInitial['Бренд']){
        $entity_data_class = GetEntityDataClass(5);
        $curHLBTName = $productArrayInitial['Бренд'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['BRAND']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['BRAND']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Материал']){
        $PROP['SAMPLE_MATERIAL'] = $productArrayInitial['Материал'];
    }
    if($productArrayInitial['Вид_изделия'] && $productArrayInitial['Вид_изделия'] != 'null'){
        $entity_data_class = GetEntityDataClass(4);
        $curHLBTName = $productArrayInitial['Вид_изделия'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['ITEM_TYPE']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['ITEM_TYPE']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Для_кого']){
        $entity_data_class = GetEntityDataClass(10);
        foreach (explode(';',$productArrayInitial['Для_кого']) as $keyS=>$value){
            $curHLBTName = $value;
            $rsData = $entity_data_class::getList(array(
                'select' => array('UF_NAME','UF_XML_ID'),
                'order' => array('UF_NAME' => 'ASC'),
                'limit' => '1',
                'filter' => array('UF_NAME' => $curHLBTName)
            ));
            $exist = false;
            while($el = $rsData->fetch()){
                $PROP['FOR_WHO']['n'.$keyS]['VALUE'] = $el['UF_XML_ID'];
                $exist = true;
            }
            if(!$exist){
                $result = $entity_data_class::add(array(
                    'UF_NAME'         => $curHLBTName,
                    'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                    'UF_ACTIVE'       => '1',
                    'UF_SORT'         => 100,
                ));
                $PROP['FOR_WHO']['n'.$keyS]['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
            }
        }
    }
    if($productArrayInitial['Номенклатура_проработана'] == 1){
        $PROP['EDITED']['VALUE'] = 22;
    } else {
        $PROP['EDITED']['VALUE'] = 23;
    }
    if($productArrayInitial['Технологии']){
        $entity_data_class = GetEntityDataClass(16);
        foreach (explode(';',$productArrayInitial['Технологии']) as $keyS=>$value){
            $curHLBTName = $value;
            $rsData = $entity_data_class::getList(array(
                'select' => array('UF_NAME','UF_XML_ID'),
                'order' => array('UF_NAME' => 'ASC'),
                'limit' => '1',
                'filter' => array('UF_NAME' => $curHLBTName)
            ));
            $exist = false;
            while($el = $rsData->fetch()){
                $PROP['TECHNOLOGIES']['n'.$keyS]['VALUE'] = $el['UF_XML_ID'];
                $exist = true;
            }
            if(!$exist){
                $result = $entity_data_class::add(array(
                    'UF_NAME'         => $curHLBTName,
                    'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                    'UF_ACTIVE'       => '1',
                    'UF_SORT'         => 100,
                ));
                $PROP['TECHNOLOGIES']['n'.$keyS]['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
            }
        }
    }
    if($productArrayInitial['Код_товара_1С']){
        $PROP['MAIN_PRODUCT_ID'] = $productArrayInitial['Код_товара_1С'];
    }
    if($productArrayInitial['Тип_плетения']){
        $entity_data_class = GetEntityDataClass(17);
        $curHLBTName = $productArrayInitial['Тип_плетения'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['WEAVING_TYPE']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['WEAVING_TYPE']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Название_образа']){
        $PROP['FIGURE_NAME'] = $productArrayInitial['Название_образа'];
    }
    if($productArrayInitial['Знак_зодиака'] && $productArrayInitial['Знак_зодиака'] != '_'){
        $entity_data_class = GetEntityDataClass(11);
        $curHLBTName = $productArrayInitial['Знак_зодиака'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['ZODIAC_SIGN']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['ZODIAC_SIGN']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Тематика'] && $productArrayInitial['Тематика'] != '_'){
        $entity_data_class = GetEntityDataClass(12);
        $curHLBTName = $productArrayInitial['Тематика'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['THEMES']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['THEMES']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Направление_религии'] && $productArrayInitial['Направление_религии'] != '_'){
        $entity_data_class = GetEntityDataClass(13);
        $curHLBTName = $productArrayInitial['Направление_религии'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['RELIGION_WAY']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['RELIGION_WAY']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Название_набора'] && $productArrayInitial['Название_набора'] != '_'){
        $entity_data_class = GetEntityDataClass(14);
        $curHLBTName = $productArrayInitial['Название_набора'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['COMPLECT_NAME']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['COMPLECT_NAME']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Событие'] && $productArrayInitial['Событие'] != '_'){
        $entity_data_class = GetEntityDataClass(15);
        $curHLBTName = $productArrayInitial['Событие'];
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME','UF_XML_ID'),
            'order' => array('UF_NAME' => 'ASC'),
            'limit' => '1',
            'filter' => array('UF_NAME' => $curHLBTName)
        ));
        $exist = false;
        while($el = $rsData->fetch()){
            $PROP['EVENT']['VALUE'] = $el['UF_XML_ID'];
            $exist = true;
        }
        if(!$exist){
            $result = $entity_data_class::add(array(
                'UF_NAME'         => $curHLBTName,
                'UF_XML_ID'         => 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-")),
                'UF_ACTIVE'       => '1',
                'UF_SORT'         => 100,
            ));
            $PROP['EVENT']['VALUE'] = 'id-'.Cutil::translit($curHLBTName,"ru",array("replace_space"=>"-","replace_other"=>"-"));
        }
    }
    if($productArrayInitial['Причина_сокрытия_товара']){
        $activeProduct = 'N';
    } else {
        $activeProduct = "Y";
    }
    if($productArrayInitial['Отображать_без_серий']){
        $PROP['SHOW_WITHOUT_OFFERS']['VALUE'] = 24;
    } else {
        $PROP['SHOW_WITHOUT_OFFERS']['VALUE'] = 25;
    }
    if($productArrayInitial['Ручной_ввод_цены'] && $productArrayInitial['Ручной_ввод_цены'] != 'null'){
        $PROP['CUSTOM_PRICE'] = $productArrayInitial['Ручной_ввод_цены'];
    }


    $arLoadProductArray = Array(
        "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
//            "IBLOCK_SECTION_ID" => 19,
        "IBLOCK_ID"      => 5,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $productArrayInitial[$workBook[0][15]],
        "CODE"           => Cutil::translit($productArrayInitial[$workBook[0][15]],"ru",array("replace_space"=>"-","replace_other"=>"-")),
        "ACTIVE"         => $activeProduct,// активен
    );
    if($curProductId) {
        $elementSections = CIBlockElement::GetElementGroups($curProductId, true);
        while($elementSection = $elementSections->Fetch())
            $arLoadProductArray['IBLOCK_SECTION'][] = $elementSection['ID'];
        if($PROP['PRODUCT_COLLECTION']) $arLoadProductArray['IBLOCK_SECTION'][] = $PROP['PRODUCT_COLLECTION'];
        $element->Update($curProductId,$arLoadProductArray);
        $PRODUCT_ID = $curProductId;
        if(!$PRODUCT_ID) {
            AddMessage2Log($element->LAST_ERROR);
            continue;
        }
    } else {
        $arLoadProductArray['IBLOCK_SECTION'] = [19];
        if($PROP['PRODUCT_COLLECTION']) $arLoadProductArray['IBLOCK_SECTION'][] = $PROP['PRODUCT_COLLECTION'];
        $PRODUCT_ID = $element->Add($arLoadProductArray);
        if(!$PRODUCT_ID) {
            AddMessage2Log($element->LAST_ERROR);
            continue;
        }
    }
    debug($PRODUCT_ID);

    $file_clmn++;
    if($key>1) break;
}
AddMessage2Log('Executed all!!!!');
?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>