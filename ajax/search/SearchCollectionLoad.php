<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

CModule::IncludeModuleEx('search');
$moduleIncludeResult = CModule::IncludeModuleEx('itd.search');
$obSearch = new CSearch;
$searchResult = [];
$queries = explode(' ', $_REQUEST['q']);
foreach ($queries as $query) {
    $obSearch->Search(array(
        'QUERY' => $query,
        'SITE_ID' => LANG,
        'MODULE_ID' => 'iblock',
    ));

    while ($arSearch = $obSearch->Fetch()) {
        $searchResult[] = $arSearch;
    }
}

//if (!empty($searchResult['sections'])) {
//    $list = CIBlockSection::GetList(
//        [],
//        [
//            'ACTIVE' => 'Y',
//            'GLOBAL_ACTIVE' => 'Y',
//            'IBLOCK_ID' => [5],
//            'ID' => $searchResult['sections']
//        ],
//        false,
//        ['ID', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL', 'TAGS', 'TIMESTAMP_X', 'DESCRIPTION']
//    );
//    $tmp = [];
//    while ($item = $list->GetNext(true, false)) {
//        $tmp[(int)$item['ID']] = [
//            'DATE_CHANGE' => $item['TIMESTAMP_X'],
//            "TITLE_FORMATED" => $item["NAME"],
//            "BODY_FORMATED" => $item["DESCRIPTION"],
//            "URL" => htmlspecialcharsbx($item["SECTION_PAGE_URL"]),
//            "MODULE_ID" => 'iblock',
//            "PARAM1" => '',
//            "PARAM2" => (int)$item['IBLOCK_ID'],
//            "ITEM_ID" => 'S' . $item["ID"],
//        ];
//    }
//}

$arResult['CUSTOM_SEARCH']['COLLECTIONS'] = [];

$collectionsTitle = [];
foreach ($searchResult as $row) {
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
?>

<? foreach ($arResult['CUSTOM_SEARCH']['COLLECTIONS'] as $collection) : ?>
    <li class="search-result__item search-result__item_collection">
        <svg class="search-result__svg" width="24" height="24" fill="transparent">
            <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"></use>
        </svg>
        <a class="search-result__link search-result__link_tt search-result__link_block"
           href="<?= $collection['URL'] ?>">
            <span class="search-result__collection"><?= $collection['NAME'] ?></span>
            КОЛЛЕКЦИЯ</a>
    </li>
<? endforeach; ?>


<?php
die();
?>
