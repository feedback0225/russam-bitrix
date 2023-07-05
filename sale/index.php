<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Акций");
?>
<section class="discounts">
	<div class="container discounts__container">
		<? $APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"breadcrumb",
			array(
				"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
				"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
				"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
			),
			false
		); ?>
		<? $APPLICATION->IncludeComponent(
			"bitrix:news",
			"sale",
			array(
				"ADD_ELEMENT_CHAIN" => "Y",
				"ADD_SECTIONS_CHAIN" => "Y",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"CHECK_DATES" => "Y",
				"DETAIL_ACTIVE_DATE_FORMAT" => "f j, Y",
				"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
				"DETAIL_DISPLAY_TOP_PAGER" => "N",
				"DETAIL_FIELD_CODE" => array(
					0 => "DATE_ACTIVE_FROM",
					1 => "ACTIVE_FROM",
					2 => "DATE_ACTIVE_TO",
					3 => "ACTIVE_TO",
					4 => "",
				),
				"DETAIL_PAGER_SHOW_ALL" => "Y",
				"DETAIL_PAGER_TEMPLATE" => "",
				"DETAIL_PAGER_TITLE" => "Страница",
				"DETAIL_PROPERTY_CODE" => array(
					0 => "ANOTHER_SALES",
					1 => "DOP_TEXT",
					2 => "",
				),
				"DETAIL_SET_CANONICAL_URL" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FILE_404" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => "7",
				"IBLOCK_TYPE" => "sale",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"LIST_FIELD_CODE" => array(
					0 => "DATE_ACTIVE_FROM",
					1 => "ACTIVE_FROM",
					2 => "DATE_ACTIVE_TO",
					3 => "ACTIVE_TO",
					4 => "",
				),
				"LIST_PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"MESSAGE_404" => "",
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"NEWS_COUNT" => "6",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "pagination",
				"PAGER_TITLE" => "Новости",
				"PREVIEW_TRUNCATE_LEN" => "",
				"SEF_FOLDER" => "/sale/",
				"SEF_MODE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_STATUS_404" => "Y",
				"SET_TITLE" => "Y",
				"SHOW_404" => "Y",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "ACTIVE_FROM",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N",
				"USE_CATEGORIES" => "N",
				"USE_FILTER" => "N",
				"USE_PERMISSIONS" => "N",
				"USE_RATING" => "N",
				"USE_REVIEW" => "N",
				"USE_RSS" => "N",
				"USE_SEARCH" => "N",
				"USE_SHARE" => "N",
				"COMPONENT_TEMPLATE" => "sale",
				"SEF_URL_TEMPLATES" => array(
					"news" => "",
					"section" => "",
					"detail" => "#ELEMENT_CODE#/",
				)
			),
			false
		); ?>
	</div>
</section>
<? if ($APPLICATION->GetCurDir() == '/sale/') : ?>
	<section class="wares">
		<div class="container wares__container">
			<h2 class="g-title g-title--center wares__title">ВЫ СМОТРЕЛИ</h2>
			<div class="swiper wares-slider" data-mobile="false">
				<div class="swiper-wrapper wares-slider__wrapper">
					<? $APPLICATION->IncludeComponent(
						"bitrix:catalog.products.viewed",
						"catalog_element_viewed",
						array(
							"CUSTOM_ITEM_CLASS" => 'swiper-slide wares-slide',
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
							"HIDE_NOT_AVAILABLE" => "Y",
							"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
							"IBLOCK_ID" => "5",
							"IBLOCK_MODE" => "single",
							"IBLOCK_TYPE" => "catalog",
							"LABEL_PROP_5" => array(),
							"LABEL_PROP_POSITION" => "top-left",
							"MESS_BTN_ADD_TO_BASKET" => "В корзину",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"PAGE_ELEMENT_COUNT" => "9",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRICE_CODE" => array("BASE"),
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
							"USE_PRODUCT_QUANTITY" => "N"
						)
					); ?>
				</div>
				<button class="btn-reset g-slider-btn g-slider-btn--prev wares-slider__btn wares-slider__btn--prev">
					<svg class="svg-icon arrow">
						<use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
					</svg>
				</button>
				<button class="btn-reset g-slider-btn g-slider-btn--next wares-slider__btn wares-slider__btn--next">
					<svg class="svg-icon arrow">
						<use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
					</svg>
				</button>
			</div>
		</div>
	</section>
<? endif; ?>




<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>