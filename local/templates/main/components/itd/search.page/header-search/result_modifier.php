<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('search');


if (count($arResult['SEARCH']) > 0) {

    /** Товары для поиска */
    $arResult['CUSTOM_SEARCH']['ITEMS'] = [];

    $items_id = array_column($arResult['SEARCH'], 'ITEM_ID');
    $arResult['CUSTOM_SEARCH']['ITEMS_ID'] = array_chunk($items_id, 5)[0];

    /** Подсказки */
    $arResult['CUSTOM_SEARCH']['SUGGEST'] = [];
    $arSuggest = array_chunk($arResult['SEARCH'], 5);
    $query = mb_strtolower($_REQUEST['q'], 'utf-8');
    foreach ($arSuggest[0] as $suggest) {

        $highlighted = replaceArrayStrings(explode(' ', $query), $suggest['TITLE_FORMATED']);
        $arResult['CUSTOM_SEARCH']['SUGGEST'][] = [
            'TITLE' => $highlighted,
            'LINK' => '/search/?search=' . $suggest['TITLE_FORMATED'],
        ];
    }

    /** Коллекции */
    $obSearch = new CSearch;
    $obSearch->Search(array(//при желании, фильтр можете еще сузить, см.документацию
        'QUERY' => $arResult['REQUEST']['QUERY'],
        'SITE_ID' => SITE_ID,
        'MODULE_ID' => 'iblock',
        'PARAM2' => 5
    ));
    $arResult['CUSTOM_SEARCH']['COLLECTIONS'] = [];
    $collectionsTitle = [];
    while ($row = $obSearch->fetch()) {
        if (strpos($row['URL'], 'kollektsii') !== false && strpos($row['ITEM_ID'], 'S') !== false) {

            if (!in_array($row['TITLE_FORMATED'], $collectionsTitle)) {
                $arResult['CUSTOM_SEARCH']['COLLECTIONS'][] = [
                    'NAME' => $row['TITLE_FORMATED'],
                    'URL' => $row['URL'],
                ];

                $collectionsTitle[] = $row['TITLE_FORMATED'];
            }
        }
    }

    $_GET['search'] = $_REQUEST['q'];
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