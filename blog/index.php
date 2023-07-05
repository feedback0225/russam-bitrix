<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Блог");
?>

    <section class="blog">
        <div class="container blog__container">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb", Array(
                "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
            ),
                false
            );?>
            <?
            global $blogFilter;
            if($_GET['tags']){
                $blogFilter["?TAGS"] = explode(',',$_GET['tags']);
            }
            if($_POST['inputValue']){
                $blogFilter["?NAME"] = $_POST['inputValue'];
            }
            ?>
            <?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"blog",
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
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "TAGS",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "ALSO",
			2 => "ADDITIONAL_TEXT",
			3 => "IMAGES_NAME",
			4 => "AUTHOR_IMG",
			5 => "IMAGES",
			6 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "blog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
		"LIST_FIELD_CODE" => array(
			0 => "TAGS",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "ALSO",
			2 => "ADDITIONAL_TEXT",
			3 => "IMAGES_NAME",
			4 => "AUTHOR_IMG",
			5 => "IMAGES",
			6 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "7",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "blog_pagination",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/blog/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "blogFilter",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "blog",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);?>
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
    <section class="info">
        <div class="container info__container read-more-wrapper">
            <h2 class="g-title info__title">оФИЦИАЛЬНЫЙ САЙТ ЮВЕЛИРНЫХ ИЗДЕЛИЙ русские самоцветы</h2>
            <p class="info__desc full-text">Интернет-галерея «Русские самоцветы» — уникальная онлайн-площадка, где представлена продукция собственного ювелирного завода. Официальный сайт ювелирного магазина содержит каталог украшений. В каталоге из более 4000 ювелирных изделий собраны украшения непревзойденного качества, которое гарантирует производитель из числа лидеров отрасли. Для каждого товара представлены не только качественные фотографии и видеоматериалы, но и <br> максимум полезной информации, которая помогает сделать выбор еще более комфортным, чем в салоне.</p>
            <button class="btn-reset g-link read-more info__more" data-text="Читать дальше">Читать дальше</button>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>