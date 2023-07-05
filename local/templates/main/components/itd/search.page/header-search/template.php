<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

if ($_REQUEST['ajax'] == 'Y' && $_REQUEST['block'] == 'header_search') {
    $APPLICATION->restartBuffer();
}
?>

   <div class="search-form header__search-form">
        <button class="btn-reset search-toggle toggle-form" type="button">
            <svg width="24" height="24">
                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"
                     fill="transparent"></use>
            </svg>
        </button>
        <form class="search-form__form js-search-header-from" action="">
            <button class="btn-reset search-toggle__close toggle-form" type="button">
                <svg width="24" height="24">
                    <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#cross2"></use>
                </svg>
            </button>
            <input class="search-form__input js-header-search" type="search" name="q" autocomplete="off" placeholder="Поиск"/>
            <button class="btn-reset search-form__btn">
                <svg class="svg-icon search-icon">
                    <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"></use>
                </svg>
            </button>
            <button class="btn-reset search-form__mobile-submit btn-reset g-btn g-btn--black"
                    type="submit">
                найти
            </button>
            <button class="btn-reset search-form__close" type="button">
                <svg class="svg-icon cross2">
                    <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#cross2"></use>
                </svg>
            </button>
        </form>
        <div class="search-result">
            <div class="search-result__wrapper">
                <ul class="search-result__list list-reset" data-simplebar="data-simplebar">
                    <? foreach ($arResult['CUSTOM_SEARCH']['SUGGEST'] as $suggest): ?>
                        <li class="search-result__item">
                            <svg class="search-result__svg" width="24" height="24" fill="transparent">
                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"></use>
                            </svg>
                            <a class="search-result__link" href="<?= $suggest['LINK'] ?>">
                                <?= $suggest['TITLE'] ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
            <ul class="search-result__list list-reset search-result__list_collection js-search-collection"
                data-simplebar="data-simplebar">
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
            </ul>
            <?
            if (!empty($arResult['CUSTOM_SEARCH']['ITEMS_ID'])) {
                $db_list = CIBlockElement::GetList(
                    ['ID' => $arResult['CUSTOM_SEARCH']['ITEMS_ID']],
                    [
                        'ACTIVE' => 'Y',
                        'IBLOCK_ID' => [5],
                        'ID' => $arResult['CUSTOM_SEARCH']['ITEMS_ID'],
                        [
                            'LOGIC' => 'OR',
                            [
                                'SECTION_ID' => false
                            ],
                            [
                                'SECTION_GLOBAL_ACTIVE' => 'Y',
                                'SECTION_SCOPE' => 'IBLOCK',
                            ]
                        ]
                    ],
                    false,
                    false,
                    ['ID', 'TIMESTAMP_X', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'TAGS', 'PREVIEW_TEXT']
                );
                $resultIds = [];
                $arResult["SEARCH"] = array();

                $db_list->NavStart(5, false);
                while ($item = $db_list->GetNext()) {
                    $resultIds[] = $item["ID"];
                    $arReturn[] = $item["ID"];
                    $arResult["SEARCH"][] = [
                        'DATE_CHANGE' => $item['TIMESTAMP_X'],
                        "TITLE_FORMATED" => $item["NAME"],
                        "BODY_FORMATED" => $item["PREVIEW_TEXT"],
                        "URL" => htmlspecialcharsbx($item["DETAIL_PAGE_URL"]),
                        "MODULE_ID" => 'iblock',
                        "PARAM1" => '',
                        "PARAM2" => (int)$item['IBLOCK_ID'],
                        "ITEM_ID" => $item["ID"],
                        'TAGS' => array_map(
                            function ($tag) {
                                global $APPLICATION;
                                return [
                                    "URL" => $APPLICATION->GetCurPageParam("tags=" . urlencode($tag), ["tags"]),
                                    "TAG_NAME" => htmlspecialcharsex($tag),
                                ];
                            },
                            array_filter(preg_split("/[\s,]+/u", $item['TAGS']))
                        )
                    ];
                }

                $navComponentObject = null;
                $arResult["NAV_STRING"] = $db_list->GetPageNavStringEx($navComponentObject, 'Результаты поиска', 'pagination', 'Y');
                $arResult["NAV_RESULT"] = $db_list;

                global $searchFilter;
                $searchFilter[] = array(
                    "LOGIC" => "OR",
                    array("=ID" => $resultIds),
                    array("%PROPERTY_ARTICLE" => $_GET['search'])
                );
            }
            ?>
            <div class="js-search-result-items">
                <? if (!empty($arResult['CUSTOM_SEARCH']['ITEMS_ID'])) : ?>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "catalog_section_search_header",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "-",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/login/basket.php",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "Y",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "3600",
                            "CACHE_TYPE" => "A",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => $_GET["sort"] ? $_GET["sort"] : "PROPERTY_NEW",
                            "ELEMENT_SORT_ORDER" => $_GET["order"] ? $_GET["order"] : "desc",
                            "ELEMENT_SORT_FIELD2" => "sort",
                            "ELEMENT_SORT_ORDER2" => "asc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "searchFilter",
                            "HIDE_NOT_AVAILABLE" => "L",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => "5",
                            "IBLOCK_TYPE" => "catalog",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array(),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "3",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать еще",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_FIELD_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "OFFERS_LIMIT" => "100",
                            "OFFERS_SORT_FIELD" => "SCALED_PRICE_1",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_FIELD2" => "name",
                            "OFFERS_SORT_ORDER2" => "asc",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "pagination",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "36",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_CODE_PATH" => "",
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "UF_SECTION_DESCRIPTION",
                                1 => "UF_BANNER_LINK",
                                2 => "UF_SECTIONS_TO_SHOW",
                                3 => "UF_BANNER",
                                4 => "UF_HEADER_SECTIONS",
                                5 => "UF_COLLECTION_PC_IMG",
                                6 => "UF_LEFT_SECTIONS_LIST",
                                7 => "UF_COLLECTION_MOB_IMG",
                                8 => "UF_RIGHT_SECTIONS_TITLE",
                                9 => "UF_COLLECTION_TYPE_SHOW",
                                10 => "UF_RIGHT_SECTIONS_LIST",
                                11 => "UF_COLLECTION_IMAGES",
                                12 => "",
                            ),
                            "SEF_MODE" => "N",
                            "SEF_RULE" => "",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "Y",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N",
                            "COMPONENT_TEMPLATE" => "catalog_section",
                            "PROPERTY_CODE_MOBILE" => array()
                        ),
                    ); ?>
                <? endif; ?>
            </div>
        </div>
    </div>
<?php
if ($_REQUEST['ajax'] == 'Y' && $_REQUEST['block'] == 'header_search') {
    die();
}
?>