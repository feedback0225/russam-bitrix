<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;

if($USER->IsAdmin()) {
	
	function renewCatalogElement($ID) {
		$res = CIBlockElement::GetList(
			array('ID' => 'ASC'),
			array('IBLOCK_ID' => 5,"ID"=>$ID),
			false,
			['nPageSize' => 1,'iNumPage' => 1]
		);

		while($ob = $res->GetNextElement()){
			$arFields = $ob->GetFields();
			$PRODUCT_ID = $arFields['ID'];

			if($PRODUCT_ID){
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
					$afterImportElementProccess = new CIBlockElement;
					$afterImportElementProccess->Update($curProductFields['ID'],$finalFields);
					CIBlockElement::SetPropertyValuesEx($curProductFields['ID'], $curProductFields['IBLOCK_ID'], $finalProperties);

					writeToLogs('Время выполнения изменений: '.round(microtime(true) - $start, 4).' сек.','ControlProduct','/logs/ControlProduct/');
				}
			}

		}
		AddMessage2Log('done update!!!');
	}


renewCatalogElement(189670);


}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 