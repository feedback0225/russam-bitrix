<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>
<?php
$moduleIncludeResult = CModule::IncludeModuleEx('itd.search');
$searchResult = \ITD\Search\Index::findIdsNotExact($_REQUEST['q'], [5], SITE_ID, (int)100);

if (!empty($searchResult['sections'])) {
    $list = CIBlockSection::GetList(
        [],
        [
            'ACTIVE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y',
            'IBLOCK_ID' => [5],
            'ID' => $searchResult['sections']
        ],
        false,
        ['ID', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL', 'TAGS', 'TIMESTAMP_X', 'DESCRIPTION']
    );
    $tmp = [];
    while ($item = $list->GetNext(true, false)) {
        $tmp[(int)$item['ID']] = [
            'DATE_CHANGE' => $item['TIMESTAMP_X'],
            "TITLE_FORMATED" => $item["NAME"],
            "BODY_FORMATED" => $item["DESCRIPTION"],
            "URL" => htmlspecialcharsbx($item["SECTION_PAGE_URL"]),
            "MODULE_ID" => 'iblock',
            "PARAM1" => '',
            "PARAM2" => (int)$item['IBLOCK_ID'],
            "ITEM_ID" => 'S' . $item["ID"],
        ];
    }

    echo '<pre>',print_r($tmp),'</pre>';
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>