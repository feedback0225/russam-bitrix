<?
if(!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/xml.php');
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
CModule::IncludeModule('catalog');

writeToLogs('Начало импорта "Catalog_15072022142820.XML"','import','/logs/import/');
$xml = new CDataXML();
$xml->LoadString(file_get_contents('https://market.russam.ru/custom_import/from_1c/Catalog_15072022142820.XML'));
writeToLogs('Файл импорта прочтён "Catalog_15072022142820.XML"','import','/logs/import/');

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

$executeCount = 0;
$e = '';
$arData = $xml->GetArray();
foreach ($arData['КоммерческаяИнформация']['#']['Классификатор'][0]['#']['Свойства'][0]['#']['Свойство'] as $kk=>$property) {
    if ($property['#']['ТипЗначений'][0]['#'] == 'Справочник') {
        $sort = 100;
        foreach ($property['#']['ВариантыЗначений'][0]['#']['Справочник'] as $spravVal) {
            $entity_data_class = GetEntityDataClass($hlbPropArray[$property['#']['ИД'][0]['#']]['HLBT_ID']);
            $rsData = $entity_data_class::getList(array(
                'select' => array('UF_NAME'),
                'order' => array('UF_NAME' => 'ASC'),
                'limit' => '1',
                'filter' => array('UF_NAME' => $spravVal['#']['Значение'][0]['#'])
            ));
            $exist = false;
            while ($el = $rsData->fetch()) {
                $exist = true;
            }
            if (!$exist) {
                $result = $entity_data_class::add(array(
                    'UF_NAME' => $spravVal['#']['Значение'][0]['#'],
                    'UF_XML_ID' => $spravVal['#']['ИДЗначения'][0]['#'],
                    'UF_ACTIVE' => '1',
                    'UF_SORT' => 100,
                ));
            }
        }
        unset($arData['КоммерческаяИнформация']['#']['Классификатор'][0]['#']['Свойства'][0]['#']['Свойство'][$kk]);
    } else {
        unset($arData['КоммерческаяИнформация']['#']['Классификатор'][0]['#']['Свойства'][0]['#']['Свойство'][$kk]);
        continue;
    }
}
$iii = 0;
foreach ($arData['КоммерческаяИнформация']['#']['Каталог'][0]['#']['Номенклатуры'][0]['#']['Номенклатура'] as $kkk=>$catalogITEM) {
    $curProductId = existProductWithProp('MAIN_PRODUCT_ID', $catalogITEM['#']['ИД'][0]['#'], 5);
    $el = new CIBlockElement;
    $PROP = array();
    foreach ($catalogITEM['#']['ЗначенияCвойств'][0]['#']['ЗначениеСвойства'] as $produtProp) {
        if ($productPropArray[$produtProp['#']['ИД'][0]['#']]['TYPE'] == 'HLB') {
            $PROP[$productPropArray[$produtProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $produtProp['#']['Значение'][0]['#'];
        } else {
            $PROP[$productPropArray[$produtProp['#']['ИД'][0]['#']]['CODE']] = $produtProp['#']['Значение'][0]['#'];
        }
    }
    $PROP['MAIN_PRODUCT_ID'] = $catalogITEM['#']['ИД'][0]['#'];
    $arLoadProductArray = array(
        "MODIFIED_BY" => 1,
        "IBLOCK_ID" => 5,
        "PROPERTY_VALUES" => $PROP,
        "NAME" => $catalogITEM['#']['ИД'][0]['#'],
        "CODE" => Cutil::translit($catalogITEM['#']['ИД'][0]['#'], "ru", array("replace_space" => "-", "replace_other" => "-")),
        "ACTIVE" => "Y",            // активен
    );
    if ($curProductId) {
        $PRODUCT_ID = $curProductId;
    } else {
        $arLoadProductArray['ACTIVE'] = 'N';
        $PRODUCT_ID = $el->Add($arLoadProductArray);
        writeToLogs('Попытка создать товар "Catalog_15072022142820.XML" ID => ' . $PRODUCT_ID,'import','/logs/import/');
        if (!$PRODUCT_ID) {
            writeToLogs('Ошибка создание товара "Catalog_15072022142820.XML" ERROR => ' . $el->LAST_ERROR,'import','/logs/import/');
            continue;
        }
    }
    if ($catalogITEM['#']['Серии'][0]['#']['Серия']) {
        writeToLogs('Обработка товара ТП "Catalog_15072022142820.XML" ID => ' . $PRODUCT_ID,'import','/logs/import/');
        foreach ($catalogITEM['#']['Серии'][0]['#']['Серия'] as $seria) {
            $obElement = new CIBlockElement();
            $arOfferProps = [];
            // свойства торгвоого предложения
            $arOfferProps[31] = $PRODUCT_ID;
            foreach ($seria['#']['ЗначениеСвойств'][0]['#']['ЗначениеСвойства'] as $sProp) {
                if ($seriesPropArray[$sProp['#']['ИД'][0]['#']]['TYPE'] == 'HLB') {
                    if (!$sProp['#']['Значение'][0]['#']) continue;
                    $entity_data_class = GetEntityDataClass($seriesPropArray[$sProp['#']['ИД'][0]['#']]['HLBT_ID']);
                    if ($seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE'] == 'SERIES_RING_SIZE') {
                        $rsData = $entity_data_class::getList(array(
                            'select' => array('UF_NAME'),
                            'order' => array('UF_NAME' => 'ASC'),
                            'limit' => '1',
                            'filter' => array('UF_NAME' => str_replace(',0', '', str_replace('.0', '', $sProp['#']['Значение'][0]['#'])))
                        ));
                        $exist = false;
                        while ($el = $rsData->fetch()) {
                            //debug('exists: '.$sProp['#']['Значение'][0]['#']);
                            $exist = true;
                        }
                        if (!$exist) {
                            $result = $entity_data_class::add(array(
                                'UF_NAME' => str_replace(',0', '', str_replace('.0', '', $sProp['#']['Значение'][0]['#'])),
                                'UF_XML_ID' => $sProp['#']['ИД'][0]['#'] . '-' . str_replace(',0', '', str_replace('.0', '', $sProp['#']['Значение'][0]['#'])),
                                'UF_ACTIVE' => '1',
                                'UF_SORT' => 100,
                            ));
                        }
                        $arOfferProps[$seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $sProp['#']['ИД'][0]['#'] . '-' . str_replace(',0', '', str_replace('.0', '', $sProp['#']['Значение'][0]['#']));
                    } else {
                        $rsData = $entity_data_class::getList(array(
                            'select' => array('UF_NAME'),
                            'order' => array('UF_NAME' => 'ASC'),
                            'limit' => '1',
                            'filter' => array('UF_NAME' => $sProp['#']['Значение'][0]['#'])
                        ));
                        $exist = false;
                        while ($el = $rsData->fetch()) {
                            //debug('exists: '.$sProp['#']['Значение'][0]['#']);
                            $exist = true;
                        }
                        if (!$exist) {
                            $result = $entity_data_class::add(array(
                                'UF_NAME' => $sProp['#']['Значение'][0]['#'],
                                'UF_XML_ID' => $sProp['#']['ИД'][0]['#'] . '-' . $sProp['#']['Значение'][0]['#'],
                                'UF_ACTIVE' => '1',
                                'UF_SORT' => 100,
                            ));
                            //debug('create: '.$sProp['#']['Значение'][0]['#']);
                        }
                        $arOfferProps[$seriesPropArray[$sProp['#']['ИД'][0]['#']]['CODE']]['VALUE'] = $sProp['#']['ИД'][0]['#'] . '-' . $sProp['#']['Значение'][0]['#'];
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

            $offerId = existProductWithProp('SERIES_NAME', $arOfferProps['SERIES_NAME'], 6);
            if ($offerId) {
                if ($arOfferProps['SERIES_COUNT'] == 0 || $seriesPropArray['SERIES_SHOW'] == 1) {
                    $el111 = new CIBlockElement;
                    $arLoadProductArray111 = array("ACTIVE" => "N");
                    $res111 = $el111->Update($offerId, $arLoadProductArray111);
                    writeToLogs('Деактивация товара (откл. из 1с) "Catalog_15072022142820.XML" OfferID => ' . $offerId,'import','/logs/import/');
                    continue;
                } else {
                    $el111 = new CIBlockElement;
                    $arLoadProductArray111 = array("ACTIVE" => "Y");
                    $res111 = $el111->Update($offerId, $arLoadProductArray111);
                    //Обновление торгового предложения
                    $obElement->Update($offerId, $arOfferFields);
                    writeToLogs('Обновление торгового предложения (серии) "Catalog_15072022142820.XML" OfferID => ' . $offerId,'import','/logs/import/');
                }

                $catalogProductAddResult = CCatalogProduct::Update($offerId, array(
                    'QUANTITY' => $arOfferProps['SERIES_COUNT'],
                    'WEIGHT' => $arOfferProps['SERIES_WEIGHT'],
                    'WIDTH' => $arOfferProps['SERIES_WIDTH'],
                    'LENGTH' => $arOfferProps['SERIES_LENGTH'],
                    'HEIGHT' => $arOfferProps['SERIES_HEIGHT'],
                ));
            } else {
                //Добавление торгового предложения
                $offerId = $obElement->Add($arOfferFields);
                writeToLogs('Добавление торгового предложения (серии) "Catalog_15072022142820.XML" OfferID => ' . $offerId,'import','/logs/import/');

                if ($arOfferProps['SERIES_COUNT'] == 0 || $seriesPropArray['SERIES_SHOW'] == 1) {
                    $el111 = new CIBlockElement;
                    $arLoadProductArray111['ACTIVE'] = 'N';
                    $res111 = $el111->Update($offerId, $arLoadProductArray111);
                    writeToLogs('Деактивация товара (откл. из 1с) "Catalog_15072022142820.XML" OfferID => ' . $offerId,'import','/logs/import/');
                    continue;
                }
                $catalogProductAddResult = CCatalogProduct::Add(array(
                    'ID' => $offerId,
                    'QUANTITY' => $arOfferProps['SERIES_COUNT'],
                    'WEIGHT' => $arOfferProps['SERIES_WEIGHT'],
                    'WIDTH' => $arOfferProps['SERIES_WIDTH'],
                    'LENGTH' => $arOfferProps['SERIES_LENGTH'],
                    'HEIGHT' => $arOfferProps['SERIES_HEIGHT'],
                ));
            }
            if (!$offerId) continue;


            if ($catalogProductAddResult && !CPrice::SetBasePrice($offerId, $arOfferProps['SERIES_PRICE_ROZ'], "RUB"))
                throw new Exception("Ошибка установки цены торгового предложения \"{$offerId}\"");

            writeToLogs('Торговому предложению (серии) установлен цена = '.$arOfferProps['SERIES_PRICE_ROZ'].'RUB "Catalog_15072022142820.XML" OfferID => ' . $offerId,'import','/logs/import/');

            $storeNAME = $arOfferProps['SERIES_AVAILABLE_ROZ_SHOP'];
            $rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID' => $offerId)); //, 'STORE_ID' => $storeNAME2ID[$storeNAME]
            $arFields = array(
                "PRODUCT_ID" => $offerId,
                "STORE_ID" => $storeNAME2ID[$storeNAME],
                "AMOUNT" => $arOfferProps['SERIES_COUNT'],
            );
            $foundNecessary = false;
            while ($ar_fields = $rs->GetNext()) {
                if ($ar_fields['STORE_ID'] != $storeNAME2ID[$storeNAME]) {
                    CCatalogStoreProduct::Delete($ar_fields['ID']);
                } else {
                    $foundNecessary = true;
                    CCatalogStoreProduct::Update($ar_fields['ID'], $arFields);
                }
            }
            if (!$foundNecessary) {
                CCatalogStoreProduct::Add($arFields);
            }
        }
        if($PRODUCT_ID){
            //--------------------------------------------------------
            //Обаботка товара после установки/обновления серии (ВАЖНО)
            //Обаботка товара после установки/обновления серии (ВАЖНО)
            //Обаботка товара после установки/обновления серии (ВАЖНО)
            //Обаботка товара после установки/обновления серии (ВАЖНО)
            $start = microtime(true);

            $productType = CCatalogProduct::GetByID($PRODUCT_ID)['TYPE'];
            $productAvailable = CCatalogProduct::GetByID($PRODUCT_ID)['AVAILABLE'];

            $curProductRes = CIBlockElement::GetByID($PRODUCT_ID);
            if($curProduct = $curProductRes->GetNextElement()){
                $curProductFields = $curProduct->GetFields();
                $curProductProperties = $curProduct->GetProperties();
            }

            //ВАЖНО
            $finalFields = [];
            $good = [];
            $bad = [];
            $actions = [];
            //ВАЖНО

            $controlElementRes = CIBlockElement::GetList(
                [],
                ['ID' => 165526],
                false,
                false,
                ['*']
            );

            if(!empty($curProductFields) && !empty($curProductProperties) && $controlElement = $controlElementRes->GetNextElement()){
                $controlElementProps = $controlElement->GetProperties();
                $good = $controlElementProps['GOOD']['VALUE_ENUM'];
                $bad = $controlElementProps['BAD']['VALUE_ENUM'];
                $actions = $controlElementProps['ACTIONS']['VALUE_ENUM'];
            } else {
                continue;
            }

            //ДЕЙТСВИЯ ПРОСТО ДЕЙСТВИЯ
            $mainProductID = $curProductProperties['MAIN_PRODUCT_ID']['VALUE'];
            $imageCount = 0;
            $existImage = false;
            for($imageCounter = 0;$imageCounter < 30;$imageCounter++){
                $tempProductID = $mainProductID.(($imageCounter>=1) ? '_'.$imageCounter:'');
                global $checkDirectoryForImg;
                $img = checkExistFileAndGetExtension($_SERVER["DOCUMENT_ROOT"],$checkDirectoryForImg,$tempProductID);
                if($img['exists']){
                    $existImage = true;
                    break;
                }
            }

            if($curProductProperties['SHOW_WITHOUT_OFFERS']['VALUE'] == 24){
                $SHOW_WITHOUT_OFFERS = 'Y';
            } else {
                $SHOW_WITHOUT_OFFERS = 'N';
            }
            //ДЕЙТСВИЯ ПРОСТО ДЕЙСТВИЯ

            writeToLogs('Изменение товара "' . $curProductFields['NAME'] . '" => ' . $curProductFields['ID'],'ControlProduct','/logs/ControlProduct/');
            foreach ($good as $checkGood){
                if($checkGood == 'Товар доступен'){
                    if($productAvailable == 'Y'){
                        $finalFields['ACTIVE'] = 'Y';
                        writeToLogs('Товар доступен','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkGood == 'Есть картинка'){
                    if($existImage){
                        $finalFields['ACTIVE'] = 'Y';
                        writeToLogs('У товара есть картинка','ControlProduct','/logs/ControlProduct/');
                    }
                }
            }
            foreach ($bad as $checkBad){
                if($checkBad == 'Товар недоступен'){
                    if($productAvailable == 'N' && $SHOW_WITHOUT_OFFERS == 'N'){
                        $finalFields['ACTIVE'] = 'N';
                        writeToLogs('Товар недоступен','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkBad == 'Нету картинки') {
                    if(!$existImage){
                        $finalFields['ACTIVE'] = 'N';
                        writeToLogs('У товара нету картинки','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkBad == 'Проверка поля "Отображать без серий"'){
                    if($SHOW_WITHOUT_OFFERS == 'N'){
                        if($productType != 3){
                            $finalFields['ACTIVE'] = 'N';
                            writeToLogs('Обычный товар, нельзя показывать без серий!','ControlProduct','/logs/ControlProduct/');
                        }
                        else if($productType != 1 && !IsExistOffersMy($curProductFields['ID'],6)){
                            $finalFields['ACTIVE'] = 'N';
                            writeToLogs('Товар с ТП, нельзя показывать без серий!','ControlProduct','/logs/ControlProduct/');
                        }
                    }
                }
            }
            if($finalFields['ACTIVE'] == 'N' && $curProductFields['ACTIVE'] == 'N') {
                $afterImportElementProccess = new CIBlockElement;
                $afterImportElementProccess->Update($curProductFields['ID'],$finalFields);
                writeToLogs('Товар неактивен, дальнейшее действия отменены!!!','ControlProduct','/logs/ControlProduct/');
                writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
            } else {
                foreach ($actions as $checkAction){
                    if($checkAction == 'Установка коллекции'){
                        if($curProductProperties['PRODUCT_COLLECTION']['VALUE'] > 0){
                            $finalProperties['COLLECTION_SEO'] = ' из коллекции '.CIBlockSection::GetByID($curProductProperties['PRODUCT_COLLECTION']['VALUE'])->GetNext()['NAME'];
                            writeToLogs('Установка коллекции "' . CIBlockSection::GetByID($curProductProperties['PRODUCT_COLLECTION']['VALUE'])->GetNext()['NAME'] . '"','ControlProduct','/logs/ControlProduct/');
                        } else {
                            $finalProperties['COLLECTION_SEO'] = '';
                        }
                    }
                    else if($checkAction == 'Установка цвета'){
                        if($productType != 1){
                            $productOffersRes = CIBlockElement::GetList(
                                array(),
                                array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $curProductFields['ID'], 'ACTIVE' => 'Y'),
                                false,
                                false,
                                ['IBLOCK_ID','ID','NAME','PROPERTY_CML2_LINK','PROPERTY_SERIES_INSERT_ERRORS','PROPERTY_SERIES_INSERT_COLOR']
                            );

                            $continueInsert = true;
                            $insertedToProduct = false;
                            while($productOffer = $productOffersRes->GetNextElement()){
                                $productOfferFields = $productOffer->GetFields();
                                $productOfferProperties = $productOffer->GetProperties();
                                foreach ($productOfferProperties['SERIES_INSERT_ERRORS']['VALUE'] as $insertError){
                                    if($insertError != 'Good!') {
                                        $continueInsert = false;
                                        break;
                                    }
                                }
                                if($continueInsert) {
                                    $insertedToProduct = true;
                                    writeToLogs('Цвета вставок установленны!','ControlProduct','/logs/ControlProduct/');

                                    $finalProperties['VSTAVKA_COLOR'] = [];
                                    foreach ($productOfferProperties['SERIES_INSERT_COLOR']['VALUE'] as $key=>$insertMaterial){
                                        $finalProperties['VSTAVKA_COLOR'][$key] = $insertMaterial;
                                    }
                                }
                                if($insertedToProduct) break;
                            }
                        }
                    }
                    else if($checkAction == 'Установка вставок'){
                        if($productType != 1){
                            $productOffersRes = CIBlockElement::GetList(
                                array(),
                                array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $curProductFields['ID'], 'ACTIVE' => 'Y'),
                                false,
                                false,
                                ['IBLOCK_ID','ID','NAME','PROPERTY_CML2_LINK','PROPERTY_SERIES_INSERT_ERRORS','PROPERTY_SERIES_INSERT_MATERIAL']
                            );

                            $continueInsert = true;
                            $insertedToProduct = false;
                            while($productOffer = $productOffersRes->GetNextElement()){
                                $productOfferFields = $productOffer->GetFields();
                                $productOfferProperties = $productOffer->GetProperties();
                                foreach ($productOfferProperties['SERIES_INSERT_ERRORS']['VALUE'] as $insertError){
                                    if($insertError != 'Good!') {
                                        $continueInsert = false;
                                        break;
                                    }
                                }
                                if($continueInsert) {
                                    $insertedToProduct = true;
                                    writeToLogs('Вставка установлена!','ControlProduct','/logs/ControlProduct/');

                                    $finalProperties['VSTAVKA_FILTER'] = [];
                                    foreach ($productOfferProperties['SERIES_INSERT_MATERIAL']['VALUE'] as $key=>$insertMaterial){
                                        $finalProperties['VSTAVKA_FILTER'][$key] = $insertMaterial;
                                    }

                                    $finalProperties['VSTAVKA'] = [];
                                    foreach ($productOfferProperties['SERIES_INSERT_RESULT']['VALUE'] as $key=>$insertResult){
                                        $finalProperties['VSTAVKA'][$key] = $insertResult;
                                    }
                                }
                                if($insertedToProduct) break;
                            }
                        }
                    }
                    else if($checkAction == 'Установка детальной картинки'){

                        $detailImageID = 0;
                        $detailImageRes = CFile::GetList(array("FILE_SIZE" => "desc"), array("ORIGINAL_NAME" => $img['name']));
                        while ($detailImage = $detailImageRes->GetNext()) {
                            $detailImageID = $detailImage['ID'];
                        }
                        if(!$detailImageID) {
                            $finalFields['DETAIL_PICTURE'] = CFile::MakeFileArray($img['position']);
                            writeToLogs('Детальная картинка установлена!','ControlProduct','/logs/ControlProduct/');
                        }
                    }
                    else if($checkAction == 'Создать название товара'){
                        if($curProductProperties['UPDATE_NAME']['VALUE'] != 26) {
                            $productOffersRes = CIBlockElement::GetList(
                                array(),
                                array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $curProductFields['ID'], 'ACTIVE' => 'Y'),
                                false,
                                false,
                                ['IBLOCK_ID','ID','NAME','PROPERTY_CML2_LINK','PROPERTY_SERIES_INSERT_ERRORS','PROPERTY_SERIES_INSERT_MATERIAL']
                            );

                            $continueInsert = true;
                            $insertedToProduct = false;
                            while($productOffer = $productOffersRes->GetNextElement()){
                                $productOfferFields = $productOffer->GetFields();
                                $productOfferProperties = $productOffer->GetProperties();
                                foreach ($productOfferProperties['SERIES_INSERT_ERRORS']['VALUE'] as $insertError){
                                    if($insertError != 'Good!') {
                                        $continueInsert = false;
                                        break;
                                    }
                                }
                                if($continueInsert) {
                                    $insertedToProduct = true;

                                    $productInsertsData = [];
                                    foreach ($arFields['PROPERTY_VALUES']['86'] as $insertCount){
                                        $insertNameAndCount = explode(' - ',explode(',',$insertCount)[0]);
                                        if($productInsertsData[mb_strtolower($insertNameAndCount[0])]){
                                            if($insertNameAndCount[1] > $productInsertsData[mb_strtolower($insertNameAndCount[0])]) $productInsertsData[mb_strtolower($insertNameAndCount[0])] = $insertNameAndCount[1];
                                        } else {
                                            $productInsertsData[mb_strtolower($insertNameAndCount[0])] = $insertNameAndCount[1];
                                        }
                                    }

                                    $productItemType = getHLBTByXML($curProductProperties['ITEM_TYPE']['VALUE'],4);
                                    if($productItemType){
                                        $newProductName = $productItemType;
                                        $productMaterial = getHLBTByXML($curProductProperties['SAMPLE_MATERIAL_NEW']['VALUE'],19);
                                        if($productMaterial) {
                                            $productMaterial = preg_replace('/\d/','',mb_strtolower($productMaterial));
                                            $productMaterial = preg_replace('/  +/', ' ', $productMaterial);
                                            $productMaterial = str_replace('пробы','',$productMaterial);

                                            $eachWord = explode(' ',$productMaterial);
                                            foreach ($eachWord as &$word){
                                                if($word == 'белое'){
                                                    $word = 'белого';
                                                } elseif($word == 'желтое') {
                                                    $word = 'желтого';
                                                } elseif($word == 'красное'){
                                                    $word = 'красного';
                                                } elseif($word == 'нержавеющая'){
                                                    $word = 'нержавеющей';
                                                } elseif($word == 'серебро'){
                                                    $word = 'серебра';
                                                } elseif($word == 'золото'){
                                                    $word = 'золота';
                                                } elseif($word == 'серебро'){
                                                    $word = 'серебра';
                                                } elseif($word == 'сталь'){
                                                    $word = 'стали';
                                                } elseif($word == 'латунь'){
                                                    $word = 'латуни';
                                                } elseif($word == 'платина'){
                                                    $word = 'платины';
                                                }  elseif($word == 'медь'){
                                                    $word = 'меди';
                                                } elseif($word == '/латунь'){
                                                    $word = 'и латуни';
                                                }  elseif($word == '/медь'){
                                                    $word = 'и меди';
                                                }
                                            }
                                            $productMaterial = ' из ' . implode(' ',$eachWord);
                                            $newProductName .= $productMaterial;
                                        }

                                        $productInserts = [];
                                        foreach ($curProductProperties['VSTAVKA_FILTER']['VALUE'] as $insert){
                                            if(!in_array(mb_strtolower(getHLBTByXML($insert,18)),$productInserts)){
                                                $productInserts[] = mb_strtolower(getHLBTByXML($insert,18));
                                            }
                                        }
                                        $insertString = '';
                                        foreach ($productInserts as $vK=>&$insert){
                                            if($vK == 0){
                                                $insertString .= ' с ';
                                            }
                                            elseif($vK == count($productInserts) - 1){
                                                $insertString .= ' и ';
                                            }
                                            else {
                                                $insertString .= ', ';
                                            }
                                            if($insert == 'агат'){
                                                $insert = $productInsertsData['агат'] > 1 ? 'агатами' : 'агатом';
                                            } elseif($insert == 'аквамарин'){
                                                $insert = $productInsertsData['аквамарин'] > 1 ? 'аквамаринами' : 'аквамарином';
                                            } elseif($insert == 'александрит'){
                                                $insert = $productInsertsData['александрит'] > 1 ? 'александритами' : 'александритом';
                                            } elseif($insert == 'альмандин'){
                                                $insert = $productInsertsData['альмандин'] > 1 ? 'альмандинами' : 'альмандином';
                                            } elseif($insert == 'аметист'){
                                                $insert = $productInsertsData['аметист'] > 1 ? 'аметистами' : 'аметистом';
                                            } elseif($insert == 'аметрин'){
                                                $insert = $productInsertsData['аметрин'] > 1 ? 'аметринами' : 'аметрином';
                                            } elseif($insert == 'аурит'){
                                                $insert = $productInsertsData['аурит'] > 1 ? 'ауритами' : 'ауритом';
                                            } elseif($insert == 'белор. кварцит'){
                                                $insert = 'белор. кварцитом';
                                            } elseif($insert == 'бирюза'){
                                                $insert = $productInsertsData['бирюза'] > 1 ? 'бирюзой' : 'бирюзой';
                                            } elseif($insert == 'бриллиант'){
                                                $insert = $productInsertsData['бриллиант'] > 1 ? 'бриллиантами' : 'бриллиантом';
                                            } elseif($insert == 'горный хрусталь'){
                                                $insert = $productInsertsData['горный хрусталь'] > 1 ? 'горным хрусталем' : 'горным хрусталем';
                                            } elseif($insert == 'гранат'){
                                                $insert = $productInsertsData['гранат'] > 1 ? 'гранатами' : 'гранатом';
                                            } elseif($insert == 'деколь'){
                                                $insert = $productInsertsData['деколь'] > 1 ? 'деколью' : 'деколью';
                                            } elseif($insert == 'демантоид'){
                                                $insert = $productInsertsData['демантоид'] > 1 ? 'демантоидами' : 'демантоидом';
                                            } elseif($insert == 'дерево'){
                                                $insert = $productInsertsData['дерево'] > 1 ? 'деревом' : 'деревом';
                                            } elseif($insert == 'дерево/палисандр/'){
                                                $insert = 'деревом/палисандром';
                                            } elseif($insert == 'жемчуг'){
                                                $insert = $productInsertsData['жемчуг'] > 1 ? 'жемчугом' : 'жемчугом';
                                            } elseif($insert == 'живописное изображение'){
                                                $insert = 'живописным изображением';
                                            } elseif($insert == 'змеевик'){
                                                $insert = $productInsertsData['змеевик'] > 1 ? 'змеевиками' : 'змеевиком';
                                            } elseif($insert == 'змеевик (серпентин)'){
                                                $insert = $productInsertsData['змеевик (серпентин)'] > 1 ? 'змеевиками (серпентин)' : 'змеевиком (серпентин)';
                                            } elseif($insert == 'изумруд'){
                                                $insert = $productInsertsData['изумруд'] > 1 ? 'изумрудами' : 'изумрудом';
                                            } elseif($insert == 'камнерезная пластика'){
                                                $insert = 'камнерезной пластикой';
                                            } elseif($insert == 'кахолонг'){
                                                $insert = $productInsertsData['кахолонг'] > 1 ? 'кахолонгами' : 'кахолонгом';
                                            } elseif($insert == 'кварц'){
                                                $insert = $productInsertsData['кварц'] > 1 ? 'кварцами' : 'кварцем';
                                            } elseif($insert == 'кварцит'){
                                                $insert = $productInsertsData['кварцит'] > 1 ? 'кварцитами' : 'кварцитом';
                                            } elseif($insert == 'коралл'){
                                                $insert = $productInsertsData['коралл'] > 1 ? 'кораллами' : 'кораллом';
                                            } elseif($insert == 'корунд'){
                                                $insert = $productInsertsData['корунд'] > 1 ? 'корундами' : 'корундом';
                                            } elseif($insert == 'кремень'){
                                                $insert = 'кремнем';
                                            } elseif($insert == 'лазурит'){
                                                $insert = $productInsertsData['лазурит'] > 1 ? 'лазуритами' : 'лазуритом';
                                            } elseif($insert == 'люверсы'){
                                                $insert = $productInsertsData['люверсы'] > 1 ? 'люверсами' : 'люверсом';
                                            } elseif($insert == 'малахит'){
                                                $insert = $productInsertsData['малахит'] > 1 ? 'малахитами' : 'малахитом';
                                            } elseif($insert == 'миниатюра'){
                                                $insert = $productInsertsData['миниатюра'] > 1 ? 'миниатюрами' : 'миниатюрой';
                                            } elseif($insert == 'морганит'){
                                                $insert = $productInsertsData['морганит'] > 1 ? 'морганитами' : 'морганитом';
                                            } elseif($insert == 'морион'){
                                                $insert = $productInsertsData['морион'] > 1 ? 'морионами' : 'морионом';
                                            } elseif($insert == 'нефрит'){
                                                $insert = $productInsertsData['нефрит'] > 1 ? 'нефритами' : 'нефритом';
                                            } elseif($insert == 'нуарит'){
                                                $insert = $productInsertsData['нуарит'] > 1 ? 'нуаритами' : 'нуаритом';
                                            } elseif($insert == 'обсидиан'){
                                                $insert = $productInsertsData['обсидиан'] > 1 ? 'обсидианами' : 'обсидианом';
                                            } elseif($insert == 'окаменелое дерево'){
                                                $insert = 'окаменелом деревом';
                                            } elseif($insert == 'оникс'){
                                                $insert = $productInsertsData['оникс'] > 1 ? 'ониксами' : 'ониксом';
                                            } elseif($insert == 'опал'){
                                                $insert = $productInsertsData['опал'] > 1 ? 'опалами' : 'опалом';
                                            } elseif($insert == 'опал синтетический'){
                                                $insert = $productInsertsData['опал синтетический'] > 1 ? 'опалами синтетическими' : 'опалом синтетическим';
                                            } elseif($insert == 'офиокальцит'){
                                                $insert = $productInsertsData['офиокальцит'] > 1 ? 'офиокальцитами' : 'офиокальцитом';
                                            } elseif($insert == 'перламутр'){
                                                $insert = 'перламутром';
                                            } elseif($insert == 'печать на холсте'){
                                                $insert = 'печатью на холсте';
                                            } elseif($insert == 'пластик'){
                                                $insert = 'пластиком';
                                            } elseif($insert == 'празиолит'){
                                                $insert = $productInsertsData['празиолит'] > 1 ? 'празиолитами' : 'празиолитом';
                                            } elseif($insert == 'пренит'){
                                                $insert = $productInsertsData['пренит'] > 1 ? 'пренитами' : 'пренитом';
                                            } elseif($insert == 'родолит'){
                                                $insert = $productInsertsData['родолит'] > 1 ? 'родолитами' : 'родолит';
                                            } elseif($insert == 'родонит'){
                                                $insert = $productInsertsData['родонит'] > 1 ? 'родонитами' : 'родонит';
                                            } elseif($insert == 'рубин'){
                                                $insert = $productInsertsData['рубин'] > 1 ? 'рубинами' : 'рубином';
                                            } elseif($insert == 'сапфир'){
                                                $insert = $productInsertsData['сапфир'] > 1 ? 'сапфирами' : 'сапфиром';
                                            } elseif($insert == 'сердолик'){
                                                $insert = $productInsertsData['сердолик'] > 1 ? 'сердоликами' : 'сердоликом';
                                            } elseif($insert == 'ситалл'){
                                                $insert = $productInsertsData['ситалл'] > 1 ? 'ситаллами' : 'ситаллом';
                                            } elseif($insert == 'сомбрилл'){
                                                $insert = $productInsertsData['сомбрилл'] > 1 ? 'сомбриллами' : 'сомбриллом';
                                            } elseif($insert == 'танзанит'){
                                                $insert = $productInsertsData['танзанит'] > 1 ? 'танзанитами' : 'танзанитом';
                                            } elseif($insert == 'тигровый глаз'){
                                                $insert = 'тигровым глазом';
                                            } elseif($insert == 'топаз'){
                                                $insert = $productInsertsData['топаз'] > 1 ? 'топазами' : 'топазом';
                                            } elseif($insert == 'турмалин'){
                                                $insert = $productInsertsData['турмалин'] > 1 ? 'турмалинами' : 'турмалином';
                                            } elseif($insert == 'фианит'){
                                                $insert = $productInsertsData['фианит'] > 1 ? 'фианитами' : 'фианитом';
                                            } elseif($insert == 'флорентийская мозаика'){
                                                $insert = 'флорентийской мозаикой';
                                            } elseif($insert == 'халцедон'){
                                                $insert = $productInsertsData['халцедон'] > 1 ? 'халцедонами' : 'халцедоном';
                                            } elseif($insert == 'хризолит'){
                                                $insert = $productInsertsData['хризолит'] > 1 ? 'хризолитами' : 'хризолитом';
                                            } elseif($insert == 'хризопраз'){
                                                $insert = $productInsertsData['хризопраз'] > 1 ? 'хризопразами' : 'хризопразом';
                                            } elseif($insert == 'циркон'){
                                                $insert = $productInsertsData['циркон'] > 1 ? 'цирконами' : 'цирконом';
                                            } elseif($insert == 'цитрин'){
                                                $insert = $productInsertsData['цитрин'] > 1 ? 'цитринами' : 'цитрином';
                                            } elseif($insert == 'шпинель'){
                                                $insert = $productInsertsData['шпинель'] > 1 ? 'шпинелями' : 'шпинелью';
                                            } elseif($insert == 'эмаль'){
                                                $insert = 'эмалью';
                                            } elseif($insert == 'ювелирное стекло'){
                                                $insert = 'ювелирным стеклом';
                                            } elseif($insert == 'янтарь'){
                                                $insert = 'янтарем';
                                            } elseif($insert == 'яшма'){
                                                $insert = $productInsertsData['яшма'] > 1 ? 'яшмами' : 'яшмой';
                                            } elseif($insert == 'яшма пестроцветная'){
                                                $insert = $productInsertsData['яшма пестроцветная'] > 1 ? 'яшмами пестроцветными' : 'яшмой пестроцветной';
                                            } elseif($insert == 'яшма техническая'){
                                                $insert = $productInsertsData['яшма техническая'] > 1 ? 'яшмами техническами' : 'яшмой технической';
                                            }
                                            $insertString .= $insert;
                                        }
                                        if($insertString){
                                            $newProductName .= $insertString;
                                        }
                                        $newProductName = preg_replace('/  +/', ' ', $newProductName);
                                        $finalFields['NAME'] = $newProductName;
                                        writeToLogs('Установка нового названия: "' . $newProductName.'"','ControlProduct','/logs/ControlProduct/');
                                    }
                                }
                                if($insertedToProduct) break;
                            }
                        }
                    }
                }

                //Зафиксировать изменения!!!
                $afterImportElementProccess = new CIBlockElement;
                $afterImportElementProccess->Update($curProductFields['ID'],$finalFields);
                CIBlockElement::SetPropertyValuesEx($curProductFields['ID'], $curProductFields['IBLOCK_ID'], $finalProperties);

                writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
            }
        }
    } else {
        writeToLogs('Обработка обычного товара "Catalog_15072022142820.XML" ID => ' . $PRODUCT_ID,'import','/logs/import/');
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

        if ($arr = $res->Fetch()) {
            $priceId = CPrice::Update($arr["ID"], $priceFields);
        } else {
            $priceId = CPrice::Add($priceFields);
        }
        if (!$priceId) {
            if ($ex = $APPLICATION->GetException())
                writeToLogs('Ошибка создания цены "Catalog_15072022142820.XML" ERROR => ' . $ex->GetString(),'import','/logs/import/');
            else
                writeToLogs('Неизвестная ошибка при создании цены "Catalog_15072022142820.XML" ERROR => ' . $ex->GetString(),'import','/logs/import/');
            unset($ex);
        } else {
            writeToLogs('Обычному товару установлен цена = '.$PROP['PRODUCT_PRICE'].'RUB "Catalog_15072022142820.XML" ID => ' . $PRODUCT_ID,'import','/logs/import/');
        }
    }
    $executeCount++;
    unset($arData['КоммерческаяИнформация']['#']['Каталог'][0]['#']['Номенклатуры'][0]['#']['Номенклатура'][$kkk]);
}
unset($arData);

writeToLogs('Обработанно товаров = '.$executeCount.' "Catalog_15072022142820.XML"','import','/logs/import/');

$res = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => 5,'=TYPE' => 1,"ACTIVE" => "Y","CATALOG_AVAILABLE" => "Y","CATALOG_QUANTITY" => 0),
    false,
    false
);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    CCatalogProduct::Update($arFields['ID'], ['AVAILABLE' => 'N']);
}

$res = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => 6,'PROPERTY_SERIES_SHOW' => 1,'ACTIVE' => 'Y'),
    false,
    false
);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();

    $el = new CIBlockElement;
    $arLoadProductArray = Array("ACTIVE" => "N");
    $res1 = $el->Update($arFields['ID'], $arLoadProductArray);
    writeToLogs('B2: disable "Catalog_15072022142820.XML"','import','/logs/import/');
}

$res = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => 5,'=TYPE' => 3,"ACTIVE" => "Y",'!PROPERTY_SHOW_WITHOUT_OFFERS' => 24),
    false,
    false
);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();

    if(!IsExistOffersMy($arFields['ID'],6)){
        $el = new CIBlockElement;
        $arLoadProductArray = Array("ACTIVE" => "N");
        $res1 = $el->Update($arFields['ID'], $arLoadProductArray);
        writeToLogs('disable ProductWithNoOffersNow "Catalog_15072022142820.XML"','import','/logs/import/');
    }
}

writeToLogs('Импорт закончен "Catalog_15072022142820.XML"','import','/logs/import/');
die();