<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('search');


if (count($arResult['SEARCH']) > 0) {

    /** Подсказки */
    $arResult['CUSTOM_SEARCH']['SUGGEST'] = [];
    foreach ($arResult['SEARCH'] as $key => $row) {
        if (strpos($row['URL'], 'kollektsii') !== false && strpos($row['ITEM_ID'], 'S') !== false) {
            unset($arResult['SEARCH'][$key]);
        }
    }
    $query = mb_strtolower($_REQUEST['q'], 'utf-8');

    $sortedStrings = sortStringsByMatchCount(array_column($arResult['SEARCH'], 'TITLE_FORMATED'), $query);

    $arSuggest = array_chunk($sortedStrings, 5);

    $wordCount = count(explode(" ", $query));
    $arSuggestEx = [];
    foreach ($sortedStrings as $suggest) {
        $words = explode(" ", $suggest);
        $trimmedWords = array_slice($words, 0, $wordCount + 1);
        $trimmedString = implode(" ", $trimmedWords);
        $cleanString = preg_replace('/[^\pL\s]+/u', '', $trimmedString);
        $highlighted = replaceArrayStrings(explode(' ', $query), $cleanString);
        if (!in_array($cleanString, $arSuggestEx) && count($arSuggestEx) < 5) {
            $arSuggestEx[] = $cleanString;
            $arResult['CUSTOM_SEARCH']['SUGGEST'][] = [
                'TITLE' => $highlighted,
                'LINK' => '/search/?search=' . $cleanString,
            ];
        }
    }

    /** ID товаров */
    $arResult['SEARCH'] = sortObjectsByMatchCount($arResult['SEARCH'], $query);
    $items_id = array_column($arResult['SEARCH'], 'ITEM_ID');
    $items_id = array_chunk($items_id, 15);
    $arResult['CUSTOM_SEARCH']['ITEMS_ID'] = $items_id[0];

}

function compareStrings($a, $b, $target)
{
    $countA = similar_text($a, $target);
    $countB = similar_text($b, $target);

    if ($countA == $countB) {
        return 0;
    }

    return ($countA > $countB) ? -1 : 1;
}

function compareObjects($a, $b, $target)
{
    $countA = similar_text($a['TITLE_FORMATED'], $target);
    $countB = similar_text($b['TITLE_FORMATED'], $target);

    if ($countA == $countB) {
        return 0;
    }

    return ($countA > $countB) ? -1 : 1;
}

function sortObjectsByMatchCount($objects, $target)
{
    usort($objects, function ($a, $b) use ($target) {
        return compareObjects($a, $b, $target);
    });

    return $objects;
}

// Пример использования

$objects = [
    (object)['TITLE_FORMATED' => 'Apple Inc.'],
    (object)['TITLE_FORMATED' => 'Banana Corp'],
    (object)['TITLE_FORMATED' => 'Cherry Co.'],
    (object)['TITLE_FORMATED' => 'Durian Enterprises'],
    (object)['TITLE_FORMATED' => 'Elderberry Ltd.']
];


function sortStringsByMatchCount($strings, $target)
{
    usort($strings, function ($a, $b) use ($target) {
        return compareStrings($a, $b, $target);
    });

    return $strings;
}

function replaceArrayStrings($query, $suggest)
{
    $searchArray = array_map('preg_quote', $query);
    $replaceArray = array_map(function ($str) {
        return '<b>' . $str . '</b>';
    }, $query);

    $result = str_ireplace($searchArray, $replaceArray, mb_strtolower($suggest, 'utf-8'));

    return $result;
}

