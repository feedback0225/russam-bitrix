<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>
    <section class="collections g-filters favoritesPage">
        <div class="container collections__container">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb",
                Array(
                    "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                    "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                    "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                ),
                false
            );?>
            <h1 class="g-title g-title--center catalog__title favorites__title">
                <span><?=$APPLICATION->GetTitle()?></span>
                <span class="catalog__quantity"><?$APPLICATION->ShowViewContent('catalogCount');?> товаров</span>
            </h1>
            <div class="catalog__top">
                <button class="btn-reset g-btn g-btn--stroke filters-toggle filters-toggle--active">
                    <svg class="filters-toggle__icon" width="24" height="24">
                        <use class="filters-toggle__icon-opened" xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#open-filters"></use>
                        <use class="filters-toggle__icon-closed" xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#close-filters"></use>
                    </svg>Фильтры
                    <span class="filters-toggle__quantity"><?$APPLICATION->ShowViewContent('catalogFilterCount');?></span>
                </button>
                <button class="btn-reset favorites__clear g-link" onclick="clearFavorites()">Очистить избранное</button>
                <div class="sort-by favorites__sort-by catalog__sort-by">
                    <button class="btn-reset sort-by__open open-sort-by">сортировка</button><span class="sort-by__caption">Сортировать по:</span>
                    <div class="sort-by__select open-sort-by">
                        <span class="sort-by__current">
                            <?if(($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_NEW' && $_GET['sort_2'] == 'shows') || ($_GET['order'] == '' && $_GET['sort'] == '')) echo 'Популярности';?>
                            <?if($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_NEW' && $_GET['sort_2'] == '') echo 'Новизне'?>
                            <?if($_GET['order'] == 'asc' && $_GET['sort'] == 'SCALED_PRICE_1') echo 'Возрастанию цены'?>
                            <?if($_GET['order'] == 'desc' && $_GET['sort'] == 'SCALED_PRICE_1') echo 'Убыванию цены'?>
                            <?if($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_TOTAL_SALE') echo 'Размеру скидки'?>
                        </span>
                        <div class="sort-by__top">
                            <p class="sort-by__title g-title">Сортировка</p>
                            <button class="btn-reset sort-by__close">
                                <svg class="svg-icon cross2">
                                    <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="sort-by__list list-reset">
                            <a class="sort-by__item <?=(($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_NEW' && $_GET['sort_2'] == 'shows') || ($_GET['order'] == '' && $_GET['sort'] == '')) ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=desc&sort=PROPERTY_NEW&sort_2=shows",array('order','order_2','sort','sort_2'),false)?>">Популярности</a>
                            <a class="sort-by__item <?=($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_NEW' && $_GET['sort_2'] == '') ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=desc&sort=PROPERTY_NEW",array('order','order_2','sort','sort_2'),false)?>">Новизне</a>
                            <a class="sort-by__item <?=($_GET['order'] == 'asc' && $_GET['sort'] == 'SCALED_PRICE_1') ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=asc&sort=SCALED_PRICE_1",array('order','order_2','sort','sort_2'),false)?>">Возрастанию цены</a>
                            <a class="sort-by__item <?=($_GET['order'] == 'desc' && $_GET['sort'] == 'SCALED_PRICE_1') ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=desc&sort=SCALED_PRICE_1",array('order','order_2','sort','sort_2'),false)?>">Убыванию цены</a>
                            <a class="sort-by__item <?=($_GET['order'] == 'desc' && $_GET['sort'] == 'PROPERTY_TOTAL_SALE') ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=desc&sort=PROPERTY_TOTAL_SALE",array('order','order_2','sort','sort_2'),false)?>">Размеру скидки</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog__content">
                <?
                global $arFavorites;
                global $smartPreFilter;
                $smartPreFilter['=ID'] = $arFavorites;
                ?>
                <?if(is_array($arFavorites) && count($arFavorites)):?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.smart.filter",
                        "catalog_filter",
                        array(
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CONVERT_CURRENCY" => "N",
                            "DISPLAY_ELEMENT_COUNT" => "Y",
                            "FILTER_NAME" => "arrFilter",
                            "FILTER_VIEW_MODE" => "vertical",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "IBLOCK_ID" => "5",
                            "IBLOCK_TYPE" => "catalog",
                            "PAGER_PARAMS_NAME" => "arrPager",
                            "POPUP_POSITION" => "left",
                            "PREFILTER_NAME" => "smartPreFilter",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "SAVE_IN_SESSION" => "N",
                            "SECTION_DESCRIPTION" => "-",
                            "SECTION_ID" => "0",
                            "SECTION_TITLE" => "-",
                            "SEF_MODE" => "Y",
                            "TEMPLATE_THEME" => "blue",
                            "XML_EXPORT" => "N",
                            "COMPONENT_TEMPLATE" => "catalog_filter",
                            "SEF_RULE" => "/wishlist/filter/#SMART_FILTER_PATH#/apply/",
                            "SECTION_CODE" => "0",
                            "SECTION_CODE_PATH" => "0",
                            "SMART_FILTER_PATH" => $_REQUEST['SMART_FILTER_PATH'],
                        ),
                        false
                    );?>
                    <?
                    if($_SESSION['INSERTS_ONLY'] == 'Y'){
                        global $arrFilter;
                        if($arrFilter['=PROPERTY_102']){
                            $noMatch = [];
                            $entity_data_class = GetEntityDataClass(18);
                            $rsData = $entity_data_class::getList(array(
                                'select' => array('*'),
                                'order' => array('UF_NAME' => 'ASC'),
                                'limit' => '1000',
                                'filter' => array('!UF_XML_ID' => $arrFilter['=PROPERTY_102'])
                            ));
                            while ($el = $rsData->fetch()) {
                                $noMatch[] = $el['UF_XML_ID'];
                            }
                            $arrFilter['!ID'] = CIBlockElement::SubQuery("ID", array(
                                'IBLOCK_ID' => 5,
                                '=PROPERTY_VSTAVKA_FILTER'=> $noMatch,
                            ));
                        }
                    }
                    if($_POST['loadAjax'] == 'Y') $APPLICATION->RestartBuffer();?>
                    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"catalog_section", 
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
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $_GET["sort"]?$_GET["sort"]:"PROPERTY_NEW",
		"ELEMENT_SORT_FIELD2" => $_GET["sort_2"]?$_GET["sort_2"]:"shows",
		"ELEMENT_SORT_ORDER" => $_GET["order"]?$_GET["order"]:"desc",
		"ELEMENT_SORT_ORDER2" => $_GET["order_2"]?$_GET["order_2"]:"shows",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => "5",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
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
		"OFFERS_LIMIT" => "0",
		"OFFERS_SORT_FIELD" => "SCALED_PRICE_1",
		"OFFERS_SORT_FIELD2" => "SCALED_PRICE_1",
		"OFFERS_SORT_ORDER" => "desc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "pagination",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "24",
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
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
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
		"PROPERTY_CODE_MOBILE" => array(
		)
	),
	false
);?>
                    <?if($_POST['loadAjax'] == 'Y') die();?>
                <?else:?>
                    <p style="width:100%;font-size:30px;text-align: center">Ваш список избранного пуст!</p>
                <?endif;?>
            </div>
        </div>
    </section>
    <section class="wares">
        <div class="container wares__container">
            <h2 class="g-title g-title--center wares__title">ВЫ СМОТРЕЛИ</h2>
            <div class="swiper wares-slider" data-mobile="false">
                <div class="swiper-wrapper wares-slider__wrapper">
                    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.products.viewed", 
	"catalog_element_viewed", 
	array(
		"CUSTOM_ITEM_CLASS" => "swiper-slide wares-slide",
		"ACTION_VARIABLE" => "action_cpv",
		"ADDITIONAL_PICT_PROP_5" => "-",
		"ADDITIONAL_PICT_PROP_6" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/login/basket.php",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "2",
		"DISPLAY_COMPARE" => "N",
		"ENLARGE_PRODUCT" => "STRICT",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "5",
		"IBLOCK_MODE" => "single",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP_5" => array(
		),
		"LABEL_PROP_POSITION" => "top-left",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"PAGE_ELEMENT_COUNT" => "8",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
		"SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],
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
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "catalog_element_viewed"
	),
	false
);?>
                </div>
                <button class="btn-reset g-slider-btn g-slider-btn--prev wares-slider__btn wares-slider__btn--prev">
                    <svg class="svg-icon arrow">
                        <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#arrow"></use>
                    </svg>
                </button>
                <button class="btn-reset g-slider-btn g-slider-btn--next wares-slider__btn wares-slider__btn--next">
                    <svg class="svg-icon arrow">
                        <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#arrow"></use>
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <section class="banner">
        <div class="container banner__container">
            <div class="banner-left">
                <p class="g-title g-title--white banner__subtitle">Пройдите короткий тест <br> и получите подборку украшений на телефон</p>
                <p class="g-title g-title--white banner__title">Подберем украшения по&nbsp;вашим пожеланиям</p>
                <p class="banner__desc">Снимем видео с&nbsp;изделием и&nbsp;пришлем вам в&nbsp;WhatsApp.</p><a onclick="Marquiz.showModal('5d8b956a9e4ce000448e11bb')" class="banner__link g-btn g-btn--light" href="#popup:marquiz_5d8b956a9e4ce000448e11bb">подобрать украшение</a><span class="banner__caption">Тест бесплатный. Ваши данные защищены</span>
            </div>
            <div class="banner__image"><img class="lozad" src="<?=DEFAULT_TEMPLATE_PATH?>/img/banner-image@2x.png" alt="Фотография телефона"></div>
            <div class="banner-right">
                <p class="g-title g-title--white banner-right__title">Ответив на вопросы, вы получите:</p>
                <ul class="banner-list list-reset">
                    <li class="banner-list__item">
                        <svg class="svg-icon promocode">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#promocode"></use>
                        </svg><span class="g-title g-title--white banner-list__caption"> <span>Промокод на скидку 5%<br></span>SMS СООБЩЕНИЕМ</span>
                    </li>
                    <li class="banner-list__item">
                        <svg class="svg-icon instruction">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#instruction"></use>
                        </svg><span class="g-title g-title--white banner-list__caption"> <span>ИНСТРУКЦИЮ </span>КАК ПРОВЕРИТЬ КАЧЕСТВО ЮВЕЛИРНЫХ ИЗДЕЛИЙ</span>
                    </li>
                    <li class="banner-list__item">
                        <svg class="svg-icon consultation">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#consultation"></use>
                        </svg><span class="g-title g-title--white banner-list__caption"> <span>КОНСУЛЬТАЦИЮ </span>ЭКСПЕРТА СО&nbsp;СТАЖЕМ БОЛЕЕ 10 ЛЕТ</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>