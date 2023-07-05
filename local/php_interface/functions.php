<?

use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;

function writeToLogs($data, $name, $patch_log_file = '')
{
	if (empty($patch_log_file)) {
		$patch_log_file = $_SERVER["DOCUMENT_ROOT"] . '/logs/';
	} else {
		$patch_log_file = $_SERVER["DOCUMENT_ROOT"] . $patch_log_file;
	}

	$debug = debug_backtrace();

	$log = "\n------------------------(" . date("Y.m.d G:i:s") . ")\n";
	if ($debug)
		$log .= "FILE:" . $debug[0]['file'] . " (" . $debug[0]['line'] . ")\n";
	$log .= print_r($data, 1);

	$fp = fopen($patch_log_file . $name . '_' . date("Y_m_d") . '.log', 'a');
	$fwrite = fwrite($fp, $log);
	fclose($fp);
	return true;
}

function debug($arr)
{
	global $USER;
	if ($USER->IsAdmin()) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}


function isBot()
{

	if (!isset($_SERVER['HTTP_USER_AGENT'])) {

		$_SERVER['HTTP_USER_AGENT'] = '';
	}

	$bots = [
		'Google', 'Yandex', 'Baiduspider', 'Lycos', 'Genieo', 'Slurp', 'WebAlta', 'facebook',
		'Mail.Ru', 'ia_archiver', 'Teoma', 'Yahoo', 'Ask', 'Rambler', 'crawler4j', 'MJ12',
		'Seznam', 'Bot', 'cURL', 'DuckDuckGo', 'AOL', 'Lighthouse'
	];

	foreach ($bots as $bot) {

		if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {

			return $bot;
		}
	}

	return false;
}

function imageX2($image_id, $image_width = 0, $image_height = 0)
{
	$img = CFile::GetFileArray($image_id);
	$proportional = 0;
	$imgValue = $image_id;
	if ($image_width > 0) {
		$proportional = ($img['HEIGHT'] / 2) / ($img['WIDTH'] / 2);
		$width = $image_width;
		$height = $image_width * $proportional;
	} elseif ($image_height > 0) {
		$proportional = ($img['WIDTH'] / 2) / ($img['HEIGHT'] / 2);
		$width = $image_height * $proportional;;
		$height = $image_height;


		$width = $img['WIDTH'] / 2;
		$height = $img['HEIGHT'] / 2;
	} else {
		$width = $img['WIDTH'] / 2;
		$height = $img['HEIGHT'] / 2;
	}
	$tempX = CFile::ResizeImageGet(
		$imgValue,
		array(
			'width' => $width, 'height' => $height,
			BX_RESIZE_IMAGE_PROPORTIONAL,
		)
	);
	$tempX2 = CFile::ResizeImageGet(
		$imgValue,
		array(
			'width' => ($width * 2), 'height' => ($height * 2),
			BX_RESIZE_IMAGE_PROPORTIONAL,
		)
	);
	return [$tempX['src'], $tempX2['src']];
}

function productInBasket($id)
{
	if (CModule::IncludeModule("sale")) {
		$dbBasketItems = CSaleBasket::GetList(
			array("NAME" => "ASC", "ID" => "ASC"),
			array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
			false,
			false,
			array("ID", "MODULE", "PRODUCT_ID", "QUANTITY", "CAN_BUY", "PRICE")
		);
		while ($arItems = $dbBasketItems->Fetch()) {
			$arItems = CSaleBasket::GetByID($arItems["ID"]);
			if ($arItems['PRODUCT_ID'] == $id) {
				return true;
			}
		}

		return false;
	}
}

function productInWishList($id)
{
	global $APPLICATION;
	global $USER;
	if (!$USER->IsAuthorized()) // Для неавторизованного
	{
		$arElements = unserialize($APPLICATION->get_cookie('favorites'));
		if (in_array($id, $arElements)) {
			return true;
		}
	} else {
		$idUser = $USER->GetID();
		$rsUser = CUser::GetByID($idUser);
		$arUser = $rsUser->Fetch();
		$arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
		if (in_array($id, $arElements)) {
			return true;
		}
	}
	return false;
}

function getHLBTByXML($xml, $id)
{
	CModule::IncludeModule('highloadblock');
	$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($id)->fetch();
	$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
	$hlDataClass = $hldata["NAME"] . "Table";
	$resultVal = '';
	$result = $hlDataClass::getList(array(
		"select" => array("UF_NAME"),
		"order" => array(),
		"filter" => array("UF_XML_ID" => $xml),
	));

	while ($res = $result->fetch()) {
		$resultVal = $res["UF_NAME"];
	}
	return $resultVal;
}

function existProductWithName($name, $iblockID)
{
	$arSelect = array("ID", "IBLOCK_ID", "NAME"); //IBLOCK_ID и ID обязательно должны быть указаны
	$arFilter = array("IBLOCK_ID" => IntVal($iblockID), 'NAME' => $name);
	$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		if ($arFields['ID'] > 0) {
			return $arFields['ID'];
		}
	}

	return 0;
}

function existProductWithProp($prop, $value, $iblockID)
{
	$arSelect = array("ID", "IBLOCK_ID", "NAME"); //IBLOCK_ID и ID обязательно должны быть указаны
	$arFilter = array("IBLOCK_ID" => IntVal($iblockID), 'PROPERTY_' . $prop => $value);
	$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		if ($arFields['ID'] > 0) {
			return $arFields['ID'];
		}
	}

	return 0;
}

function getElementIDByName($name, $iblockID)
{
	$arSelect = array("ID", "IBLOCK_ID", "NAME"); //IBLOCK_ID и ID обязательно должны быть указаны
	$arFilter = array("IBLOCK_ID" => IntVal($iblockID), 'NAME' => $name);
	$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		if ($arFields['ID'] > 0) {
			return $arFields['ID'];
		}
	}

	return 0;
}

function checkExistFileAndGetExtension($path, $searchArray, $productID)
{
	$fileName = '';
	foreach ($searchArray as $filePath) {
		$fileName = $path . $filePath . $productID;
		if (file_exists($fileName . '.jpg')) {
			return ['exists' => true, 'type' => '.jpg', 'find_in' => $filePath, 'position' => $filePath . $productID . '.jpg', 'name' => $fileName . '.jpg'];
		} elseif (file_exists($fileName . '.JPG')) {
			return ['exists' => true, 'type' => '.JPG', 'find_in' => $filePath, 'position' => $filePath . $productID . '.JPG', 'name' => $fileName . '.JPG'];
		}
	}
	return ['exists' => false, 'type' => 'none'];
}

function AddOrderProperty($prop_id, $value, $order)
{
	if (!strlen($prop_id)) {
		return false;
	}
	if (CModule::IncludeModule('sale')) {
		if ($arOrderProps = CSaleOrderProps::GetByID($prop_id)) {
			$db_vals = CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $order, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
			if ($arVals = $db_vals->Fetch()) {
				return CSaleOrderPropsValue::Update($arVals['ID'], array(
					'NAME' => $arVals['NAME'],
					'CODE' => $arVals['CODE'],
					'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
					'ORDER_ID' => $arVals['ORDER_ID'],
					'VALUE' => $value,
				));
			} else {
				return CSaleOrderPropsValue::Add(array(
					'NAME' => $arOrderProps['NAME'],
					'CODE' => $arOrderProps['CODE'],
					'ORDER_PROPS_ID' => $arOrderProps['ID'],
					'ORDER_ID' => $order,
					'VALUE' => $value,
				));
			}
		}
	}
}

function IsExistOffersMy($intProductID, $intIBlockID = 0)
{

	$intCount = CIBlockElement::GetList(
		array(),
		array('IBLOCK_ID' => $intIBlockID, '=PROPERTY_CML2_LINK' => $intProductID, 'ACTIVE' => 'Y'),
		array()
	);

	return ($intCount > 0);
}

function getProductDataForB24($productID)
{
	//    $productID = 88042;
	$shopsList = [
		"18" => "18: Ефимова 3",
		"19" => "19: 1-я Красноармейская, 1",
		"25" => "25: Гипермаркет «О'КЕЙ», ул. Партизана Германа, 2",
		"КУ010" => "КУ010: Гипермаркет О'КЕЙ, пр. Большевиков, 10/1",

		"24" => "24: Большевиков",
		"9" => "9: Комендантский 16",
		"8" => "8: Фаберже 8",
		"13" => "13: СМ_Ленинский 118",
		"ЮС082" => "ЮС082: Богатырский 13",
		"ЮС083" => "ЮС083: пр. Московский, 195",
		"ЮС093" => "ЮС093: Михайловская, 1/7 (Отель Европа))",
		"000000002" => "000000002: Фаберже, д.8 (Зал 1)_ЗК",
		"ЮС097" => "ЮС097: Фаберже 8 (RS Home)",
		'ЮС104' => "ЮС104: Энгельса пр., д.134, к.3, лит.А",
		'27' => "27: ТК Невский центр"
	];
	$productResult = CCatalogProduct::GetByID($productID);
	if ($productResult['TYPE'] == 4) { //Торговое предложение
		$returnData = [];
		$returnData['NAME'] = CIBlockElement::GetByID(CCatalogSku::GetProductInfo($productID, 6)['ID'])->GetNext()['NAME'];
		$productRes = CIBlockElement::GetList(array(), ['IBLOCK_ID' => 6, 'ID' => $productID], false, array("nPageSize" => 1), ['IBLOCK_ID', 'ID']);
		while ($ob = $productRes->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();

			if ($arProps['CML2_LINK']['VALUE']) {
				$iElement = CIBlockElement::GetByID($arProps['CML2_LINK']['VALUE']);
				while ($obIElement = $iElement->GetNextElement()) {
					$iArFields = $obIElement->GetFields();
					$iArProps = $obIElement->GetProperties();
					$returnData['MAIN_PRODUCT_ID'] = $iArProps['MAIN_PRODUCT_ID']['VALUE'];
				}
			}
			$returnData['ID'] = $arFields['ID'];
			$returnData['PRODUCT_ID'] = $productID;
			$returnData['SHOP'] = $shopsList[$arProps['SERIES_AVAILABLE_ROZ_SHOP']['VALUE']];
			$returnData['SIZE'] = str_replace('28-', '', $arProps['SERIES_RING_SIZE']['VALUE']);
			$returnData['VSTAVKA'] = $arProps['SERIES_INSERT']['VALUE'][0];
			$returnData['WEIGHT'] = str_replace('23-', '', $arProps['SERIES_WEIGHT']['VALUE']);
			$returnData['PRICE'] = CCatalogProduct::GetOptimalPrice($productID, 1, [2], 'N', [], 's1')['DISCOUNT_PRICE'];
			$returnData['ARTICLE'] = explode('_', $arProps['SERIES_ID_PROPERTY']['VALUE'])[0];
		}
	} else { //SIMPLE PRODUCT
		$returnData = [];
		$productRes = CIBlockElement::GetList(array(), ['IBLOCK_ID' => 5, 'ID' => $productID], false, array("nPageSize" => 1), ['IBLOCK_ID', 'ID', 'NAME']);
		while ($ob = $productRes->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();

			$returnData['MAIN_PRODUCT_ID'] = $arProps['MAIN_PRODUCT_ID']['VALUE'];
			$returnData['NAME'] = $arFields['NAME'];
			$returnData['PRODUCT_ID'] = $productID;
			$returnData['ID'] = $arFields['ID'];
			$returnData['PRICE'] = CCatalogProduct::GetOptimalPrice($productID, 1, [2], 'N', [], 's1')['DISCOUNT_PRICE'];
			$returnData['ARTICLE'] = $arProps['ARTICLE']['VALUE'];
		}
	}
	return $returnData;
}

function createLead($fields)
{
	$phone = preg_replace("/[^0-9]/", '', $fields['PHONE']);

	$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.list';
	$queryData = http_build_query(array(
		'order' => ["DATE_CREATE" => "ASC"],
		'filter' => ["PHONE" => $phone],
		'select' => ["ID", "NAME", "LAST_NAME", "PHONE"],
	));
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));
	$result = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($result, 1);
	$contactID = $result['result'][0]['ID'];
	$contactArray = explode(' ', $fields['CONTACT_NAME']);
	if ($result['total'] == 0) {
		$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.add';
		AddMessage2Log('$contactArray');
		AddMessage2Log($contactArray);
		$queryData = http_build_query(array(
			'fields' => [
				'LAST_NAME' => $contactArray[0] ? $contactArray[0] : 'Неизвестно',
				'NAME' => $contactArray[1] ? $contactArray[1] : 'Неизвестно',
				'SECOND_NAME' => $contactArray[2] ? $contactArray[2] : 'Неизвестно',
				'PHONE' => [['VALUE' => $phone, "VALUE_TYPE" => "WORK"]],
			],
		));
		// обращаемся к Битрикс24 при помощи функции curl_exec
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $queryUrl,
			CURLOPT_POSTFIELDS => $queryData,
		));
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result, 1);
		$contactID = $result['result'];
	} elseif ($fields['CONTACT_NAME']) {
		$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.update';
		AddMessage2Log('$contactArray');
		AddMessage2Log($contactArray);
		$queryData = http_build_query(array(
			'id' => $contactID,
			'fields' => [
				'LAST_NAME' => $contactArray[0] ? $contactArray[0] : 'Неизвестно',
				'NAME' => $contactArray[1] ? $contactArray[1] : 'Неизвестно',
				'SECOND_NAME' => $contactArray[2] ? $contactArray[2] : 'Неизвестно',
				'PHONE' => [['VALUE' => $phone, "VALUE_TYPE" => "WORK"]],
			],
			'params' => [
				"REGISTER_SONET_EVENT" => "Y"
			],
		));
		// обращаемся к Битрикс24 при помощи функции curl_exec
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $queryUrl,
			CURLOPT_POSTFIELDS => $queryData,
		));
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result, 1);
	}

	$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.deal.add';
	$queryData = http_build_query(array(
		'fields' => array(
			'CATEGORY_ID' => 0, //19
			'CONTACT_ID' => $contactID,
			'TITLE' => $fields['TITLE'],
			'ORIGIN_ID' => $fields['ORIGIN_ID'],
			'UF_CRM_1646930650638' => $fields['PROMOCODE'],
			'UF_CRM_AMO_675085' => $fields['CITY'],
			"UF_CRM_AMO_66331" => $fields['ARTICLE'],
			"UF_CRM_1645997216619" => $fields['DELIVERY'],
			"UF_CRM_1648464335407" => $fields['STREET'],
			"UF_CRM_1648464363486" => $fields['HOUSE'],
			"UF_CRM_1648464382259" => $fields['APARTMENT'],
			"UF_CRM_1649259694405" => $fields['PVZ'],
			"UF_CRM_AMO_66279" => $fields['DELIVERY_PRICE'],
			"UF_CRM_1653990805475" => $fields['PAYMENT_ID'] == 11 ? '211' : '',
			"UF_CRM_1645997294806" => $fields['PAYMENT_ID'] == 11 ? '209' : '207',
			"COMMENTS" => $fields['COMMENTS'],
			"UTM_SOURCE" => $_COOKIE['utm_source'],
			"UF_CRM_1639332211110" => $_COOKIE['utm_source'],
			"UTM_MEDIUM" => $_COOKIE['utm_medium'],
			"UF_CRM_1639332227599" => $_COOKIE['utm_medium'],
			"UTM_CAMPAIGN" => $_COOKIE['utm_campaign'],
			"UF_CRM_1639332246157" => $_COOKIE['utm_campaign'],
			"UTM_CONTENT" => $_COOKIE['utm_content'],
			"UF_CRM_1639332277299" => $_COOKIE['utm_content'],
			"UTM_TERM" => $_COOKIE['utm_term'],
			"UF_CRM_1639332261958" => $_COOKIE['utm_term'],
		),
		'params' => array("REGISTER_SONET_EVENT" => "Y")
	));
	AddMessage2Log(
		[
			"UTM_SOURCE" => $_COOKIE['utm_source'],
			"UF_CRM_1639332211110" => $_COOKIE['utm_source'],
			"UTM_MEDIUM" => $_COOKIE['utm_medium'],
			"UF_CRM_1639332227599" => $_COOKIE['utm_medium'],
			"UTM_CAMPAIGN" => $_COOKIE['utm_campaign'],
			"UF_CRM_1639332246157" => $_COOKIE['utm_campaign'],
			"UTM_CONTENT" => $_COOKIE['utm_content'],
			"UF_CRM_1639332277299" => $_COOKIE['utm_content'],
			"UTM_TERM" => $_COOKIE['utm_term'],
			"UF_CRM_1639332261958" => $_COOKIE['utm_term']
		]
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));
	$result = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($result, 1);

	$dealID = $result['result'];

	$curProduct = [];
	$foundedProductArray = [];
	foreach ($fields['PRODUCTS_ID'] as $product) {
		$curProduct = getProductDataForB24($product);
		$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.product.list';
		$queryData = http_build_query(array(
			'order' => ["NAME" => "ASC"],
			'filter' => ["XML_ID" => $curProduct['PRODUCT_ID']],
			'select' => ["ID", "NAME"],
		));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $queryUrl,
			CURLOPT_POSTFIELDS => $queryData,
		));
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result, 1);
		$foundedProduct = $result['result'][0]['ID'];
		if ($foundedProduct) {
			$foundedProductArray[] = ['PRODUCT_ID' => $foundedProduct, 'PRICE' => $curProduct['PRICE'], 'QUANTITY' => 1];
		}else{
			$db_res = CCatalogProduct::GetList(
					array("QUANTITY" => "DESC"),
					array('ID' => $product),
					false,
					array('ID')
				);
				
			$ar_res = $db_res->fetch();
			if($ar_res):
				$rsElement = CIBlockElement::GetList(
					$arOrder  = array("SORT" => "ASC"),
					$arFilter = array(
						"ID" => $product,
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
				
				$webhookURL = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/';
				$bx24 = new \App\Bitrix24\Bitrix24API($webhookURL);
				$bx24->addProduct([
					"PRODUCT_NAME" => $element['NAME'].' '.$ar_res['ELEMENT_NAME'],
					"NAME"        => $element['NAME'].' '.$ar_res['ELEMENT_NAME'],
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
					'PROPERTY_115' => $props['SERIES_FULL_NAME']['VALUE']
				]);
				$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.product.list';
				$queryData = http_build_query(array(
					'order' => ["NAME" => "ASC"],
					'filter' => ["XML_ID" => $curProduct['PRODUCT_ID']],
					'select' => ["ID", "NAME"],
				));
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_POST => 1,
					CURLOPT_HEADER => 0,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => $queryUrl,
					CURLOPT_POSTFIELDS => $queryData,
				));
				$result = curl_exec($curl);
				curl_close($curl);
				$result = json_decode($result, 1);
				$foundedProduct = $result['result'][0]['ID'];
				if ($foundedProduct) {
					$foundedProductArray[] = ['PRODUCT_ID' => $foundedProduct, 'PRICE' => $curProduct['PRICE'], 'QUANTITY' => 1];
				}
			endif;
		}
	}

	$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.deal.productrows.set';
	$queryData = http_build_query(array(
		'id' => $dealID,
		'rows' => $foundedProductArray,
	));
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));
	$result = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($result, 1);

	return $dealID;
}

function parseStr($string, $elementID)
{
	$result = [];
	if (strpos($string, ' ') !== false) {
		$insertsArray = explode(', ', $string);

		foreach ($insertsArray as $key => $insert) {
			$insert = ToLower($insert);
			$parsedInsertData = [];
			if (!intval($insert, 10)) continue;

			$parsedInsertData['FROM'] = $insert;
			$parsedInsertData['COUNT'] = intval($insert, 10);

			//GET MATERIAL (Материал)
			$matches = [];
			$arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_MATERIAL");
			$arFilter = array("IBLOCK_ID" => 13, "SECTION_ID" => 1528, "ACTIVE" => "Y");
			$res = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
			while ($ob = $res->GetNextElement()) {
				$arFields = $ob->GetFields();
				//$arProps = $ob->GetProperties();
				$arFields['NAME'] = ToLower($arFields['NAME']);
				$preg_matchString = "/{$arFields['NAME']}/ui";
				if (preg_match($preg_matchString, $insert, $matches)) {
					$parsedInsertData['MATERIAL'] = $arFields['PROPERTY_MATERIAL_VALUE'];
					break;
				}
			}

			//GET CUTTING (Огранка)
			$matches = [];
			$arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_CUTTING");
			$arFilter = array("IBLOCK_ID" => 13, "SECTION_ID" => 1529, "ACTIVE" => "Y");
			$res = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
			while ($ob = $res->GetNextElement()) {
				$arFields = $ob->GetFields();
				//$arProps = $ob->GetProperties();
				$elementNewName = str_replace('/', '\/', $arFields['NAME']);
				$preg_matchString = "/{$elementNewName}/ui";
				if (preg_match($preg_matchString, $insert, $matches)) {
					$parsedInsertData['CUTTING'] = $arFields['PROPERTY_CUTTING_VALUE'];
					break;
				}
			}

			//INSERT COLOR (цвет камня) INSERT PURITY (чистота камня)
			if (preg_match("/([0-9])_([0-9])/", str_replace('/', '_', $insert), $matches)) {
				if ($matches[1]) {
					$parsedInsertData['INSERT_COLOR'] = $matches[1];
				}
				if ($matches[2]) {
					$parsedInsertData['INSERT_PURITY'] = $matches[2];
				}
			}


			//Цвет
			global $colorMatchToInsert;
			$foundColor = false;
			foreach ($colorMatchToInsert as $colorInsertKey => $colorInsert) {
				foreach ($colorInsert as $colorKey => $color) {
					if (strpos($insert, $color) !== false) {
						$result['color'][] = Cutil::translit($colorInsertKey, "ru", array("replace_space" => "-", "replace_other" => "-"));
						$foundColor = true;
						break;
					}
				}
				if ($foundColor) break;
			}
			if (!$foundColor) $result['color'][] = 'no-color';

			//CRT
			if (preg_match("/([0-9]{1,3})\.([0-9]{3})|([0-9]{1,3}),([0-9]{3})/", str_replace('/', '_', $insert), $matches)) {
				$parsedInsertData['CRT'] = $matches[0];
			}

			/* if(!$parsedInsertData['CRT']){
				if(preg_match("/([0-9][0-9])\.([0-9][0-9][0-9])/",str_replace('/','_',$insert),$matches)){
					$parsedInsertData['CRT'] = $matches[0];
				}
			}
            if(!$parsedInsertData['CRT']){
				if(preg_match("/([0-9])\.([0-9][0-9][0-9])/",str_replace('/','_',$insert),$matches)){
					$parsedInsertData['CRT'] = $matches[0];
				}
			}
            if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9])\.([0-9][0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            }
            if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9])\.([0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            }if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9][0-9]),([0-9][0-9][0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            }
            if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9]),([0-9][0-9][0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            }
            if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9]),([0-9][0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            }
            if(!$parsedInsertData['CRT']){
                if(preg_match("/([0-9]),([0-9])/",str_replace('/','_',$insert),$matches)){
                    $parsedInsertData['CRT'] = $matches[0];
                }
            } */

			$errorString = '';
			if ($parsedInsertData['MATERIAL'] && $parsedInsertData['COUNT']) {
				$result['MATERIAL'][] = 'id-' . Cutil::translit($parsedInsertData['MATERIAL'], "ru", array("replace_space" => "-", "replace_other" => "-"));
				$finalString = $parsedInsertData['MATERIAL'] . ' - ' . $parsedInsertData['COUNT'];
				if ($parsedInsertData['CUTTING']) {
					$finalString .= ', ' . $parsedInsertData['CUTTING'];
				} else {
					$errorString .= 'Нету огранки ';
				}
				if ($parsedInsertData['INSERT_COLOR']) {
					$finalString .= ', цвет камня ' . $parsedInsertData['INSERT_COLOR'];
				} else {
					$errorString .= 'Нету цвет камня ';
				}
				if ($parsedInsertData['INSERT_PURITY']) {
					$finalString .= ', чистота камня ' . $parsedInsertData['INSERT_PURITY'];
				} else {
					$errorString .= 'Нету чистота камня ';
				}
				if ($parsedInsertData['CRT']) {
					$finalString .= ', ' . $parsedInsertData['CRT'] . ' crt';
				} else {
					$errorString .= 'Нету crt ';
				}

				if ($finalString) {
					$result['result'][$key] = $finalString;
				}
				if (!$parsedInsertData['CUTTING'] || !$parsedInsertData['CRT']) {
					$result['error'][$key] = '[' . $insert . ']: ' . $errorString;
					writeToLogs('ELEMENT_ID[' . $elementID . '] INSERT ERROR [' . $insert . ']: ' . $errorString, 'parser_ERROR', '/logs/Parse/');
				} else {
					$result['error'][$key] = 'Good!';
				}
			} else {
				$result['result'][$key] = 'Не найден материал!';
				$result['error'][$key] = '[' . $insert . ']: Не найден материал!';
				writeToLogs('ELEMENT_ID[' . $elementID . '] INSERT ERROR [' . $insert . ']: Не найден материал!', 'parser_ERROR', '/logs/Parse/');
			}
		}
	}
	return $result;
}

function fromSmartPathToFilter($smartString)
{
	$arraySmartFilter = explode('/', $smartString);
	$preFilterMArray = [];
	foreach ($arraySmartFilter as $filter) {
		$startPart = explode('-is-', $filter)[0];
		$endPart = explode('-or-', explode('-is-', $filter)[1]);
		$preFilterMArray['=PROPERTY_' . strtoupper($startPart)] = $endPart;
	}
	return $preFilterMArray;
}

function deleteEmptyPrices() {
	$arSelect = Array("NAME", "ID", "XML_ID",  "DETAIL_PAGE_URL", "PROPERTY_SUB_TITLE", "CATALOG_GROUP_2");
	$arFilter = Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "CATALOG_PRICE_1"=>0);
	$res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
	while ($element = $res->GetNext()) {
		$arResult["ELEMENTS"][] = $element;
		$price = CPrice::GetBasePrice($element["ID"]);
		if($price["PRICE"] == '0.00') {
			// CPrice::Delete($price["ID"]);
			CPrice::SetBasePrice($element["ID"],99999999999999,"RUB");
		}
	}
}

function setSimilarProductsByID($elementID) {
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5,"ID"=>$elementID), false, Array("nPageSize"=>1), Array("ID", "IBLOCK_ID", "NAME","PROPERTY_RELATED_ARTICUL_NEW","PROPERTY_ARTICLE"));
	if($ob = $res->GetNextElement()){ 
		$baseElement = $ob->GetFields();  
	}
	$baseArticle = $baseElement["PROPERTY_ARTICLE_VALUE"];
	// $elementsToUpdate = preg_replace('/\s+/', '', explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']));
	$elementsToUpdate = explode(",", $baseElement['PROPERTY_RELATED_ARTICUL_NEW_VALUE']);
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
		$updateString = implode(",",$similar);
		CIBlockElement::SetPropertyValuesEx($element["ID"], false, array("RELATED_ARTICUL_NEW"=> $updateString));
	}
}

// deactivateCollectionsByProductID3($productID) {
	
// }

function renewCatalogElements($elements,$page) {
	$res = CIBlockElement::GetList(
		array('ID' => 'ASC'),
		array('IBLOCK_ID' => 5,),
		false,
		['nPageSize' => $elements,'iNumPage' => $page]
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

function deactivateCollectionsByProductID($PRODUCT_ID) {
	$offers = CCatalogSKU::getOffersList($PRODUCT_ID);
	foreach ($offers[$PRODUCT_ID] as $id => $offer) {
		$el = new CIBlockElement;
		$el->Update($id, ['ACTIVE'=>'N']);
		// writeToLogs('Товар: '.$PRODUCT_ID.' ---- Деактивирован SKU: "' . $id.'"','ControlProduct','/logs/ControlProduct/');
	}
}

function deactivateGoodsFromList() {
	$disableElementRes = CIBlockElement::GetList([], ['IBLOCK_ID' => 19, 'ACTIVE' => 'Y'], false, false, ['PREVIEW_TEXT']); 
	if ($disableElement = $disableElementRes->GetNextElement()) {
		$disableElementFields = $disableElement->GetFields();
		$strings = preg_split('/\r\n|\r|\n/', $disableElementFields['PREVIEW_TEXT']);
		foreach($strings as $num => $str) {
			$value = intval($str);
			if($value>0) {
				$el = new CIBlockElement;
				$el->Update($value, array('ACTIVE' => 'N'));
				writeToLogs('Деактивирован элемент с ID:'.$value,'ControlProduct','/logs/ControlProduct/');
			}
		}
	} else {
		writeToLogs('Нет элемента со списком элементов для деактивации','ControlProduct','/logs/ControlProduct/');
	}
}


include_once "functionsB24Useful.php";
