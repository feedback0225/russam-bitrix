<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__) . '/..');

ini_set('max_execution_time', '600');
set_time_limit('600');

define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
define('NOT_CHECK_PERMISSIONS', true);

require($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

$arSelect = array("ID", "NAME", "TIMESTAMP_X", "IBLOCK_ID", "TYPE", "PRICE_1", "PROPERTY_ROUND_PRICE");
$arFilter = array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "AVAILABLE" => "Y", ">TIMESTAMP_X" => ConvertTimeStamp(time() - 3600, "FULL"));  // измененные за 1час
$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 5000), $arSelect);
while ($ob = $res->Fetch()) {
	$listProducts[$ob['ID']] = $ob;
}
//log
writeToLogs(date('d.m.Y H:i:s'), 'round', '/api/logs/');
writeToLogs(count($listProducts), 'round', '/api/logs/');

if (!empty($listProducts)) {
	foreach ($listProducts as $id => $value) {
		$type = $value['TYPE']; //тип товара
		$arPrice = array();
		switch ($type) {
			case 3: //товар с ТП
				$offers = CCatalogSKU::getOffersList($id, 0, array("ACTIVE" => "Y", ">PRICE_1" => 1), array("PRICE_1"));
				$sku = $offers[$id];
				$optimalPrice = CCatalogProduct::GetOptimalPrice($id, 1, [2], 'N');
				$discountValue = ($optimalPrice['RESULT_PRICE']['PERCENT'] > 0) ? floatval($optimalPrice['RESULT_PRICE']['PERCENT']) : 0;

				foreach ($sku as $i => $p) {
					$arPrice[$i] = $p['PRICE_1'];
				}

				//если есть скидка
				if ($discountValue > 0 && !empty($arPrice)) {
					setDiscount($arPrice, $discountValue);
				}

				//получаем среднею 
				if (!empty($arPrice)) {
					$roundPrice = getCalcRound($arPrice);
				}

				$listProducts[$id]['ROUND'] = floatval($roundPrice);
				$listProducts[$id]['DISCOUNT'] = $discountValue;

				break;

			default: //простой
				$price = CCatalogProduct::GetOptimalPrice($id, 1, [2], 'N');
				$listProducts[$id]['ROUND'] = ($price['RESULT_PRICE']['DISCOUNT_PRICE']) ? floatval($price['RESULT_PRICE']['DISCOUNT_PRICE']) : floatval($price['RESULT_PRICE']['BASE_PRICE']);
				$listProducts[$id]['DISCOUNT'] = $price['RESULT_PRICE']['PERCENT'];
				break;
		}
	}

	foreach ($listProducts as $id => $value) {
		$optimal = ($value['ROUND'] > 0) ? intval($value['ROUND']) : null;
		CIBlockElement::SetPropertyValuesEx($id, 5, array("ROUND_PRICE" => $optimal));
		echo "\n\rSet price " . $optimal . " ID: " . $id;
	}
}


function getCalcRound($arPrice)
{
	if (count($arPrice) > 1) {
		$p = 0;
		$arithmetic = 0;
		foreach ($arPrice as $value) {
			$p += $value;
		}
		$arithmetic = intval($p / count($arPrice));
		$round = array_reduce($arPrice, function ($carry, $item) use ($arithmetic) {
			return $item <= $arithmetic ? max($carry, $item) : $carry;
		});
	} else {
		$round = current($arPrice);
	}

	return $round;
}

function setDiscount(&$arPrice, $percent)
{
	foreach ($arPrice as $k => &$value) {
		$diff = intval(($percent / 100) * $value);
		$value = $value - $diff;
	}
}
