<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


$APPLICATION->IncludeComponent(
    "itd:search.page",
    "header-search-ajax",
    array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => "header-search",
        "DEFAULT_SORT" => "rank",
        "PAGE_RESULT_COUNT" => "100",
        "arrFILTER" => array('iblock_catalog'),
        "SHOW_WHERE" => "Y",
    )
);