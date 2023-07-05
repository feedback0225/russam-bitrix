<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/xml.php');
$APPLICATION->SetTitle("РусСамоцвет");
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
    <br>
    <br>
    <br>
    <?
    $xml = new CDataXML();
    $xml->LoadString(file_get_contents('https://russ.ruso.agency/custom_import/from_1c/initialImport.XML'));

    $curProductId = 0;
    $storeNAME2ID = [
        '18' => 14, //DONE
        '19' => 3, //DONE
        '25' => 4, //DONE
        'КУ010' => 5,
        '24' => 5, //DONE
        '9' => 6, //DONE
        '8' => 7, //DONE
        '13' => 8, //DONE
        'ЮС082' => 9, //DONE
        'ЮС083' => 11,
        'ЮС093' => 12, //DONE
        '000000002' => 7, //DONE
        'ЮС097' => 17, //DONE
        'ЮС104' => 18, //DONE
        '27' => 21,
    ];
    $hlbPropArray = [
        '5' => ['NAME' => 'Тип изделия','HLBT_ID' => '4'],
        '15' => ['NAME' => 'Бренд','HLBT_ID' => '5'],
        'e6b1a572-667f-11e9-815d-0cc47a6c103e' => ['NAME' => 'Ан. Бренд','HLBT_ID' => '6'],
    ];
    $productPropArray = [
        '5' => ['NAME' => 'Тип изделия','CODE' => 'ITEM_TYPE','TYPE' => 'HLB'],
        '15' => ['NAME' => 'Бренд','CODE' => 'BRAND','TYPE' => 'HLB'],
        'e6b1a572-667f-11e9-815d-0cc47a6c103e' => ['NAME' => 'Ан. Бренд','CODE' => 'AN_BRAND','TYPE' => 'HLB'],
        '1' => ['NAME' => 'Артикул','CODE' => 'ARTICLE','TYPE' => 'STRING'],
        '2' => ['NAME' => 'ИД_товара','CODE' => 'PRODUCT_ID','TYPE' => 'STRING'],
        '3' => ['NAME' => 'Альтернативные наименования','CODE' => 'ALTERNATIVE_NAME','TYPE' => 'STRING'],
        '4' => ['NAME' => 'Аналоги','CODE' => 'ANALOGS','TYPE' => 'STRING'],
        '6' => ['NAME' => 'Статус производства','CODE' => 'PRODUCTION_STATUS','TYPE' => 'STRING'],
        '8' => ['NAME' => 'Нормативный вес','CODE' => 'PRODUCT_WEIGHT','TYPE' => 'STRING'],
        '9' => ['NAME' => 'Розничная стоимость','CODE' => 'PRODUCT_PRICE','TYPE' => 'STRING'],
        '10' => ['NAME' => 'Розничная цена за 1гр','CODE' => 'PRODUCT_PRICE_GR','TYPE' => 'STRING'],
        '11' => ['NAME' => 'Розничная цена со скидкой','CODE' => 'PRODUCT_PRICE_SALE','TYPE' => 'STRING'],
        '12' => ['NAME' => 'Наличие в интернет магазине','CODE' => 'AVAILABLE_SHOP','TYPE' => 'STRING'],
        '16' => ['NAME' => 'Наличие в розничных магазинах','CODE' => 'AVAILABLE_SHOP_ROZ','TYPE' => 'STRING'],
        '13' => ['NAME' => 'Средний размер','CODE' => 'MEDIUM_SIZE','TYPE' => 'STRING'],
        '14' => ['NAME' => 'Материал пробы','CODE' => 'SAMPLE_MATERIAL','TYPE' => 'STRING'],
        '31' => ['NAME' => 'Весовой товар','CODE' => 'PRODUCT_PRODUCT_WEIGHT','TYPE' => 'STRING'],
        '32' => ['NAME' => 'Гарнитур','CODE' => 'PRODUCT_HEADSET','TYPE' => 'STRING'],
        '55' => ['NAME' => 'Средний вес','CODE' => 'PRODUCT_MEDIUM_WEIGHT','TYPE' => 'STRING'],
    ];
    $seriesPropArray = [
        '20' => ['NAME' => 'Наименование серии','CODE' => 'SERIES_NAME'],
        '120' => ['NAME' => 'Длина','CODE' => 'SERIES_LENGTH'],
        '121' => ['NAME' => 'Ширина','CODE' => 'SERIES_WIDTH'],
        '122' => ['NAME' => 'Высота','CODE' => 'SERIES_HEIGHT'],
        '123' => ['NAME' => 'Объем','CODE' => 'SERIES_VOLUME'],
        '124' => ['NAME' => 'Диаметр','CODE' => 'SERIES_DIAMETER'],
        '21' => ['NAME' => 'ID_Характеристики','CODE' => 'SERIES_ID_PROPERTY'],
        '23' => ['NAME' => 'Вес серии','CODE' => 'SERIES_WEIGHT','TYPE' => 'HLB','HLBT_ID' => 7],
        '24' => ['NAME' => 'Розничная цена серии','CODE' => 'SERIES_PRICE_ROZ'],
        '25' => ['NAME' => 'Розничная цена серии за гр.','CODE' => 'SERIES_PRICE_ROZ_GR'],
        '26' => ['NAME' => 'Розничная цена серии со скидкой','CODE' => 'SERIES_PRICE_ROZ_SALE'],
        '27' => ['NAME' => 'Наличие в розничном магазине','CODE' => 'SERIES_AVAILABLE_ROZ_SHOP'],
        '34' => ['NAME' => 'Количество','CODE' => 'SERIES_COUNT'],
        '28' => ['NAME' => 'Размер кольца','CODE' => 'SERIES_RING_SIZE','TYPE' => 'HLB','HLBT_ID' => 8],
        '29' => ['NAME' => 'Вставка','CODE' => 'SERIES_INSERT'],
        '30' => ['NAME' => 'Полное наименование серии','CODE' => 'SERIES_FULL_NAME'],
        '35' => ['NAME' => 'Не показывать на сайте','CODE' => 'SERIES_SHOW'],
        '45' => ['NAME' => 'Тип цены','CODE' => 'SERIES_PRICE_TYPE'],
    ];
    //var_dump(existProductWithName('Штаны Полосатый Рейс',2));
    $arData = $xml->GetArray();
    foreach ($arData['КоммерческаяИнформация']['#']['Классификатор'][0]['#']['Свойства'][0]['#']['Свойство'] as $property){
        if($property['#']['ТипЗначений'][0]['#'] == 'Справочник') {
            $sort = 100;
            foreach ($property['#']['ВариантыЗначений'][0]['#']['Справочник'] as $spravVal){
                $entity_data_class = GetEntityDataClass($hlbPropArray[$property['#']['ИД'][0]['#']]['HLBT_ID']);
                $rsData = $entity_data_class::getList(array(
                    'select' => array('UF_NAME'),
                    'order' => array('UF_NAME' => 'ASC'),
                    'limit' => '1',
                    'filter' => array('UF_NAME' => $spravVal['#']['Значение'][0]['#'])
                ));
                $exist = false;
                while($el = $rsData->fetch()){
                    //debug('Exists');
                    $exist = true;
                }
                if(!$exist){
                    $result = $entity_data_class::add(array(
                        'UF_NAME'         => $spravVal['#']['Значение'][0]['#'],
                        'UF_XML_ID'         => $spravVal['#']['ИДЗначения'][0]['#'],
                        'UF_ACTIVE'       => '1',
                        'UF_SORT'         => $sort,
                    ));
                    //debug('CREATE');
                }
                $sort++;
            }
        } else {
            continue;
        }
    }
    $iii = 0;
    foreach ($arData['КоммерческаяИнформация']['#']['Каталог'][0]['#']['Номенклатуры'][0]['#']['Номенклатура'] as $catalogITEM){
        AddMessage2Log("currentItem[".$iii."]: " . $catalogITEM['#']['ИД'][0]['#']);
        $curProductId = existProductWithProp('MAIN_PRODUCT_ID',$catalogITEM['#']['ИД'][0]['#'],5);
        $el = new CIBlockElement;
        $PROP = array();
        foreach ($catalogITEM['#']['ЗначенияCвойств'][0]['#']['ЗначениеСвойства'] as $produtProp){
            if($productPropArray[$produtProp['#']['ИД'][0]['#']]['TYPE'] == 'HLB'){
                $PROP[$productPropArray[$produtProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $produtProp['#']['Значение'][0]['#'];
            } else {
                $PROP[$productPropArray[$produtProp['#']['ИД'][0]['#']]['CODE']] = $produtProp['#']['Значение'][0]['#'];
            }
        }
        $PROP['MAIN_PRODUCT_ID'] = $catalogITEM['#']['ИД'][0]['#'];
        $arLoadProductArray = Array(
            "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
//            "IBLOCK_SECTION_ID" => 19,
            "IBLOCK_ID"      => 5,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $catalogITEM['#']['ИД'][0]['#'],
            "CODE"           => Cutil::translit($catalogITEM['#']['ИД'][0]['#'],"ru",array("replace_space"=>"-","replace_other"=>"-")),
            "ACTIVE"         => "Y",            // активен
        );
        if($curProductId) {
            $el->Update($curProductId,$arLoadProductArray);
            $PRODUCT_ID = $curProductId;
            if(!$PRODUCT_ID) {
                AddMessage2Log($el->LAST_ERROR);
                continue;
            }
        } else {
            $PRODUCT_ID = $el->Add($arLoadProductArray);
            if(!$PRODUCT_ID) {
                AddMessage2Log($el->LAST_ERROR);
                continue;
            }
        }
        if($catalogITEM['#']['Серии'][0]['#']['Серия'])
        {
            echo "Product with series ID: ". $PRODUCT_ID;
            foreach ($catalogITEM['#']['Серии'][0]['#']['Серия'] as $seria){
                $obElement = new CIBlockElement();
                $arOfferProps = [];
                // свойства торгвоого предложения
                $arOfferProps[31] = $PRODUCT_ID;
                foreach ($seria['#']['ЗначениеСвойств'][0]['#']['ЗначениеСвойства'] as $sProp){
                    if($seriesPropArray[$sProp['#']['ИД'][0]['#']]['TYPE'] == 'HLB'){
                        if(!$sProp['#']['Значение'][0]['#']) continue;
                        $entity_data_class = GetEntityDataClass($seriesPropArray[$sProp['#']['ИД'][0]['#']]['HLBT_ID']);
                        if($seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE'] == 'SERIES_RING_SIZE') {
                            $rsData = $entity_data_class::getList(array(
                                'select' => array('UF_NAME'),
                                'order' => array('UF_NAME' => 'ASC'),
                                'limit' => '1',
                                'filter' => array('UF_NAME' => str_replace(',0','',str_replace('.0','',$sProp['#']['Значение'][0]['#'])))
                            ));
                            $exist = false;
                            while($el = $rsData->fetch()){
                                //debug('exists: '.$sProp['#']['Значение'][0]['#']);
                                $exist = true;
                            }
                            if(!$exist){
                                $result = $entity_data_class::add(array(
                                    'UF_NAME'         => str_replace(',0','',str_replace('.0','',$sProp['#']['Значение'][0]['#'])),
                                    'UF_XML_ID'       => $sProp['#']['ИД'][0]['#'].'-'.str_replace(',0','',str_replace('.0','',$sProp['#']['Значение'][0]['#'])),
                                    'UF_ACTIVE'       => '1',
                                    'UF_SORT'         => 100,
                                ));
                            }
                            $arOfferProps[$seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $sProp['#']['ИД'][0]['#'].'-'.str_replace(',0','',str_replace('.0','',$sProp['#']['Значение'][0]['#']));
                        } else {
                            $rsData = $entity_data_class::getList(array(
                                'select' => array('UF_NAME'),
                                'order' => array('UF_NAME' => 'ASC'),
                                'limit' => '1',
                                'filter' => array('UF_NAME' => $sProp['#']['Значение'][0]['#'])
                            ));
                            $exist = false;
                            while($el = $rsData->fetch()){
                                //debug('exists: '.$sProp['#']['Значение'][0]['#']);
                                $exist = true;
                            }
                            if(!$exist){
                                $result = $entity_data_class::add(array(
                                    'UF_NAME'         => $sProp['#']['Значение'][0]['#'],
                                    'UF_XML_ID'       => $sProp['#']['ИД'][0]['#'].'-'.$sProp['#']['Значение'][0]['#'],
                                    'UF_ACTIVE'       => '1',
                                    'UF_SORT'         => 100,
                                ));
                                //debug('create: '.$sProp['#']['Значение'][0]['#']);
                            }
                            $arOfferProps[$seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $sProp['#']['ИД'][0]['#'].'-'.$sProp['#']['Значение'][0]['#'];
                        }
                    } else {
                        $arOfferProps[$seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE']] = $sProp['#']['Значение'][0]['#'];
                    }
                }

                $arOfferFields = array(
                    'NAME' => $arOfferProps['SERIES_FULL_NAME'] ? $arOfferProps['SERIES_FULL_NAME'] : $seria['#']['ИД'][0]['#'],
                    'IBLOCK_ID' => 6,
                    'ACTIVE' => 'Y',
                    'PROPERTY_VALUES' => $arOfferProps
                );

                $offerId = existProductWithProp('SERIES_ID_PROPERTY',$arOfferProps['SERIES_ID_PROPERTY'],6);
                if($offerId){
                    if($arOfferProps['SERIES_COUNT'] == 0){
                        $obElement->Delete($offerId);
                        debug("Удаление торгового предложения \"{$offerId}\" в каталог товаров");
                        continue;
                    } else {
                        $obElement->Update($offerId,$arOfferFields);//Обновление торгового предложения
                    }
                    //debug("Обновление торгового предложения \"{$offerId}\" в каталог товаров");
                    $catalogProductAddResult =	CCatalogProduct::Update($offerId,array(
                        'QUANTITY' => $arOfferProps['SERIES_COUNT'],
                        'WEIGHT' => $arOfferProps['SERIES_WEIGHT'],
                        'WIDTH' => $arOfferProps['SERIES_WIDTH'],
                        'LENGTH' => $arOfferProps['SERIES_LENGTH'],
                        'HEIGHT' => $arOfferProps['SERIES_HEIGHT'],
                    ));
                } else {
                    if($arOfferProps['SERIES_COUNT'] == 0) continue;
                    $offerId = $obElement->Add($arOfferFields);//Добавление торгового предложения
                    //debug("Добавление торгового предложения \"{$offerId}\" в каталог товаров");
                    $catalogProductAddResult =	CCatalogProduct::Add(array(
                        'ID' => $offerId,
                        'QUANTITY' => $arOfferProps['SERIES_COUNT'],
                        'WEIGHT' => $arOfferProps['SERIES_WEIGHT'],
                        'WIDTH' => $arOfferProps['SERIES_WIDTH'],
                        'LENGTH' => $arOfferProps['SERIES_LENGTH'],
                        'HEIGHT' => $arOfferProps['SERIES_HEIGHT'],
                    ));
                }
                if(!$offerId) continue;
                if ($catalogProductAddResult && !CPrice::SetBasePrice($offerId, $arOfferProps['SERIES_PRICE_ROZ'], "RUB"))
                    throw new Exception("Ошибка установки цены торгового предложения \"{$offerId}\"");
                foreach (explode(',',$PROP['AVAILABLE_SHOP_ROZ']) as $storeNAME){
                    $rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $offerId, 'STORE_ID' => $storeNAME2ID[$storeNAME]));
                    $arFields = Array(
                        "PRODUCT_ID" => $offerId,
                        "STORE_ID" => $storeNAME2ID[$storeNAME],
                        "AMOUNT" => $arOfferProps['SERIES_COUNT'],
                    );
                    $existOfferStore = false;
                    while($ar_fields = $rs->GetNext())
                    {
                        $existOfferStore = true;
                        CCatalogStoreProduct::Update($ar_fields['ID'], $arFields);
                        continue;
                    }
                    if(!$existOfferStore) CCatalogStoreProduct::Add($arFields);
                }
            }
        }
        else
        {
            AddMessage2Log("Product without series ID: ".$PRODUCT_ID);
            $priceFields = [
                'PRODUCT_ID' => $PRODUCT_ID,
                'CATALOG_GROUP_ID' => 1,//ID_типа_цены - base_cost
                'PRICE' => $PROP['PRODUCT_PRICE'],
                'CURRENCY' => 'RUB'
            ];

            $res = CPrice::GetList(
                array(),
                array(
                    "PRODUCT_ID" => $PRODUCT_ID,
                    "CATALOG_GROUP_ID" => 1
                )
            );

            if ($arr = $res->Fetch())
            {
                $priceId = CPrice::Update($arr["ID"], $priceFields);
            }
            else
            {
                $priceId = CPrice::Add($priceFields);
            }
            if (!$priceId)
            {
                if ($ex = $APPLICATION->GetException())
                    echo 'Ошибка создания цены: '.$ex->GetString();
                else
                    echo 'Неизвестная ошибка при создании цены';
                unset($ex);
            }
        }
        $iii++;
    }
    ?>
    <br>
    <br>
    <br>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
