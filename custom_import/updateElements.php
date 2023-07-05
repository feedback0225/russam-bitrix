<?
if(!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
if(false){
    AddMessage2Log('start detail image update!');
    $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y');
    $res = CIBlockElement::GetList(Array(), $arrFilter, false);
    $c = 0;
    global $checkDirectoryForImg;
    $addedToExisted = [];
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();

        $mainProductID = $arProps['MAIN_PRODUCT_ID']['VALUE'];
        $imageCount = 0;
        $existImage = false;
        $img = '';
        if($mainProductID){
            for($imageCounter = 0;$imageCounter < 30;$imageCounter++){
                $tempProductID = $mainProductID.(($imageCounter>=1) ? '_'.$imageCounter:'');
                $img = checkExistFileAndGetExtension($_SERVER["DOCUMENT_ROOT"],$checkDirectoryForImg,$tempProductID);
                if($img['exists']){
                    $existImage = true;
                    $imageCount++;
                    break;
                }
            }
            if($existImage){
                //$addedToExisted[] = $arFields['ID'];
                $el = new CIBlockElement;
                $arLoadProductArray = Array("ACTIVE" => "Y");
                $arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray($img['position']);
                $res2 = $el->Update($arFields['ID'], $arLoadProductArray);
                //debug('no image: ' . $arFields['NAME']);
            }
        }
    }
    AddMessage2Log('end detail image update!');
} elseif(false){
    AddMessage2Log('start store update!');
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
    $arrFilter = Array('IBLOCK_ID'=>6);
    $res = CIBlockElement::GetList(Array(), $arrFilter, false);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();

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
    }
    AddMessage2Log('finish store update!');
} elseif(false){
    AddMessage2Log('start repair update!');
    $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y');
    $res = CIBlockElement::GetList(Array(), $arrFilter, false);
    $disCount = 0;
    $actCount = 0;
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        $productType = CCatalogProduct::GetByID($arFields['ID'])['TYPE'];

        $el = new CIBlockElement;
        if($arFields['ACTIVE'] == 'Y' && $productType != 3 && $arProps['SHOW_WITHOUT_OFFERS']['VALUE'] != 24){
            $arLoadProductArray = Array("ACTIVE" => "N");
            $res2 = $el->Update($arFields['ID'], $arLoadProductArray);
            $disCount++;
        } elseif($arFields['ACTIVE'] == 'N' && $productType != 1 && CCatalogProduct::GetByID($arFields['ID'])['AVAILABLE'] == 'N' && $arProps['SHOW_WITHOUT_OFFERS']['VALUE'] == 24){
            $arLoadProductArray = Array("ACTIVE" => "Y");
            $res2 = $el->Update($arFields['ID'], $arLoadProductArray);
            $actCount++;
        } elseif($arFields['ACTIVE'] == 'Y' && $productType != 1 && CCatalogProduct::GetByID($arFields['ID'])['AVAILABLE'] == 'N' && $arProps['SHOW_WITHOUT_OFFERS']['VALUE'] != 24){
            $arLoadProductArray = Array("ACTIVE" => "N");
            $res2 = $el->Update($arFields['ID'], $arLoadProductArray);
            $disCount++;
        }
    }
    AddMessage2Log('end repair update!');
    AddMessage2Log('activated: ' . $actCount);
    AddMessage2Log('disable: ' . $disCount);
} elseif (false){
    AddMessage2Log('START INSERT GENERATE!!');
    $testC = 0;
    $arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_SERIES_INSERT","PROPERTY_SERIES_UPDATE_COLOR");
    $arFilter = Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y",'!PROPERTY_SERIES_INSERT' => false,'>TIMESTAMP_X' => date('15.07.2022 00:00')); //'PROPERTY_SERIES_INSERT_RESULT' => false
//    ["nPageSize"=>5000,'iNumPage' => 5]
    $res = CIBlockElement::GetList(Array('ID' => 'DESC'), $arFilter, false, ["nPageSize"=>5000,'iNumPage' => 1], $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        if($arFields['PROPERTY_SERIES_INSERT_VALUE']){
            $insertsResult = parseStr($arFields['PROPERTY_SERIES_INSERT_VALUE'],$arFields['ID']);
            if($arFields['PROPERTY_SERIES_UPDATE_COLOR_VALUE'] == 'Нет'){
                CIBlockElement::SetPropertyValuesEx($arFields['ID'], 6, ['SERIES_INSERT_RESULT' => $insertsResult['result'],'SERIES_INSERT_ERRORS' => $insertsResult['error'],'SERIES_INSERT_MATERIAL' => $insertsResult['MATERIAL']]);
            } else {
                CIBlockElement::SetPropertyValuesEx($arFields['ID'], 6, ['SERIES_INSERT_COLOR' => $insertsResult['color'],'SERIES_INSERT_RESULT' => $insertsResult['result'],'SERIES_INSERT_ERRORS' => $insertsResult['error'],'SERIES_INSERT_MATERIAL' => $insertsResult['MATERIAL']]);
            }
            if($testC % 10 == 0){
                AddMessage2Log($testC);
            }
        } else {
            CIBlockElement::SetPropertyValuesEx($arFields['ID'], 6, ['SERIES_INSERT_MATERIAL' => ['no-insert']]);
        }
        $testC++;
    }
    AddMessage2Log('END INSERT GENERATE!!');
} elseif (false){
    AddMessage2Log('start repair update!');
    $arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_UPDATE_NAME");
    $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y','PROPERTY_UPDATE_NAME' => false);
    $res = CIBlockElement::GetList(Array(), $arrFilter, false,["nPageSize"=>10,'iNumPage' => 1]);
    $disCount = 0;
    $actCount = 0;
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        AddMessage2Log($arFields['ID']);
        AddMessage2Log($arFields);
    }
} elseif(false){
    $res = CIBlockElement::GetList(
        array('ID' => 'ASC'),
        array('IBLOCK_ID' => 6,'ACTIVE' => 'Y'),
        false,
        ['nPageSize' => 20000,'iNumPage' => 2]
    );

    AddMessage2Log('start 10k');
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $PRODUCT_ID = $arFields['ID'];

        $el = new CIBlockElement;
        $el->Update($PRODUCT_ID, ['PREVIEW_TEXT' => time()]);
    }
    AddMessage2Log('end 10k');
} elseif(false){
    AddMessage2Log('start update!!!');
    $res = CIBlockElement::GetList(
        array('ID' => 'ASC'),
        array('IBLOCK_ID' => 5,"ACTIVE" => "Y", '>TIMESTAMP_X' => date('15.08.2022 00:00')),
        //array('IBLOCK_ID' => 5,'PROPERTY_VSTAVKA' => 'no-insert'),
        false,
        ['nPageSize' => 2000,'iNumPage' => 1]
    );

    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $PRODUCT_ID = $arFields['ID'];

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
            $finalProperties = [];
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

            if($curProductProperties['SHOW_WITHOUT_OFFERS']['VALUE'] == 'Y'){
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
                        AddMessage2Log($curProductProperties['UPDATE_PRODUCT_COLOR']['VALUE']);
                        if($productType != 1 && $curProductProperties['UPDATE_PRODUCT_COLOR']['VALUE'] != 'Нет'){
                            $productOffersRes = CIBlockElement::GetList(
                                array(),
                                array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $curProductFields['ID']),
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
                                array('IBLOCK_ID' => 6, '=PROPERTY_CML2_LINK' => $curProductFields['ID']),
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
                            if(!$insertedToProduct){
                                $finalProperties['VSTAVKA_FILTER'] = [];
                                $finalProperties['VSTAVKA_FILTER'][0] = 'no-insert';
                                $finalProperties['VSTAVKA'] = [];
                                $finalProperties['VSTAVKA'][0] = '';
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
                        if($curProductProperties['UPDATE_NAME']['VALUE'] != 'Запретить') {
                            $productInsertsData = [];
                            foreach ($curProductProperties['VSTAVKA']['VALUE'] as $insertCount){
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
                                    if(mb_strtolower(getHLBTByXML($insert,18)) && !in_array(mb_strtolower(getHLBTByXML($insert,18)),$productInserts) && mb_strtolower(getHLBTByXML($insert,18)) != 'без вставок'){
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
                                    } elseif($insert == 'стекло'){
                                        $insert = 'ювелирным стеклом';
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
                    }
                }

                //Зафиксировать изменения!!!!
                $afterImportElementProccess = new CIBlockElement;
                $afterImportElementProccess->Update($curProductFields['ID'],$finalFields);
                CIBlockElement::SetPropertyValuesEx($curProductFields['ID'], $curProductFields['IBLOCK_ID'], $finalProperties);

                writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
            }
        }

    }
    AddMessage2Log('done update!!!');
} elseif(false){
    $articles = [
        '00010',
        '00177',
        '00188',
        '00201',
        '00519',
        '00555',
        '00814',
        '00823',
        '00824',
        '00825',
        '00826',
        '00827',
        '00830',
        '00835',
        '00906',
        '00923',
        '01805',
        '01808',
        '00921',
        '01856',
        '01887',
        '01909',
        '01916',
        '10062',
        '10066',
        '10069',
        '10072',
        '10074',
        '10081',
        '10081',
        '10082',
        '10084',
        '10114',
        '10151',
        '10152',
        '10162',
        '10204',
        '10204',
        '10241',
        '10255',
        '10261',
        '10288',
        '10291',
        '10308',
        '10322',
        '10323',
        '10324',
        '10334',
        '10354',
        '10354',
        '10371',
        '10371',
        '10371',
        '10372',
        '10377',
        '10404',
        '10412',
        '10453',
        '10455',
        '10456',
        '10483',
        '10510',
        '10516',
        '10518',
        '10534',
        '10552',
        '10568',
        '10581',
        '10581',
        '10623',
        '10624',
        '10626',
        '10631',
        '10692',
        '10711',
        '10730',
        '10789',
        '10790',
        '10792',
        '10794',
        '10794',
        '10803',
        '10814',
        '10818',
        '10819',
        '10821',
        '10850',
        '10878',
        '10878',
        '10879',
        '10879',
        '10880',
        '10880',
        '10913',
        '10965',
        '10976',
        '10977',
        '14182',
        '14222',
        '14268',
        '14375',
        '14503',
        '14505',
        '14514',
        '14518',
        '14522',
        '14524',
        '14529',
        '14616',
        '14618',
        '14619',
        '14621',
        '14627',
        '14683',
        '14683',
        '15311',
        '15398',
        '15437',
        '15444',
        '15472',
        '15507',
        '15507',
        '15516',
        '15516',
        '15562',
        '15624',
        '15722',
        '15732',
        '15737',
        '15920',
        '15921',
        '17003',
        '17009',
        '17016',
        '17034',
        '17038',
        '17089',
        '17179',
        '17179',
        '17179',
        '17182',
        '17182',
        '17241',
        '17291',
        '17391',
        '17392',
        '17536',
        '17566',
        '17569',
        '17690',
        '17690',
        '17690',
        '17719',
        '17721',
        '17721',
        '17721',
        '17732',
        '17732',
        '17733',
        '17739',
        '17739',
        '17740',
        '17740',
        '17741',
        '17764',
        '17764',
        '17781',
        '17789',
        '17832',
        '17856',
        '17917',
        '17917',
        '17924',
        '17932',
        '17946',
        '17983',
        '17986',
        '18018',
        '18039',
        '18039',
        '18077',
        '18142',
        '18143',
        '18258',
        '18264',
        '18282',
        '18415',
        '18439',
        '18440',
        '18567',
        '18567',
        '18713',
        '18888',
        '18972',
        '40256',
        '40257',
        '40353',
        '52007',
        '52152',
        '53096',
        '53171',
        '53174',
        '53201',
        '53203',
        '53216',
        '53217',
        '53267',
        '53268',
        '53269',
        '53270',
        '53271',
        '53272',
        '53273',
        '53276',
        '53285',
        '53287',
        '53288',
        '53289',
        '53290',
        '53291',
        '53292',
        '53293',
        '53295',
        '53296',
        '53297',
        '53298',
        '53300',
        '53302',
        '53305',
        '53306',
        '53307',
        '53315',
        '53316',
        '53322',
        '53324',
        '53334',
        '53339',
        '53343',
        '53350',
        '53351',
        '53354',
        '53355',
        '53375',
        '53423',
        '53424',
        '53426',
        '53429',
        '53430',
        '53431',
        '53486',
        '53487',
        '53490',
        '53491',
        '53492',
        '53495',
        '53496',
        '53498',
        '53499',
        '53502',
        '53505',
        '53506',
        '53507',
        '53511',
        '53512',
        '53532',
        '53536',
        '53539',
        '53540',
        '53552',
        '53553',
        '53555',
        '53579',
        '53589',
        '53590',
        '53593',
        '53594',
        '53595',
        '53596',
        '53597',
        '53599',
        '53611',
        '53612',
        '53617',
        '53618',
        '53622',
        '53623',
        '53624',
        '53628',
        '53636',
        '53637',
        '53638',
        '53639',
        '53640',
        '53641',
        '53642',
        '53643',
        '53644',
        '53645',
        '53646',
        '53647',
        '53648',
        '53660',
        '53661',
        '53663',
        '53664',
        '53665',
        '53707',
        '53711',
        '53721',
        '53734',
        '53736',
        '53739',
        '53763',
        '53764',
        '53801',
        '59059',
        '59061',
        '59062',
        '59064',
        '59065',
        '59066',
        '59067',
        '59070',
        '59116',
        '59120',
        '59121',
        '59122',
        '59123',
        '59124',
        '59137',
        '59146',
        '59170',
        '59213',
        '59230',
        '59253',
        '59254',
        '59255',
        '59257',
        '59261',
        '59262',
        '59263',
        '59264',
        '59267',
        '59269',
        '59270',
        '59271',
        '61603',
        '67247',
        '69127',
        '69825',
        '69830',
        '69833',
        '69835',
        '69838',
        '69839',
        '70206',
        '70320',
        '70330',
        '70337',
        '70345',
        '70346',
        '70348',
        '70349',
        '70537',
        '70538',
        '70544',
        '70545',
        '70546',
        '70547',
        '70548',
        '70550',
        '70554',
        '70558',
        '70561',
        '70569',
        '70570',
        '70580',
        '70581',
        '70582',
        '70584',
        '70585',
        '70595',
        '70596',
        '70606',
        '70619',
        '70622',
        '70635',
        '70636',
        '70637',
        '71060',
        '71078',
        '71148',
        '71203',
        '71208',
        '71269',
        '71369',
        '71375',
        '71389',
        '71422',
        '71428',
        '71513',
        '71516',
        '71534',
        '71536',
        '71564',
        '71624',
        '71642',
        '71713',
        '71742',
        '71803',
        '71913',
        '71955',
        '71967',
        '71994',
        '74054',
        '74055',
        '74123',
        '74124',
        '80698',
        '88020',
        '88030',
        '88032',
        '88040',
        '88042',
        '88042',
        '88043',
        '88043',
        '88056',
        '88065',
        '88066',
        '88074',
        '88075',
        '88077',
        '88078',
        '88081',
        '88112',
        '88113',
        '88131',
        '88132',
        '88134',
        '88139',
        '88140',
        '88166',
        '88207',
        '88262',
        '88263',
        '88264',
        '88264',
        '88271',
        '88272',
        '88273',
        '88274',
        '88279',
        '88287',
        '88288',
        '88290',
        '88292',
        '88296',
        '88297',
        '88303',
        '88320',
        '88322',
        '88322',
        '88324',
        '88330',
        '88332',
        '88339',
        '88340',
        '88341',
        '88351',
        '88353',
        '88353',
        '88353',
        '88355',
        '88356',
        '88358',
        '88358',
        '88361',
        '88368',
        '88369',
        '88373',
        '88397',
        '88401',
        '88401',
        '88404',
        '88405',
        '88407',
        '88408',
        '88409',
        '88413',
        '88419',
        '88420',
        '88427',
        '88429',
        '88430',
        '88435',
        '88436',
        '88439',
        '88440',
        '88441',
        '88443',
        '88444',
        '88448',
        '88454',
        '88477',
        '88481',
        '88511',
        '88514',
        '88516',
        '88519',
        '88520',
        '88521',
        '88522',
        '88523',
        '88523',
        '88525',
        '88525',
        '88526',
        '88530',
        '88531',
        '88532',
        '88541',
        '88542',
        '88543',
        '88544',
        '88545',
        '88546',
        '88547',
        '88551',
        '88555',
        '88556',
        '88611',
        '88658',
        '88697',
        '88708',
        '88717',
        '88725',
        '88744',
        '88746',
        '88748',
        '88750',
        '88751',
        '88752',
        '88753',
        '88754',
        '88755',
        '88758',
        '88779',
        '90002',
        '90010',
        '90015',
        '90016',
        '90074',
        '90100',
        '90106',
        '90124',
        '90169',
        '90180',
        '90211',
        '90242',
        '90245',
        '90352',
        '90386',
        '90395',
        '90401',
        '90454',
        '90472',
        '90583',
        '90612',
        '90613',
        '90704',
        '90705',
        '90728',
        '90744',
        '90745',
        '90914',
        '90917',
        '90919',
        '90923',
        '90980',
        '90980',
        '90988',
        '90993',
        '95004',
        '95004',
        '95202',
        '95203',
        '95206',
        '95214',
        '95215',
        '95216',
        '95217',
        '95221',
        '95240',
        '95291',
        '95292',
        '95293',
        '95300',
        '95300',
        '95302',
        '95332',
        '95334',
        '95338',
        '95340',
        '95341',
        '95356',
        '95380',
        '95381',
        '95389',
        '95397',
        '95398',
        '95416',
        '95422',
        '95426',
        '95427',
        '95429',
        '95430',
        '95431',
        '95432',
        '95433',
        '95434',
        '95444',
        '95445',
        '95447',
        '95453',
        '95454',
        '95455',
        '95457',
        '95460',
        '95462',
        '95463',
        '95464',
        '95475',
        '95497',
        '95498',
        '95500',
        '95501',
        '95502',
        '95503',
        '95504',
        '95505',
        '95506',
        '95507',
        '95508',
        '95509',
        '95510',
        '95513',
        '95514',
        '95515',
        '95516',
        '95517',
        '95518',
        '95519',
        '95545',
    ];
    foreach ($articles as $item){
        $findElement = false;
        $elementID = 0;
        $arSelect = Array("ID", "NAME");
        $arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_ARTICLE"=>'00010');
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $elementID = $arFields['ID'];
            $findElement = true;
        }
        if(!$findElement){
            $arSelect = Array("ID", "NAME");
            $arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_ARTICLE"=>'00010000000');
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                $elementID = $arFields['ID'];
                $findElement = true;
            }
        }
        if($elementID > 0){
            CIBlockElement::SetPropertyValuesEx($item, 5, ['CUSTOM_SALE' => 46]);
        }
    }
} elseif(true){
    debug('qeqw');
    $arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y',"ID" => [159841],'PROPERTY_PREVIEW_IMAGES' => false);
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
                writeToLogs('https://market.russam.ru' . $img['position'],'$updatesNewImages');
                $resultImages[] = 'https://market.russam.ru' . $img['position'];
            }
        }


        $addedImageCount = 0;
        foreach($resultImages as $rImage){
            $fileID = '';
            $fileName = explode('/', $rImage)[count(explode('/', $rImage)) - 1];
            $fileName = strtok($fileName, '?');
            $resFile = CFile::GetList(array("FILE_SIZE" => "desc"), array("ORIGINAL_NAME" => $fileName));
            while ($resF = $resFile->GetNext()) {
                $fileID = $resF['ID'];
            }

            if($fileID) {
                CFile::Delete($fileID);
                $file = CFile::MakeFileArray($rImage);
                $file['MODULE_ID'] = 'iblock';
                $fileID = CFile::SaveFile($file, "products");
            } else {
                $file = CFile::MakeFileArray($rImage);
                $file['MODULE_ID'] = 'iblock';
                $fileID = CFile::SaveFile($file, "products");
            }
            if($fileID > 0){
                $newProductImg = 'https://market.russam.ru' . imageX2($fileID,'300')[0];
                $updatesNewImages['n' . ($addedImageCount++)] = CFile::MakeFileArray($newProductImg);
            }
        }

        if($updatesNewImages){
            writeToLogs($updatesNewImages,'$updatesNewImages');
            CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'],['PREVIEW_IMAGES' => $updatesNewImages]);
        }
    }
}
