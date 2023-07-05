<?
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');
CModule::IncludeModule("sale");

//AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");
//function BeforeIndexHandler($arFields){
//    if(!CModule::IncludeModule("iblock"))
//        return $arFields;
//    if($arFields["MODULE_ID"] == "iblock"){
//        $db_props = CIBlockElement::GetProperty(
//            $arFields["PARAM2"],
//            $arFields["ITEM_ID"],
//            array("sort" => "asc"),
//            Array("CODE" => "ARTICLE")); // тут перечисляем id свойств
//        while($ar_props = $db_props->Fetch()){
//            $arFields["TITLE"] .= "|".$ar_props["VALUE"];
//        }
//    }
//    return $arFields;
//}


function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {return false;}
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class;
}

function mb_ucfirst($str, $encoding='UTF-8')
{
    $str = mb_ereg_replace('^[\ ]+', '', $str);
    $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
        mb_substr($str, 1, mb_strlen($str), $encoding);
    return $str;
}
AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('ElementUpdate', 'ControlProduct'));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("ElementUpdate", "ControlProduct"));

AddEventHandler('iblock', 'OnAfterIBlockElementAdd', array('ElementUpdate', 'ParseSeries'));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("ElementUpdate", "ParseSeries"));
class ElementUpdate
{
    function ControlProduct(&$arFields)
    {
        if($arFields['IBLOCK_ID'] == 5){
            $start = microtime(true);
            if(empty($arFields['PROPERTY_VALUES']) || !$arFields['ID']) return;

			setSimilarProductsByID($arFields['ID']);
            $productType = CCatalogProduct::GetByID($arFields['ID'])['TYPE'];
            $productAvailable = CCatalogProduct::GetByID($arFields['ID'])['AVAILABLE'];


            $curProductRes = CIBlockElement::GetByID($arFields['ID']);
            if($curProduct = $curProductRes->GetNextElement()){
                $curProductFields = $curProduct->GetFields();
                $curProductProperties = $curProduct->GetProperties();
            }

            if($arFields["PROPERTY_VALUES"]["162"]){
                foreach($arFields["PROPERTY_VALUES"]["162"] as $productId){
                    CIBlockElement::SetPropertyValuesEx($productId, $arFields['IBLOCK_ID'], ["RELATED_PRODUCTS" => array_replace($arFields['PROPERTY_VALUES']["162"], [$arFields['ID']])]);
                }
            }
            //ВАЖНО
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
                return;
            }


            //ДЕЙТСВИЯ ПРОСТО ДЕЙСТВИЯ
            if($productAvailable == 'Y'){
                $arFields['PROPERTY_VALUES']['124'][array_key_first($arFields['PROPERTY_VALUES']['124'])]['VALUE'] = 27;
            } else {
                $arFields['PROPERTY_VALUES']['124'][array_key_first($arFields['PROPERTY_VALUES']['124'])]['VALUE'] = 28;
            }

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

            if($arFields['PROPERTY_VALUES']['98'][0]['VALUE'] == 24){
                $SHOW_WITHOUT_OFFERS = 'Y';
            } else {
                $SHOW_WITHOUT_OFFERS = 'N';
            }
            //ДЕЙТСВИЯ ПРОСТО ДЕЙСТВИЯ


            writeToLogs('Изменение товара "' . $arFields['NAME'] . '" => ' . $arFields['ID'],'ControlProduct','/logs/ControlProduct/');
            foreach ($good as $checkGood){
                if($checkGood == 'Товар доступен'){
                    if($productAvailable == 'Y'){
                        $arFields['ACTIVE'] = 'Y';
                        writeToLogs('Товар доступен','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkGood == 'Есть картинка'){
                    if($existImage){
                        $arFields['ACTIVE'] = 'Y';
                        writeToLogs('У товара есть картинка','ControlProduct','/logs/ControlProduct/');
                    }
                }
            }
            foreach ($bad as $checkBad){
                if($checkBad == 'Товар недоступен'){
                    if($productAvailable == 'N' && $SHOW_WITHOUT_OFFERS == 'N'){
                        $arFields['ACTIVE'] = 'N';
                        writeToLogs('Товар недоступен','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkBad == 'Нету картинки') {
                    if(!$existImage){
                        $arFields['ACTIVE'] = 'N';
                        writeToLogs('У товара нету картинки','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkBad == 'Проверка поля "Отображать без серий"'){
                    if($SHOW_WITHOUT_OFFERS == 'N'){
                        if($productType != 3){
                            $arFields['ACTIVE'] = 'N';
                            writeToLogs('Обычный товар, нельзя показывать без серий!','ControlProduct','/logs/ControlProduct/');
                        }
                        else if($productType != 1 && !IsExistOffersMy($arFields['ID'],6)){
                            $arFields['ACTIVE'] = 'N';
                            writeToLogs('Товар с ТП, нельзя показывать без серий!','ControlProduct','/logs/ControlProduct/');
                        }
                    }
                }
            }
            if($arFields['ACTIVE'] == 'N') {
                writeToLogs('Товар неактивен, дальнейшее действия отменены!!!','ControlProduct','/logs/ControlProduct/');
                writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
                return;
            }
            foreach ($actions as $checkAction){
                if($checkAction == 'Установка коллекции'){
                    if($arFields['PROPERTY_VALUES']['80'][array_key_first($arFields['PROPERTY_VALUES']['80'])]['VALUE'] > 0){
                        $arFields['PROPERTY_VALUES']['117'][array_key_first($arFields['PROPERTY_VALUES']['117'])]['VALUE'] = ' из коллекции '.CIBlockSection::GetByID($arFields['PROPERTY_VALUES']['80'][array_key_first($arFields['PROPERTY_VALUES']['80'])]['VALUE'])->GetNext()['NAME'];
                        writeToLogs('Установка коллекции "' . CIBlockSection::GetByID($arFields['PROPERTY_VALUES']['80'][array_key_first($arFields['PROPERTY_VALUES']['80'])]['VALUE'])->GetNext()['NAME'] . '"','ControlProduct','/logs/ControlProduct/');
                    } else {
                        $arFields['PROPERTY_VALUES']['117'][array_key_first($arFields['PROPERTY_VALUES']['117'])]['VALUE'] = '';
                    }
                }
                else if($checkAction == 'Установка цвета'){
                    if($productType != 1 && $arFields['PROPERTY_VALUES']['148'][array_key_first($arFields['PROPERTY_VALUES']['148'])]['VALUE'] != 45){
                        $productOffersRes = CIBlockElement::GetList(
                            array(),
                            array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $arFields['ID']),
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

                                $arFields['PROPERTY_VALUES']['101'] = [];
                                foreach ($productOfferProperties['SERIES_INSERT_COLOR']['VALUE'] as $key=>$insertMaterial){
                                    $arFields['PROPERTY_VALUES']['101'][$key] = $insertMaterial;
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
                            array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $arFields['ID'],'!PROPERTY_SERIES_INSERT_ERRORS' => false),
                            false,
                            false,
                            ['IBLOCK_ID','ID','NAME','PROPERTY_CML2_LINK','PROPERTY_SERIES_INSERT_ERRORS','PROPERTY_SERIES_INSERT_MATERIAL']
                        );

                        $insertedToProduct = false;
                        while($productOffer = $productOffersRes->GetNextElement()){
                            $continueInsert = true;
                            $productOfferFields = $productOffer->GetFields();
                            $productOfferProperties = $productOffer->GetProperties();
                            if(!$productOfferProperties['SERIES_INSERT_ERRORS']['VALUE']) {$continueInsert = false;continue;}
                            foreach ($productOfferProperties['SERIES_INSERT_ERRORS']['VALUE'] as $insertError){
                                if($insertError != 'Good!') {
                                    $continueInsert = false;
                                    break;
                                }
                            }
                            if($continueInsert) {
                                $insertedToProduct = true;
                                writeToLogs('Вставка установлена!','ControlProduct','/logs/ControlProduct/');

                                $arFields['PROPERTY_VALUES']['102'] = [];
                                foreach ($productOfferProperties['SERIES_INSERT_MATERIAL']['VALUE'] as $key=>$insertMaterial){
                                    $arFields['PROPERTY_VALUES']['102'][$key] = $insertMaterial;
                                }

                                $arFields['PROPERTY_VALUES']['86'] = [];
                                foreach ($productOfferProperties['SERIES_INSERT_RESULT']['VALUE'] as $key=>$insertResult){
                                    $arFields['PROPERTY_VALUES']['86'][$key] = $insertResult;
                                }
                            }
                            if($insertedToProduct) break;
                        }
                        if(!$insertedToProduct){
                            $arFields['PROPERTY_VALUES']['86'] = [];
                            $arFields['PROPERTY_VALUES']['86'][0] = '';
                            $arFields['PROPERTY_VALUES']['102'] = [];
                            $arFields['PROPERTY_VALUES']['102'][0] = 'no-insert';
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
                        $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($img['position']);
                        writeToLogs('Детальная картинка установлена!','ControlProduct','/logs/ControlProduct/');
                    }
                }
                else if($checkAction == 'Создать название товара'){
                    if($arFields['PROPERTY_VALUES']['108'][array_key_first($arFields['PROPERTY_VALUES']['108'])]['VALUE'] != 26) {
                        $productInsertsData = [];
                        AddMessage2Log($arFields['PROPERTY_VALUES']['86']);
                        foreach ($arFields['PROPERTY_VALUES']['86'] as $insertCount) {
                            if(is_array($insertCount)){
                                $insertNameAndCount = explode(' - ', explode(',', $insertCount['VALUE'])[0]);
                            } else {
                                $insertNameAndCount = explode(' - ', explode(',', $insertCount)[0]);
                            }
                            AddMessage2Log($insertNameAndCount);
                            if ($productInsertsData[mb_strtolower($insertNameAndCount[0])]) {
                                if ($insertNameAndCount[1] > $productInsertsData[mb_strtolower($insertNameAndCount[0])]) $productInsertsData[mb_strtolower($insertNameAndCount[0])] = $insertNameAndCount[1];
                            } else {
                                $productInsertsData[mb_strtolower($insertNameAndCount[0])] = $insertNameAndCount[1];
                            }
                        }
                        AddMessage2Log($productInsertsData);
                        $productItemType = getHLBTByXML($arFields['PROPERTY_VALUES']['32'][array_key_first($arFields['PROPERTY_VALUES']['32'])]['VALUE'], 4);
                        if ($productItemType) {
                            $newProductName = $productItemType;
                            $productMaterial = getHLBTByXML($arFields['PROPERTY_VALUES']['111'][array_key_first($arFields['PROPERTY_VALUES']['111'])]['VALUE'], 19);
                            if ($productMaterial) {
                                $productMaterial = preg_replace('/\d/', '', mb_strtolower($productMaterial));
                                $productMaterial = preg_replace('/  +/', ' ', $productMaterial);
                                $productMaterial = str_replace('пробы', '', $productMaterial);

                                $eachWord = explode(' ', $productMaterial);
                                foreach ($eachWord as &$word) {
                                    if ($word == 'белое') {
                                        $word = 'белого';
                                    } elseif ($word == 'желтое') {
                                        $word = 'желтого';
                                    } elseif ($word == 'красное') {
                                        $word = 'красного';
                                    } elseif ($word == 'нержавеющая') {
                                        $word = 'нержавеющей';
                                    } elseif ($word == 'серебро') {
                                        $word = 'серебра';
                                    } elseif ($word == 'золото') {
                                        $word = 'золота';
                                    } elseif ($word == 'серебро') {
                                        $word = 'серебра';
                                    } elseif ($word == 'сталь') {
                                        $word = 'стали';
                                    } elseif ($word == 'латунь') {
                                        $word = 'латуни';
                                    } elseif ($word == 'платина') {
                                        $word = 'платины';
                                    } elseif ($word == 'медь') {
                                        $word = 'меди';
                                    } elseif ($word == '/латунь') {
                                        $word = 'и латуни';
                                    } elseif ($word == '/медь') {
                                        $word = 'и меди';
                                    }
                                }
                                $productMaterial = ' из ' . implode(' ', $eachWord);
                                $newProductName .= $productMaterial;
                            }

                            $productInserts = [];
                            foreach ($arFields['PROPERTY_VALUES']['102'] as $insert) {
                                if (mb_strtolower(getHLBTByXML($insert, 18)) && !in_array(mb_strtolower(getHLBTByXML($insert, 18)), $productInserts) && mb_strtolower(getHLBTByXML($insert, 18)) != 'без вставок') {
                                    $productInserts[] = mb_strtolower(getHLBTByXML($insert, 18));
                                }
                            }

                            $insertString = '';
                            foreach ($productInserts as $vK => &$insert) {
                                if ($vK == 0) {
                                    $insertString .= ' с ';
                                } elseif ($vK == count($productInserts) - 1) {
                                    $insertString .= ' и ';
                                } else {
                                    $insertString .= ', ';
                                }
                                if ($insert == 'агат') {
                                    $insert = $productInsertsData['агат'] > 1 ? 'агатами' : 'агатом';
                                } elseif ($insert == 'аквамарин') {
                                    $insert = $productInsertsData['аквамарин'] > 1 ? 'аквамаринами' : 'аквамарином';
                                } elseif ($insert == 'александрит') {
                                    $insert = $productInsertsData['александрит'] > 1 ? 'александритами' : 'александритом';
                                } elseif ($insert == 'альмандин') {
                                    $insert = $productInsertsData['альмандин'] > 1 ? 'альмандинами' : 'альмандином';
                                } elseif ($insert == 'аметист') {
                                    $insert = $productInsertsData['аметист'] > 1 ? 'аметистами' : 'аметистом';
                                } elseif ($insert == 'аметрин') {
                                    $insert = $productInsertsData['аметрин'] > 1 ? 'аметринами' : 'аметрином';
                                } elseif ($insert == 'аурит') {
                                    $insert = $productInsertsData['аурит'] > 1 ? 'ауритами' : 'ауритом';
                                } elseif ($insert == 'белор. кварцит') {
                                    $insert = 'белор. кварцитом';
                                } elseif ($insert == 'бирюза') {
                                    $insert = $productInsertsData['бирюза'] > 1 ? 'бирюзой' : 'бирюзой';
                                } elseif ($insert == 'бриллиант') {
                                    $insert = $productInsertsData['бриллиант'] > 1 ? 'бриллиантами' : 'бриллиантом';
                                } elseif ($insert == 'горный хрусталь') {
                                    $insert = $productInsertsData['горный хрусталь'] > 1 ? 'горным хрусталем' : 'горным хрусталем';
                                } elseif ($insert == 'гранат') {
                                    $insert = $productInsertsData['гранат'] > 1 ? 'гранатами' : 'гранатом';
                                } elseif ($insert == 'деколь') {
                                    $insert = $productInsertsData['деколь'] > 1 ? 'деколью' : 'деколью';
                                } elseif ($insert == 'демантоид') {
                                    $insert = $productInsertsData['демантоид'] > 1 ? 'демантоидами' : 'демантоидом';
                                } elseif ($insert == 'дерево') {
                                    $insert = $productInsertsData['дерево'] > 1 ? 'деревом' : 'деревом';
                                } elseif ($insert == 'дерево/палисандр/') {
                                    $insert = 'деревом/палисандром';
                                } elseif ($insert == 'жемчуг') {
                                    $insert = $productInsertsData['жемчуг'] > 1 ? 'жемчугом' : 'жемчугом';
                                } elseif ($insert == 'живописное изображение') {
                                    $insert = 'живописным изображением';
                                } elseif ($insert == 'змеевик') {
                                    $insert = $productInsertsData['змеевик'] > 1 ? 'змеевиками' : 'змеевиком';
                                } elseif ($insert == 'змеевик (серпентин)') {
                                    $insert = $productInsertsData['змеевик (серпентин)'] > 1 ? 'змеевиками (серпентин)' : 'змеевиком (серпентин)';
                                } elseif ($insert == 'изумруд') {
                                    $insert = $productInsertsData['изумруд'] > 1 ? 'изумрудами' : 'изумрудом';
                                } elseif ($insert == 'камнерезная пластика') {
                                    $insert = 'камнерезной пластикой';
                                } elseif ($insert == 'кахолонг') {
                                    $insert = $productInsertsData['кахолонг'] > 1 ? 'кахолонгами' : 'кахолонгом';
                                } elseif ($insert == 'кварц') {
                                    $insert = $productInsertsData['кварц'] > 1 ? 'кварцами' : 'кварцем';
                                } elseif ($insert == 'кварцит') {
                                    $insert = $productInsertsData['кварцит'] > 1 ? 'кварцитами' : 'кварцитом';
                                } elseif ($insert == 'коралл') {
                                    $insert = $productInsertsData['коралл'] > 1 ? 'кораллами' : 'кораллом';
                                } elseif ($insert == 'корунд') {
                                    $insert = $productInsertsData['корунд'] > 1 ? 'корундами' : 'корундом';
                                } elseif ($insert == 'кремень') {
                                    $insert = 'кремнем';
                                } elseif ($insert == 'лазурит') {
                                    $insert = $productInsertsData['лазурит'] > 1 ? 'лазуритами' : 'лазуритом';
                                } elseif ($insert == 'люверсы') {
                                    $insert = $productInsertsData['люверсы'] > 1 ? 'люверсами' : 'люверсом';
                                } elseif ($insert == 'малахит') {
                                    $insert = $productInsertsData['малахит'] > 1 ? 'малахитами' : 'малахитом';
                                } elseif ($insert == 'миниатюра') {
                                    $insert = $productInsertsData['миниатюра'] > 1 ? 'миниатюрами' : 'миниатюрой';
                                } elseif ($insert == 'морганит') {
                                    $insert = $productInsertsData['морганит'] > 1 ? 'морганитами' : 'морганитом';
                                } elseif ($insert == 'морион') {
                                    $insert = $productInsertsData['морион'] > 1 ? 'морионами' : 'морионом';
                                } elseif ($insert == 'нефрит') {
                                    $insert = $productInsertsData['нефрит'] > 1 ? 'нефритами' : 'нефритом';
                                } elseif ($insert == 'нуарит') {
                                    $insert = $productInsertsData['нуарит'] > 1 ? 'нуаритами' : 'нуаритом';
                                } elseif ($insert == 'обсидиан') {
                                    $insert = $productInsertsData['обсидиан'] > 1 ? 'обсидианами' : 'обсидианом';
                                } elseif ($insert == 'окаменелое дерево') {
                                    $insert = 'окаменелом деревом';
                                } elseif ($insert == 'оникс') {
                                    $insert = $productInsertsData['оникс'] > 1 ? 'ониксами' : 'ониксом';
                                } elseif ($insert == 'опал') {
                                    $insert = $productInsertsData['опал'] > 1 ? 'опалами' : 'опалом';
                                } elseif ($insert == 'опал синтетический') {
                                    $insert = $productInsertsData['опал синтетический'] > 1 ? 'опалами синтетическими' : 'опалом синтетическим';
                                } elseif ($insert == 'офиокальцит') {
                                    $insert = $productInsertsData['офиокальцит'] > 1 ? 'офиокальцитами' : 'офиокальцитом';
                                } elseif ($insert == 'перламутр') {
                                    $insert = 'перламутром';
                                } elseif ($insert == 'печать на холсте') {
                                    $insert = 'печатью на холсте';
                                } elseif ($insert == 'пластик') {
                                    $insert = 'пластиком';
                                } elseif ($insert == 'празиолит') {
                                    $insert = $productInsertsData['празиолит'] > 1 ? 'празиолитами' : 'празиолитом';
                                } elseif ($insert == 'пренит') {
                                    $insert = $productInsertsData['пренит'] > 1 ? 'пренитами' : 'пренитом';
                                } elseif ($insert == 'родолит') {
                                    $insert = $productInsertsData['родолит'] > 1 ? 'родолитами' : 'родолит';
                                } elseif ($insert == 'родонит') {
                                    $insert = $productInsertsData['родонит'] > 1 ? 'родонитами' : 'родонит';
                                } elseif ($insert == 'рубин') {
                                    $insert = $productInsertsData['рубин'] > 1 ? 'рубинами' : 'рубином';
                                } elseif ($insert == 'сапфир') {
                                    $insert = $productInsertsData['сапфир'] > 1 ? 'сапфирами' : 'сапфиром';
                                } elseif ($insert == 'сердолик') {
                                    $insert = $productInsertsData['сердолик'] > 1 ? 'сердоликами' : 'сердоликом';
                                } elseif ($insert == 'ситалл') {
                                    $insert = $productInsertsData['ситалл'] > 1 ? 'ситаллами' : 'ситаллом';
                                } elseif ($insert == 'сомбрилл') {
                                    $insert = $productInsertsData['сомбрилл'] > 1 ? 'сомбриллами' : 'сомбриллом';
                                } elseif ($insert == 'танзанит') {
                                    $insert = $productInsertsData['танзанит'] > 1 ? 'танзанитами' : 'танзанитом';
                                } elseif ($insert == 'тигровый глаз') {
                                    $insert = 'тигровым глазом';
                                } elseif ($insert == 'топаз') {
                                    $insert = $productInsertsData['топаз'] > 1 ? 'топазами' : 'топазом';
                                } elseif ($insert == 'турмалин') {
                                    $insert = $productInsertsData['турмалин'] > 1 ? 'турмалинами' : 'турмалином';
                                } elseif ($insert == 'фианит') {
                                    $insert = $productInsertsData['фианит'] > 1 ? 'фианитами' : 'фианитом';
                                } elseif ($insert == 'флорентийская мозаика') {
                                    $insert = 'флорентийской мозаикой';
                                } elseif ($insert == 'халцедон') {
                                    $insert = $productInsertsData['халцедон'] > 1 ? 'халцедонами' : 'халцедоном';
                                } elseif ($insert == 'хризолит') {
                                    $insert = $productInsertsData['хризолит'] > 1 ? 'хризолитами' : 'хризолитом';
                                } elseif ($insert == 'хризопраз') {
                                    $insert = $productInsertsData['хризопраз'] > 1 ? 'хризопразами' : 'хризопразом';
                                } elseif ($insert == 'циркон') {
                                    $insert = $productInsertsData['циркон'] > 1 ? 'цирконами' : 'цирконом';
                                } elseif ($insert == 'цитрин') {
                                    $insert = $productInsertsData['цитрин'] > 1 ? 'цитринами' : 'цитрином';
                                } elseif ($insert == 'стекло') {
                                    $insert = 'ювелирным стеклом';
                                } elseif ($insert == 'шпинель') {
                                    $insert = $productInsertsData['шпинель'] > 1 ? 'шпинелями' : 'шпинелью';
                                } elseif ($insert == 'эмаль') {
                                    $insert = 'эмалью';
                                } elseif ($insert == 'ювелирное стекло') {
                                    $insert = 'ювелирным стеклом';
                                } elseif ($insert == 'янтарь') {
                                    $insert = 'янтарем';
                                } elseif ($insert == 'яшма') {
                                    $insert = $productInsertsData['яшма'] > 1 ? 'яшмами' : 'яшмой';
                                } elseif ($insert == 'яшма пестроцветная') {
                                    $insert = $productInsertsData['яшма пестроцветная'] > 1 ? 'яшмами пестроцветными' : 'яшмой пестроцветной';
                                } elseif ($insert == 'яшма техническая') {
                                    $insert = $productInsertsData['яшма техническая'] > 1 ? 'яшмами техническами' : 'яшмой технической';
                                }
                                $insertString .= $insert;
                            }
                            if ($insertString) {
                                $newProductName .= $insertString;
                            }
                            $newProductName = preg_replace('/  +/', ' ', $newProductName);
                            $arFields['NAME'] = $newProductName;
                            writeToLogs('Установка нового названия: "' . $newProductName . '"', 'ControlProduct', '/logs/ControlProduct/');
                        }
                    }
                }
            }

            writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
        }
        elseif($arFields['IBLOCK_ID'] == 6){
            if($arFields['PROPERTY_VALUES']){
                if($arFields['PROPERTY_VALUES']['51'][array_key_first($arFields['PROPERTY_VALUES']['51'])]['VALUE'] == 1){
                    $arFields['ACTIVE'] = 'N';
                }
            } else {
                $res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'],$arFields['ID'],[],['ID' => [51]]);
                while ($ob = $res->GetNext())
                {
                    if($ob['VALUE'] == 1){
                        $arFields['ACTIVE'] = 'N';
                        writeToLogs('Не показывать на сайте == 1 (товар деактивирован) "' . $arFields['NAME'] . '" => ' . $arFields['ID'],'ControlSeries','/logs/ControlSeries/');
                    }
                }
            }
        }
    }

    function ParseSeries($arFields){
        if($arFields['IBLOCK_ID'] == 6 && $arFields['ID']){
            $res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'],$arFields['ID'],[],['ID' => [47]]); //SERIES_INSERT
            while ($ob = $res->GetNext()) {
                if($ob['VALUE']){
                    $insert = $ob['VALUE'];
                    $insertsResult = parseStr($insert,$arFields['ID']);
                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], ['SERIES_INSERT_COLOR' => $insertsResult['color'],'SERIES_INSERT_RESULT' => $insertsResult['result'],'SERIES_INSERT_ERRORS' => $insertsResult['error'],'SERIES_INSERT_MATERIAL' => $insertsResult['MATERIAL']]);
                    writeToLogs('Установка вставок для "' . $arFields['NAME'] .'" => ' . $arFields['ID'],'ParseSeries','/logs/ParseSeries/');
                }
            }
        }
    }
}

function UpdateSeriesStoreInfo($arg1,$arg2 = false){
    static $use_handler = true;
    if ($use_handler) {
        CModule::IncludeModule("iblock");
        CModule::IncludeModule("catalog");
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
        $res = CIBlockElement::GetByID($arg1['ID']);
        while($ob = $res->GetNextElement()){
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            if($arFields['IBLOCK_ID'] != 6) return;

            $storeNAME = $arProps['SERIES_AVAILABLE_ROZ_SHOP']['VALUE'];
            $productQuantity = $arProps['SERIES_COUNT']['VALUE'];

            $rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $arFields['ID'])); //'STORE_ID' => $storeNAME2ID[$storeNAME]
            $foundNecessary = false;
            $existOfferStore = false;
            $arFields2Update = Array(
                "PRODUCT_ID" => $arFields['ID'],
                "STORE_ID" => $storeNAME2ID[$storeNAME],
                "AMOUNT" => $productQuantity,
            );
            while($ar_fields = $rs->GetNext())
            {
                $existOfferStore = true;
                if($ar_fields['STORE_ID'] != $storeNAME2ID[$storeNAME]){
                    CCatalogStoreProduct::Delete($ar_fields['ID']);
                } else {
                    $foundNecessary = true;
                    CCatalogStoreProduct::Update($ar_fields['ID'], $arFields2Update);
                }
            }
            if(!$foundNecessary) {
                CCatalogStoreProduct::Add($arFields2Update);
            }
            writeToLogs('Обновление складов для "' . $arFields['NAME'] .'" => ' . $arFields['ID'],'UpdateSeriesStoreInfo','/logs/CCatalogStoreProduct/');
        }
    }
}
function BXIBlockAfterSave($arFields) {
    UpdateSeriesStoreInfo($arFields);
}


//Создание лида в б24 (оформление заказа)
AddEventHandler("sale", "OnSaleComponentOrderOneStepComplete", Array("OrderHandler", "OrderImportToB24"));
AddEventHandler("sale", "OnSaleStatusOrderChange", Array("OrderHandler", "OrderStatusChanged"));
class OrderHandler{
    function OrderImportToB24($arFields,$arOrder,$arParams){
        CModule::IncludeModule('sale');
//        AddMessage2Log($arFields);
        $formName = 'Заказ через корзину' . ' ['.$arFields.']';

        $couponList = \Bitrix\Sale\Internals\OrderCouponsTable::getList(array(
            'select' => array('COUPON'),
            'filter' => array('=ORDER_ID' => $arFields)
        ));
        $coupon = ''; //PROMOCODE
        while ($couponT = $couponList->fetch())
        {
            if($coupon) {
                $coupon .= $couponT['COUPON'] . ' and ';
            } else {
                $coupon = $couponT['COUPON'];
            }
        }

        $orderProps = [];
        $dbOrderProps = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array("ORDER_ID" => $arFields, "CODE"=>array("NAME", "PHONE","ESHOPLOGISTIC_PVZ","LOCATION","STREET","HOUSE","APARTMENT","CITY"))
        );
        while ($arOrderProps = $dbOrderProps->GetNext()):
            $orderProps[$arOrderProps['CODE']] = $arOrderProps['VALUE'];
        endwhile;


        $location = $orderProps['LOCATION'];
        $phone = $orderProps['PHONE'];
        $city = CSaleLocation::GetByID($location)['CITY_NAME'];
        $pvz = $orderProps['ESHOPLOGISTIC_PVZ'];
        $name = $orderProps['NAME'];
        $street = $orderProps['STREET'];
        $house = $orderProps['HOUSE'];
        $apartment = $orderProps['APARTMENT'];

        $comment = '';
        $arOrder = CSaleOrder::GetByID($arFields);
        if (is_array($arOrder)) {
            $comment = $arOrder['USER_DESCRIPTION'];
        }

        $deliveryPrice = $arOrder['PRICE_DELIVERY'];
        $order = Bitrix\Sale\Order::load($arFields);
        $deliveryID = $order->getDeliverySystemId()[0];
        $deliveryName = '';
        if($deliveryID == 33){
            $deliveryB24ID = 201;
        } elseif($deliveryID == 32){
            $deliveryB24ID = 205;
        } elseif($deliveryID == 3){
            $city = 'Санкт-Петербург';
            $deliveryB24ID = 203;
        }

        $paymentCollection = $order->getPaymentCollection();
        foreach ($paymentCollection as $payment) {
            $psID = $payment->getPaymentSystemId(); // ID платежной системы
            $paymentID = $psID;
        }

        $orderProducts = [];
        $res = CSaleBasket::GetList(array(), array("ORDER_ID" => $arFields)); // ID заказа
        while ($arItem = $res->Fetch()) {
        //     AddMessage2Log($arItem);
            $orderProducts[] = $arItem['PRODUCT_ID'];
            $PROPERTY_CODE = "CUSTOM_PRICE";
            $PROPERTY_VALUE = $arItem['PRICE'];
            $mxResult = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
            if (is_array($mxResult)) {
                $elId = $mxResult['ID'];
            } else {
                $elId = $arItem['PRODUCT_ID'];
            }
            if($arItem['PRICE'] && $elId)
                CIBlockElement::SetPropertyValuesEx($elId, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
        }
//        AddMessage2Log($orderProducts);

        AddMessage2Log([
            'PAYMENT_ID' => $paymentID,
            'ORIGIN_ID' => $arFields,
            'PROMOCODE' => $coupon,
            'STREET' => $street, //
            'HOUSE' => $house, //
            'APARTMENT' => $apartment, //
            'CONTACT_NAME' => $name,
            'COMMENTS' => $comment,
            'CITY' => $city,
            'PVZ' => $pvz, //
            'DELIVERY' => $deliveryB24ID,
            'TITLE' => $formName,
            'PHONE' => $phone,
            'PRODUCTS_ID' => $orderProducts,
            'DELIVERY_PRICE' => $deliveryPrice,
        ]);
        createLead([
            'PAYMENT_ID' => $paymentID,
            'ORIGIN_ID' => $arFields,
            'PROMOCODE' => $coupon,
            'STREET' => $street, //
            'HOUSE' => $house, //
            'APARTMENT' => $apartment, //
            'CONTACT_NAME' => $name,
            'COMMENTS' => $comment,
            'CITY' => $city,
            'PVZ' => $pvz, //
            'DELIVERY' => $deliveryB24ID,
            'TITLE' => $formName,
            'PHONE' => $phone,
            'PRODUCTS_ID' => $orderProducts,
            'DELIVERY_PRICE' => $deliveryPrice,
        ]);
    }
    function OrderStatusChanged($order,$newStatus = '',$oldStatus = ''){
        $orderID = $order->getId();
        if($newStatus == 'P' || $newStatus == 'PS' || $newStatus == 'RF' || $newStatus == 'C') {
            $b24Deal = b24DealList(["ID" => "ASC"],['ORIGIN_ID' => $orderID]);
            $b24DealID = $b24Deal[0]['ID'];
            AddMessage2Log($b24Deal);
            AddMessage2Log($b24DealID);
            //Оплачен online, требует подтверждения
            if($newStatus == 'P'){
                $newPaymentStatusID = 213;
            }
            //Оплачено Online, платеж подтвержден
            elseif ($newStatus == 'PS') {
                $newPaymentStatusID = 215;
            }
            //Возврат
            elseif ($newStatus == 'RF') {
                $newPaymentStatusID = 217;
            }
            //Заказ отменен
            elseif ($newStatus == 'C') {
                $newPaymentStatusID = 219;
            }
            writeToLogs('order['.$orderID.'] status changed from: '.$oldStatus.' to: ' . $newStatus,'payment-change');
            $b24DealUpdateResult = b24DealUpdate($b24DealID,['UF_CRM_1653990805475' => $newPaymentStatusID]);
            AddMessage2Log($b24DealUpdateResult);
        }
    }
}


//AddEventHandler("catalog", "OnDiscountAdd", "eventChangeDiscount" );
//AddEventHandler("catalog", "OnDiscountUpdate", "eventChangeDiscount");
//AddEventHandler("catalog", "OnBeforeDiscountDelete", "eventChangeDiscount" );

function eventChangeDiscount ($id, $arFields=[])
{
    if(CModule::IncludeModule("catalog"))
    {

        if(empty($arFields["PRODUCT_IDS"]) && !empty($id)) // при удалении скидки
        {
            // запомним IDшники товаров из акции
            $resDiscount = CCatalogDiscount::GetList(array(), array("ID"=>$id));
            Bitrix\Main\Diag\Debug::writeToFile(array('discount_id' => $id, 'fields'=>$arFields ),"","/logs/ControlProduct/ChangeDiscount.txt");
            while($obDiscount = $resDiscount->Fetch())
            {
                $arPrice = CCatalogProduct::GetOptimalPrice($obDiscount["PRODUCT_ID"], 1, array(2), "N", array() , "s1");
                CIBlockElement::SetPropertyValueCode($obDiscount["PRODUCT_ID"], "TOTAL_SALE", $arPrice["DISCOUNT_LIST"][0]['VALUE']);
            }
        }



        if(!empty($arFields["PRODUCT_IDS"]))
        {
            foreach($arFields["PRODUCT_IDS"] as $prod_id)
            {
                // нужно для сортировки цены со скидкой
                // Прошу обратить внимание - обязательно указание сайта!!! в моем случае "s1"
                $arPrice = CCatalogProduct::GetOptimalPrice($prod_id, 1, array(2), "N", array() , "s1");
                Bitrix\Main\Diag\Debug::writeToFile(array('ID' => $prod_id, 'fields'=>$arPrice ),"","/logs/ControlProduct/ChangeDiscount.txt");
                CIBlockElement::SetPropertyValueCode($prod_id, "TOTAL_SALE", $arPrice["DISCOUNT_LIST"][0]['VALUE']);
                // можем поменять на SetPropertyValues, если знаем ID Инфоблока
            }
        }

        Bitrix\Main\Diag\Debug::writeToFile(array('finish' => 1, 'ID' => $id, 'fields'=>$arFields ),"","/logs/ControlProduct/ChangeDiscount.txt");
    }
}

AddEventHandler(
    'catalog',
    'OnBeforeCatalogImport1C',
    function ()
    {
        $_SESSION["1C_UPDATE"] = true;
    }
);

\Bitrix\Main\EventManager::getInstance()->addEventHandler('catalog','\Bitrix\Catalog\Model\Product::OnBeforeUpdate','onBeforeProductUpdate');

function onBeforeProductUpdate(\Bitrix\Catalog\Model\Event $event){

    // if($_SESSION["1C_UPDATE"] == true):
        $result     =   new \Bitrix\Catalog\Model\EventResult();

        $arFields   =   $event->getParameter('fields');

        $id         =   $event->getParameter('primary')['ID'];
        $mxResult = CCatalogSku::GetProductInfo($id);
        if (is_array($mxResult)) {
            $PRODUCT_ID = $mxResult['ID']; // ID товара родителя
        } else {
            $PRODUCT_ID = $id; // если не нашло, запишет ID торгового предложения
        }
        $params = array(
            'filter' => array(
                "ID" => $PRODUCT_ID
            ),
            'select' => array(
                'ID',
                'CUSTOM_PRICE' =>'PROPERTY.PROPERTY_99'
            ),
        );
        $params['runtime'] = array(
            'PROPERTY' => array(
                'data_type' => 'Bitrix\Iblock\IblockElementProperty',
                'reference' => array('=this.ID' => 'ref.IBLOCK_ELEMENT_ID'),
            )
        );
        $rs = \Bitrix\Iblock\ElementTable::getList($params);
        $arElement = $rs->fetch();
        if($arFields['PRICE'] && $PRODUCT_ID)
            CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, array('CUSTOM_PRICE' => $arFields['PRICE']));
    
        return  $result;
    // endif;
}
//AddEventHandler( "iblock" , "OnBeforeIBlockElementUpdate", "onBeforeElementUpdate");
function onBeforeElementUpdate($arFields){

    if($arFields['IBLOCK_ID'] == 6 && $arFields['ACTIVE'] == 'N'):
        CModule::IncludeModule('catalog');
        $id         =   $arFields['ID'];
        $mxResult = CCatalogSku::GetProductInfo($id);
        if (is_array($mxResult)) {
            $PRODUCT_ID = $mxResult['ID']; // ID товара родителя
        } else {
            $PRODUCT_ID = $id; // если не нашло, запишет ID торгового предложения
        }
        $params = array(
            'filter' => array(
                "ID" => $PRODUCT_ID
            ),
            'select' => array(
                'ID',
                'CUSTOM_PRICE' =>'PROPERTY.PROPERTY_99'
            ),
        );
        $params['runtime'] = array(
            'PROPERTY' => array(
                'data_type' => 'Bitrix\Iblock\IblockElementProperty',
                'reference' => array('=this.ID' => 'ref.IBLOCK_ELEMENT_ID'),
            )
        );
        $rs = \Bitrix\Iblock\ElementTable::getList($params);
        $arElement = $rs->fetch();
        $price = CCatalogProduct::GetOptimalPrice($id);
        if($price['PRICE']['PRICE'] && $PRODUCT_ID)
            CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, array('CUSTOM_PRICE' => $price['PRICE']['PRICE']));
    
        return  $arFields;
    endif;
}