<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Page\Asset;
use Rover\GeoIp\Location;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <? $APPLICATION->ShowHead(); ?>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    <?
    Asset::getInstance()->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
    Asset::getInstance()->addString('<meta name="theme-color" content="#fff">');
    Asset::getInstance()->addString('<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">');
    Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
    Asset::getInstance()->addString('<link rel="shortcut icon" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/favicon.ico" type="image/x-icon">');


    $curPage = $APPLICATION->GetCurPage();
    if ($curPage == '/new/' || $curPage == '/wishlist/' || $curPage == '/blog/' || $curPage == '/news/') {
        Asset::getInstance()->addString('<link rel="canonical" href="https://' . $_SERVER['SERVER_NAME'] . $curPage . '" />');
    }

    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-144x144.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-192x192.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-36x36.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-48x48.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-72x72.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/android-icon-96x96.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-114x114.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-120x120.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-144x144.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-152x152.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-180x180.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-57x57.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-60x60.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-72x72.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-76x76.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon-precomposed.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/apple-icon.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/favicon-16x16.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/favicon-32x32.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/favicon-96x96.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/ms-icon-144x144.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/ms-icon-150x150.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/ms-icon-310x310.png" type="image/png">');
    Asset::getInstance()->addString('<link rel="icon" sizes="16x16" href="' . DEFAULT_TEMPLATE_PATH . '/img/favicons/ms-icon-70x70.png" type="image/png">');

    Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/styles/main.min.css');
    Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/styles/backend.css');

    CJSCore::Init(array("fx"));
    Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/vendor.js");
    Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/main.js");
    Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/backend.js");

    if (isset($_GET["utm_source"])) setcookie("utm_source", $_GET["utm_source"], time() + 3600 * 24 * 30, "/");
    if (isset($_GET["utm_medium"])) setcookie("utm_medium", $_GET["utm_medium"], time() + 3600 * 24 * 30, "/");
    if (isset($_GET["utm_campaign"])) setcookie("utm_campaign", $_GET["utm_campaign"], time() + 3600 * 24 * 30, "/");
    if (isset($_GET["utm_content"])) setcookie("utm_content", $_GET["utm_content"], time() + 3600 * 24 * 30, "/");
    if (isset($_GET["utm_term"])) setcookie("utm_term", $_GET["utm_term"], time() + 3600 * 24 * 30, "/");

    session_start();
    if ($APPLICATION->GetCurDir() == '/') {
        $_SESSION['vk_page'] = 'view_home';
    } else if ($APPLICATION->GetCurDir() == '/search/') {
        $_SESSION['vk_page'] = 'view_search';
    } else {
        $_SESSION['vk_page'] = 'view_other';
    }
    global $USER;
    if (!isBot() && CModule::IncludeModule('rover.geoip')) {
        $obCache = new CPHPCache;
        $life_time = 60 * 60 * 24 * 7; //7 дней
        $userIP = Location::getCurIp();
        //Абакан = 90.189.106.180
        //Санкт-петербург = 195.70.196.197
        $cache_id = 'userIP: ' . $userIP;
        if ($obCache->InitCache($life_time, $cache_id, "/")):
            // получаем закешированные переменные
            $userLocation = $obCache->GetVars();
        else :
            // иначе обращаемся к базе
            $userLocation = [];
            try {
                $url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=" . $userIP;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                    "Accept: application/json",
                    "Authorization: Token f25805a99bc68fbdc6f340084f95c8bc3225a9fb",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $locationName = json_decode($resp, true)['location']['data']['city'];
                writeToLogs('$userIP: ' . $userIP . ' => ' . $locationName, 'dadata');
                //$location = Location::getInstance($userIP);
                if ($locationName) {
                    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                        'filter' => array('=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => 'ru', '=NAME.NAME' => $locationName),
                        'select' => array('*')
                    ));
                    while ($item = $res->fetch()) {
                        $userLocation = $item;
                        $userLocation['NAME'] = $locationName;
                        $userLocation['ZIP'] = CSaleLocation::GetLocationZIP($userLocation['ID'])->Fetch()['ZIP'];
                    }
                    if (empty($userLocation)) {
                        //Если не удалось узнать город, устанавливаем стандартно Москву
                        $userLocation['NAME'] = 'Москва';
                        $userLocation['ID'] = '216';
                        $userLocation['CODE'] = '0000073738';
                        $userLocation['ZIP'] = '101000';
                    }
                } else {
                    //Если не удалось узнать город, устанавливаем стандартно Москву
                    $userLocation['NAME'] = 'Москва';
                    $userLocation['ID'] = '216';
                    $userLocation['CODE'] = '0000073738';
                    $userLocation['ZIP'] = '101000';
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        endif;

        if ($obCache->StartDataCache()):
            $obCache->EndDataCache($userLocation);
        endif;

    } else {
        $userLocation['NAME'] = 'Москва';
        $userLocation['ID'] = '216';
        $userLocation['CODE'] = '0000073738';
        $userLocation['ZIP'] = '101000';
    }
    global $phoneNumber;
    $phoneNumber = '';
    if ($userLocation['NAME'] == '!Москва') {
        $phoneNumber = 'UF_PHONE_MSK';
    } elseif ($userLocation['NAME'] == '!Санкт-Петербург') {
        $phoneNumber = 'UF_PHONE_SPB';
    } else {
        $phoneNumber = 'UF_PHONE';
    }
    ?>
    <meta name="facebook-domain-verification" content="628j5k2d6qvt7pk04a7ie30yos1ahl"/>
    <meta name="yandex-verification" content="acb69142a06e6f1b"/>
</head>
<body>
<div class="<?= $APPLICATION->GetCurDir() != '/order/' && $APPLICATION->GetCurDir() != '/cart/' ? 'site-container' : '' ?>">
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
    <?
    CModule::IncludeModule("iblock");
    //FAVORITES
    global $USER;
    if (!$USER->IsAuthorized()) // Для неавторизованного
    {
        $arFavorites = unserialize($APPLICATION->get_cookie('favorites'));
    } else { // Для авторизованного
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arFavorites = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
    }
    if (is_array($arFavorites) && !empty($arFavorites)) { //Только существуюшие товары
        $newArrFavorites = [];
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = array("IBLOCK_ID" => IntVal(5), "ACTIVE" => "Y", "ID" => $arFavorites);
        $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 50), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $newArrFavorites[] = $arFields['ID'];
        }
        if (!$USER->IsAuthorized()) // Для неавторизованного
        {
            //$APPLICATION->get_cookie('favorites')
            $APPLICATION->set_cookie("favorites", serialize($newArrFavorites), time() + 60 * 60 * 24 * 60, "/");
        } else { // Для авторизованного
            $USER->Update($idUser, array("UF_FAVORITES" => $newArrFavorites)); // Добавляем элемент в избранное
        }
    }

    $basketProductsIDs = [];
    $basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
        \Bitrix\Sale\Fuser::getId(),
        SITE_ID
    );
    $basketItems = $basket->getBasketItems();
    foreach ($basket as $basketItem) {
        $basketProductsIDs[] = $basketItem->getProductId();
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function addActiveToBasket() {
                <?=CUtil::PhpToJSObject($basketProductsIDs)?>.forEach(function (productID) {
                    $('[data-basket-id="' + parseInt(productID) + '"]').addClass('active');
                    $('[data-basket-id="' + parseInt(productID) + '"]').html('✓&nbsp;&nbsp;&nbsp;&nbsp;Изделие в корзине');
                });
            }

            addActiveToBasket();
        })
        document.addEventListener('DOMContentLoaded', function () {
            function addActiveToFavorites() {
                <?=CUtil::PhpToJSObject($newArrFavorites)?>.forEach(function (productID) {
                    $('[data-favorite-id="' + parseInt(productID) + '"]').addClass('active');
                });
            }

            addActiveToFavorites();
        });
    </script>
    <header class="header">
        <div class="container header__container">
            <div class="header__top">
                <button class="btn-reset header__location toggle-location">
                    <svg class="svg-icon location">
                        <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#location"></use>
                    </svg>
                    <span class="region-selection__choice"><?= $userLocation['NAME'] ?></span>
                </button>
                <? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu", array(
                    "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                    "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                    "DELAY" => "N",    // Откладывать выполнение шаблона меню
                    "MAX_LEVEL" => "1",    // Уровень вложенности меню
                    "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                        0 => "",
                    ),
                    "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                    "MENU_CACHE_TYPE" => "Y",    // Тип кеширования
                    "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                    "ROOT_MENU_TYPE" => "top_menu",    // Тип меню для первого уровня
                    "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                ),
                    false
                ); ?>
            </div>
            <div class="header__middle">
                <ul class="header-actions list-reset">
                    <li class="header-actions__item">
                        <a href="tel:<? echo \Bitrix\Main\Config\Option::get("askaron.settings", $phoneNumber); ?>"
                           class="btn-reset header-actions__btn">
                            <svg class="svg-icon tel">
                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#tel"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="header-actions__item">
                        <button class="btn-reset header-actions__btn toggle-location">
                            <svg class="svg-icon location">
                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#location"></use>
                            </svg>
                        </button>
                    </li>
                </ul>
                <div class="tel header__tel">
                    <a class="tel__value"
                       href="tel:<? echo \Bitrix\Main\Config\Option::get("askaron.settings", $phoneNumber); ?>"><?= \Bitrix\Main\Config\Option::get("askaron.settings", $phoneNumber); ?></a>
                    <div class="choices__list">
                        <button class="btn-reset card__no-size modal-btn" data-graph-animation="fadeInUp"
                                data-graph-path="make-recall" data-graph-speed="500">Перезвоните мне
                        </button>
                    </div>
                    <span class="tel__desc"><? echo \Bitrix\Main\Config\Option::get("askaron.settings", "UF_WORK_TIME_HEADER"); ?></span>
                </div>
                <a class="logo header__logo" href="/">
                    <img src="<?= DEFAULT_TEMPLATE_PATH ?>/img/logo-icon.svg" alt="Russkiye samotsvety">
                </a>
                <button class="btn-reset burger" aria-label="Кпопка бургер">
                    <span class="burger__line"></span>
                    <span class="burger__line"></span>
                    <span class="burger__line"></span>
                    <span class="burger__line"></span>
                    <span class="burger__close"></span>
                </button>
                <ul class="header__shop-nav shop-nav list-reset">
                    <li class="shop-nav__item">
                        <a class="shop-nav__link shop-nav__link--favorite" href="/wishlist/">
                            <span class="shop-nav__icon shop-nav__icon--favorite"></span>
                            <span class="shop-nav__quantity"><?= is_array($arFavorites) ? count($arFavorites) : 0 ?></span>
                        </a>
                    </li>
                    <li class="shop-nav__item">
                        <a class="shop-nav__link shop-nav__link--cart" href="/cart/">
                            <span class="shop-nav__icon shop-nav__icon--cart"></span>
                            <span class="shop-nav__quantity basketCountDOM"><?= count($basketProductsIDs) ? count($basketProductsIDs) : 0 ?></span>
                        </a>
                    </li>
                    <li class="shop-nav__item">
                        <?
                        global $USER;
                        if ($USER->IsAuthorized()):
                            ?>
                            <a href="/login/" class="btn-reset shop-nav__link shop-nav__link--cabinet">
                                <span class="shop-nav__icon shop-nav__icon--cabinet"></span>
                                <span class="shop-nav__quantity">Личный кабинет</span>
                            </a>
                        <? else: ?>
                            <button class="btn-reset shop-nav__link shop-nav__link--cabinet modal-btn"
                                    data-graph-animation="fadeInUp" data-graph-path="login-or-register"
                                    data-graph-speed="500" type="button">
                                <span class="shop-nav__icon shop-nav__icon--cabinet"></span>
                                <span class="shop-nav__quantity">Войти</span>
                            </button>
                        <? endif; ?>
                    </li>
                </ul>
            </div>
            <div class="header__bottom">
                <nav class="nav nav-lock">
                    <div class="nav__top">
                        <button class="btn-reset burger-close">
                            <svg class="svg-icon cross2">
                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#cross2"></use>
                            </svg>
                        </button>
                        <p class="g-title nav__title">Меню</p>
                    </div>
                    <ul class="nav__list nav__list--dropdown list-reset js-nav-list<? if ($APPLICATION->GetCurPage() == '/new/'): ?> nav__list_fornew<? endif; ?>">
                        <?
                        if (false):
                            $headerObCache = new CPageCache;
                            $headerLifeTime = 30 * 60;
                            $cache_id = 20 * 21 * 23 * 3;

                            if ($headerObCache->StartDataCache($headerLifeTime, $cache_id, "/")):
                                $showSectionInHeader = [];
                                $showSectionInHeader = [20, 21, 23];
                                CModule::IncludeModule("iblock");

                                foreach ($showSectionInHeader as $sectionID):
                                    ?>
                                    <?
                                    $res = CIBlockSection::GetByID($sectionID);
                                    if ($ar_res = $res->GetNext()):?>
                                        <? if ($ar_res['ACTIVE'] != 'Y') continue ?>
                                        <li class="nav__item nav__item--drop js-open-menu">
                                            <span class="nav__link nav__link--drop"><?= $ar_res['NAME'] ?></span>
                                            <svg class="svg-icon arrow">
                                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                            </svg>
                                            <div class="menu dropdown-menu menu--hidden">
                                                <div class="menu__container">
                                                    <div class="menu-nav js-nav-list">
                                                        <button class="btn-reset nav__mobile-back">
                                                            <svg class="svg-icon arrow">
                                                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                            </svg>
                                                            <?= $ar_res['NAME'] ?>
                                                        </button>
                                                        <div class="menu-nav__list">
                                                            <?
                                                            $showedSubSections = 0;
                                                            $rsParentSection = CIBlockSection::GetList(
                                                                array('sort' => 'asc'),
                                                                array('IBLOCK_ID' => 5, 'ACTIVE' => 'Y', "SECTION_ID" => $sectionID, "DEPTH_LEVEL" => 2),
                                                                false,
                                                                array("ID", "NAME", "SORT", "SECTION_PAGE_URL", "UF_HEADER_SECTIONS", "UF_BANNER", "UF_COLLECTION_IMAGES", "UF_SECTION_LINK_NAME", "UF_BANNER_LINK", "UF_LEFT_SECTIONS_LIST", "UF_RIGHT_SECTIONS_LIST", "UF_RIGHT_SECTIONS_TITLE")
                                                            );

                                                            while ($arParentSection = $rsParentSection->GetNext()) {
                                                                ?>
                                                                <div class="menu-nav__item js-open-menu">
                                                                    <span class="menu-nav__link <?= $showedSubSections == 0 ? 'active' : '' ?>"><?= $arParentSection['NAME'] ?></span>
                                                                    <svg class="svg-icon arrow">
                                                                        <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                    </svg>
                                                                    <div class="menu-content js-nav-list dropdown-menu <?= $showedSubSections == 0 ? 'show' : '' ?>">
                                                                        <div class="menu-content__inner">
                                                                            <button class="btn-reset nav__mobile-back">
                                                                                <svg class="svg-icon arrow">
                                                                                    <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                                </svg>
                                                                                <?= $arParentSection['NAME'] ?>
                                                                            </button>
                                                                            <? if ($arParentSection['UF_HEADER_SECTIONS']): ?>
                                                                                <button class="btn-reset g-slider-btn g-slider-btn--prev menu-slider__btn menu-slider__btn--prev">
                                                                                    <svg class="svg-icon arrow">
                                                                                        <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                                    </svg>
                                                                                </button>
                                                                                <button class="btn-reset g-slider-btn g-slider-btn--next menu-slider__btn menu-slider__btn--next">
                                                                                    <svg class="svg-icon arrow">
                                                                                        <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                                    </svg>
                                                                                </button>
                                                                                <p class="g-title menu-content__title">
                                                                                    коллекции</p>
                                                                                <div class="swiper menu-slider">
                                                                                    <div class="swiper-wrapper">
                                                                                        <? foreach ($arParentSection['UF_HEADER_SECTIONS'] as $key => $collectionID): ?>
                                                                                            <? $resSS = CIBlockSection::GetByID($collectionID);
                                                                                            if ($ar_resSS = $resSS->GetNext()): ?>
                                                                                                <a class="swiper-slide menu-slide"
                                                                                                   href="<?= $ar_resSS['SECTION_PAGE_URL'] ?>">
                                                                                                    <? $image = imageX2($arParentSection['UF_COLLECTION_IMAGES'][$key]) ?>
                                                                                                    <div class="menu-slide__image">
                                                                                                        <img class="lozad"
                                                                                                             src="<?= IMG_LOADER ?>"
                                                                                                             data-src="<?= $image[0] ? $image[0] : NO_PHOTO_PATH ?>"
                                                                                                             data-srcset="<?= $image[1] ? $image[1] : NO_PHOTO_PATH ?>"
                                                                                                             alt="shine"/>
                                                                                                    </div>
                                                                                                    <p class="g-title menu-slide__caption"><?= $ar_resSS['NAME'] ?></p>
                                                                                                </a>
                                                                                            <? endif; ?>
                                                                                        <? endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                            <? endif; ?>
                                                                            <a class="menu-content__link g-link"
                                                                               href="<?= $arParentSection['SECTION_PAGE_URL'] ?>">
                                                                                <? if ($arParentSection['UF_SECTION_LINK_NAME']): ?>
                                                                                    <?= $arParentSection['UF_SECTION_LINK_NAME'] ?>
                                                                                <? else: ?>
                                                                                    СМОТРЕТЬ ВСЕ <?= mb_strtoupper($arParentSection['NAME']) ?>
                                                                                <? endif; ?>
                                                                            </a>
                                                                            <div class="menu-content__bottom">
                                                                                <? if ($arParentSection['UF_LEFT_SECTIONS_LIST']): ?>
                                                                                    <div class="menu-content__col">
                                                                                        <p class="g-title menu-content__title">
                                                                                            Категории</p>
                                                                                        <ul class="menu-categories list-reset">
                                                                                            <?
                                                                                            $LCSectionIDArray = [];
                                                                                            foreach ($arParentSection['UF_LEFT_SECTIONS_LIST'] as $LCSectionID):
                                                                                                $resLC = CIBlockSection::GetByID($LCSectionID);
                                                                                                if ($ar_resLC = $resLC->GetNext()): $LCSectionIDArray[] = $ar_resLC; endif;
                                                                                            endforeach;
                                                                                            usort($LCSectionIDArray, function ($a, $b) {
                                                                                                return ($a['SORT'] - $b['SORT']);
                                                                                            });
                                                                                            foreach ($LCSectionIDArray as $LCSection):?>
                                                                                                <?
                                                                                                $rsss = CIBlockElement::GetList(
                                                                                                    array("SORT" => "ASC"),
                                                                                                    array(
                                                                                                        "IBLOCK_ID" => 5,
                                                                                                        "ACTIVE" => 'Y',
                                                                                                        "SECTION_ID" => $LCSection['ID'],
                                                                                                        "INCLUDE_SUBSECTIONS" => "Y",
                                                                                                        [
                                                                                                            "LOGIC" => "OR",
                                                                                                            '>CATALOG_PRICE_1' => \Bitrix\Main\Config\Option::get("askaron.settings", "UF_SHOW_PRODUCT_FROM_PRICE"),
                                                                                                            '=CATALOG_PRICE_1' => 0,
                                                                                                        ]
                                                                                                    ),
                                                                                                    false,
                                                                                                    array("nPageSize" => 10)
                                                                                                );
                                                                                                ?>
                                                                                                <? if ($rsss->result->num_rows): ?>
                                                                                                    <li class="menu-categories__item">
                                                                                                        <a class="menu-categories__link g-title"
                                                                                                           href="<?= $LCSection['SECTION_PAGE_URL'] ?>"><?= $LCSection['NAME'] ?></a>
                                                                                                    </li>
                                                                                                <? endif; ?>
                                                                                            <? endforeach; ?>
                                                                                    </div>
                                                                                <? endif; ?>
                                                                                <? if ($arParentSection['UF_RIGHT_SECTIONS_LIST']): ?>
                                                                                    <div class="menu-content__col">
                                                                                        <p class="g-title menu-content__title"><?= $arParentSection['UF_RIGHT_SECTIONS_TITLE'] ?></p>
                                                                                        <ul class="menu-categories list-reset">
                                                                                            <?
                                                                                            $RCSectionIDArray = [];
                                                                                            foreach ($arParentSection['UF_RIGHT_SECTIONS_LIST'] as $RCSectionID):
                                                                                                $resLC = CIBlockSection::GetByID($RCSectionID);
                                                                                                if ($ar_resLC = $resLC->GetNext()): $RCSectionIDArray[] = $ar_resLC; endif;
                                                                                            endforeach;
                                                                                            usort($RCSectionIDArray, function ($a, $b) {
                                                                                                return ($a['SORT'] - $b['SORT']);
                                                                                            });
                                                                                            foreach ($RCSectionIDArray as $RCSection):?>
                                                                                                <li class="menu-categories__item">
                                                                                                    <a class="menu-categories__link g-title"
                                                                                                       href="<?= $RCSection['SECTION_PAGE_URL'] ?>"><?= $RCSection['NAME'] ?></a>
                                                                                                </li>
                                                                                            <? endforeach; ?>
                                                                                    </div>
                                                                                <? endif; ?>
                                                                                <? if ($arParentSection['UF_BANNER'] && $arParentSection['UF_BANNER_LINK']): ?>
                                                                                    <a class="menu-content__banner"
                                                                                       href="<?= $arParentSection['UF_BANNER_LINK'] ?>">
                                                                                        <? $image = imageX2($arParentSection['UF_BANNER']); ?>
                                                                                        <img class="lozad"
                                                                                             src="<?= IMG_LOADER ?>"
                                                                                             data-src="<?= $image[0] ?>"
                                                                                             data-srcset="<?= $image[1] ?> 2x"
                                                                                             alt="New"/>
                                                                                    </a>
                                                                                <? endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <? $showedSubSections++ ?>
                                                            <? }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <? endif; ?>
                                <?endforeach;

                                $headerObCache->EndDataCache(); ?>
                            <? endif; ?>
                        <? else: ?>
                            <?
                            $headerNewMenuObCache = new CPageCache;
                            $headerNewMenuLifeTime = 30 * 60;
                            $cache_id = 20 * 21 * 23 * 3 * 12;

                            if ($headerNewMenuObCache->StartDataCache($headerNewMenuLifeTime, $cache_id, "/")):
                                $showSectionInHeader = [];
                                $showSectionInHeader = [20, 21, 23];
                                CModule::IncludeModule("iblock");
                                foreach ($showSectionInHeader as $sectionID):
                                    ?>
                                    <?
                                    $res = CIBlockSection::GetByID($sectionID);
                                    if ($ar_res = $res->GetNext()):?>
                                        <? if ($ar_res['ACTIVE'] != 'Y') continue ?>
                                        <li class="nav__item nav__item--drop js-open-menu">
                                            <span class="nav__link nav__link--drop"><?= $ar_res['NAME'] ?></span>
                                            <svg class="svg-icon arrow">
                                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                            </svg>
                                            <div class="menu--hidden menu menu-2 dropdown-menu">
                                                <div class="menu__container">
                                                    <div class="menu-nav js-nav-list">
                                                        <button class="btn-reset nav__mobile-back">
                                                            <svg class="svg-icon arrow">
                                                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                            </svg>
                                                            <?= $ar_res['NAME'] ?>
                                                        </button>
                                                        <div class="menu-nav__list">
                                                            <?
                                                            $showedSubSections = 0;
                                                            $rsParentSection = CIBlockSection::GetList(
                                                                array('sort' => 'asc'),
                                                                array('IBLOCK_ID' => 5, 'ACTIVE' => 'Y', "SECTION_ID" => $sectionID, "DEPTH_LEVEL" => 2),
                                                                false,
                                                                array("ID", "NAME", "SORT", "SECTION_PAGE_URL", "UF_HEADER_SECTIONS", "UF_BANNER", "UF_COLLECTION_IMAGES", "UF_SECTION_LINK_NAME", "UF_BANNER_LINK", "UF_LEFT_SECTIONS_LIST", "UF_RIGHT_SECTIONS_LIST", "UF_RIGHT_SECTIONS_TITLE")
                                                            );
                                                            // $rsParentSection->result->num_rows
                                                            while ($arParentSection = $rsParentSection->GetNext())
                                                            {
                                                            ?>
                                                            <div class="menu-nav__item js-open-menu">
                                                                <span class="menu-nav__link <?= $showedSubSections == 0 ? 'active' : '' ?>"><?= $arParentSection['NAME'] ?></span>
                                                                <svg class="svg-icon arrow">
                                                                    <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                </svg>
                                                                <div class="menu-content js-nav-list dropdown-menu <?= $showedSubSections == 0 ? 'show' : '' ?>">
                                                                    <div class="menu-content__inner">
                                                                        <button class="btn-reset nav__mobile-back">
                                                                            <svg class="svg-icon arrow">
                                                                                <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#arrow"></use>
                                                                            </svg>
                                                                            <?= $arParentSection['NAME'] ?>
                                                                        </button>
                                                                        <div class="menu-content__bottom">
                                                                            <div class="menu-content__col">
                                                                                <a class="menu-content__link g-link"
                                                                                   href="<?= $arParentSection['SECTION_PAGE_URL'] ?>">
                                                                                    <? if ($arParentSection['UF_SECTION_LINK_NAME']): ?>
                                                                                        <?= $arParentSection['UF_SECTION_LINK_NAME'] ?>
                                                                                    <? else: ?>
                                                                                        ВСЕ <?= mb_strtoupper($arParentSection['NAME']) ?>
                                                                                    <? endif; ?>
                                                                                </a>
                                                                                <? if ($arParentSection['UF_LEFT_SECTIONS_LIST']): ?>
                                                                                    <ul class="menu-categories list-reset">
                                                                                        <?
                                                                                        $LCSectionIDArray = [];
                                                                                        foreach ($arParentSection['UF_LEFT_SECTIONS_LIST'] as $LCSectionID):
                                                                                            $resLC = CIBlockSection::GetByID($LCSectionID);
                                                                                            if ($ar_resLC = $resLC->GetNext()): $LCSectionIDArray[] = $ar_resLC; endif;
                                                                                        endforeach;
                                                                                        usort($LCSectionIDArray, function ($a, $b) {
                                                                                            return ($a['SORT'] - $b['SORT']);
                                                                                        });
                                                                                        foreach ($LCSectionIDArray as $LCSection):?>
                                                                                            <?
                                                                                            $rsss = CIBlockElement::GetList(
                                                                                                array("SORT" => "ASC"),
                                                                                                array(
                                                                                                    "IBLOCK_ID" => 5,
                                                                                                    "ACTIVE" => 'Y',
                                                                                                    "SECTION_ID" => $LCSection['ID'],
                                                                                                    "INCLUDE_SUBSECTIONS" => "Y",
                                                                                                    [
                                                                                                        "LOGIC" => "OR",
                                                                                                        '>CATALOG_PRICE_1' => \Bitrix\Main\Config\Option::get("askaron.settings", "UF_SHOW_PRODUCT_FROM_PRICE"),
                                                                                                        '=CATALOG_PRICE_1' => 0,
                                                                                                    ]
                                                                                                ),
                                                                                                false,
                                                                                                array("nPageSize" => 10)
                                                                                            );
                                                                                            ?>
                                                                                            <? if ($rsss->result->num_rows): ?>
                                                                                                <li class="menu-categories__item">
                                                                                                    <a class="menu-categories__link g-title"
                                                                                                       href="<?= $LCSection['SECTION_PAGE_URL'] ?>"><?= $LCSection['NAME'] ?></a>
                                                                                                </li>
                                                                                            <? endif; ?>
                                                                                        <? endforeach; ?>
                                                                                    </ul>
                                                                                <? endif; ?>
                                                                            </div>
                                                                            <? if ($arParentSection['UF_BANNER']): ?>
                                                                                <a class="menu-content__banner"
                                                                                   href="<?= $arParentSection['UF_BANNER_LINK'] ? $arParentSection['UF_BANNER_LINK'] : $arParentSection['SECTION_PAGE_URL'] ?>">
                                                                                    <? $image = imageX2($arParentSection['UF_BANNER'], 600); ?>
                                                                                    <img class="lozad"
                                                                                         src="<?= IMG_LOADER ?>"
                                                                                         data-src="<?= $image[0] ?>"
                                                                                         alt="New"/>
                                                                                </a>
                                                                            <? endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <? $showedSubSections++ ?>
                                                            <? if ($rsParentSection->result->num_rows > 3 && $showedSubSections == $rsParentSection->result->num_rows - 2): ?>
                                                        </div>
                                                        <div class="menu-nav__list menu-nav__list--2">
                                                            <?endif;
                                                            ?>
                                                            <? }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <? endif; ?>
                                <?endforeach;
                                $headerNewMenuObCache->EndDataCache(); ?>
                            <? endif; ?>
                        <? endif; ?>
                        <li class="nav__item"><a class="nav__link nav__link--gray" href="/new/">NEW</a></li>
                        <li class="nav__item"><a class="nav__link nav__link--gray"
                                                 href="/products/kollektsii/ukrasheniya/">КОЛЛЕКЦИИ</a></li>
                        <li class="nav__item"><a class="nav__link nav__link--gray" href="/sale/">АКЦИИ</a></li>
                    </ul>
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu_secret", array(
                        "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                        "DELAY" => "N",    // Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",    // Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "Y",    // Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                        "ROOT_MENU_TYPE" => "top_menu",    // Тип меню для первого уровня
                        "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                    ),
                        false
                    ); ?>
                    <a class="nav__cabinet" href="/">
                        <svg class="svg-icon cabinet">
                            <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#cabinet"></use>
                        </svg>
                        ВОЙТИ В КАБИНЕТ
                    </a>
                    <button class="btn-reset nav-location toggle-location">
                        <span class="nav-location__caption">Ваш город:</span>
                        <span class="nav-location__value region-selection__choice"><?= $userLocation['NAME'] ?></span>
                    </button>
                    <div class="tel nav-tel">
                        <a class="tel__value nav-tel__value"
                           href="tel:<?= \Bitrix\Main\Config\Option::get("askaron.settings", $phoneNumber); ?>"><?= \Bitrix\Main\Config\Option::get("askaron.settings", $phoneNumber); ?></a>
                        <span class="tel__desc nav-tel__desc"><?= \Bitrix\Main\Config\Option::get("askaron.settings", "UF_WORK_TIME_HEADER"); ?></span>
                    </div>
                </nav>
                <? /*$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"header_search", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "5",
		),
		"CHECK_DATES" => "Y",
		"CONTAINER_ID" => "title-search",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "rank",
		"PAGE" => "#SITE_DIR#search/",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"TOP_COUNT" => "1000",
		"USE_LANGUAGE_GUESS" => "Y",
		"COMPONENT_TEMPLATE" => "header_search",
		"CATEGORIES" => array(
			0 => "24",
			1 => "25",
			2 => "28",
			3 => "29",
			4 => "references",
			5 => "",
			6 => "",
		),
		"CATEGORIESY" => array(
			0 => "24",
			1 => "25",
			2 => "26",
			3 => "27",
			4 => "28",
			5 => "29",
			6 => "30",
			7 => "31",
			8 => "32",
			9 => "33",
			10 => "34",
			11 => "35",
			12 => "36",
			13 => "37",
			14 => "38",
			15 => "39",
			16 => "40",
			17 => "41",
			18 => "42",
			19 => "43",
			20 => "44",
			21 => "45",
			22 => "46",
			23 => "47",
			24 => "48",
			25 => "49",
			26 => "51",
			27 => "52",
			28 => "53",
			29 => "54",
			30 => "55",
			31 => "56",
			32 => "57",
			33 => "58",
			34 => "59",
			35 => "60",
			36 => "62",
			37 => "63",
			38 => "64",
			39 => "65",
			40 => "66",
			41 => "67",
			42 => "68",
			43 => "69",
			44 => "70",
			45 => "71",
			46 => "72",
			47 => "73",
			48 => "74",
			49 => "75",
			50 => "76",
			51 => "77",
			52 => "78",
			53 => "79",
			54 => "80",
			55 => "82",
			56 => "84",
			57 => "85",
			58 => "86",
			59 => "87",
			60 => "88",
			61 => "89",
			62 => "93",
			63 => "94",
			64 => "95",
			65 => "96",
			66 => "97",
			67 => "98",
			68 => "99",
			69 => "100",
			70 => "101",
			71 => "102",
			72 => "103",
			73 => "104",
			74 => "109",
			75 => "110",
			76 => "111",
			77 => "112",
			78 => "113",
			79 => "114",
			80 => "115",
			81 => "116",
			82 => "117",
			83 => "118",
			84 => "119",
			85 => "120",
			86 => "121",
			87 => "122",
			88 => "123",
			89 => "124",
			90 => "125",
			91 => "126",
			92 => "127",
			93 => "128",
			94 => "129",
			95 => "130",
			96 => "131",
			97 => "132",
			98 => "133",
			99 => "134",
			100 => "135",
			101 => "136",
			102 => "137",
			103 => "138",
			104 => "139",
			105 => "140",
			106 => "141",
			107 => "142",
			108 => "143",
			109 => "144",
			110 => "145",
			111 => "146",
			112 => "147",
			113 => "148",
			114 => "149",
			115 => "150",
			116 => "151",
			117 => "152",
			118 => "153",
			119 => "154",
			120 => "155",
			121 => "156",
			122 => "157",
			123 => "158",
			124 => "159",
			125 => "160",
			126 => "161",
			127 => "162",
			128 => "163",
			129 => "164",
			130 => "165",
			131 => "166",
			132 => "167",
			133 => "168",
			134 => "169",
			135 => "170",
			136 => "171",
			137 => "172",
			138 => "173",
			139 => "174",
			140 => "175",
			141 => "176",
			142 => "177",
			143 => "178",
			144 => "179",
			145 => "181",
			146 => "182",
			147 => "183",
			148 => "184",
			149 => "185",
			150 => "186",
			151 => "187",
			152 => "193",
			153 => "194",
			154 => "195",
			155 => "196",
			156 => "197",
			157 => "198",
			158 => "199",
			159 => "200",
			160 => "201",
			161 => "202",
			162 => "203",
			163 => "204",
			164 => "205",
			165 => "206",
			166 => "207",
			167 => "208",
			168 => "209",
			169 => "210",
			170 => "211",
			171 => "212",
			172 => "213",
			173 => "214",
			174 => "215",
			175 => "216",
			176 => "217",
			177 => "218",
			178 => "219",
			179 => "220",
			180 => "221",
			181 => "222",
			182 => "223",
			183 => "226",
			184 => "227",
			185 => "228",
			186 => "229",
			187 => "230",
			188 => "231",
			189 => "233",
			190 => "234",
			191 => "235",
			192 => "236",
			193 => "237",
			194 => "238",
			195 => "239",
			196 => "240",
			197 => "241",
			198 => "242",
			199 => "243",
			200 => "244",
			201 => "245",
			202 => "246",
			203 => "247",
			204 => "250",
			205 => "251",
			206 => "252",
			207 => "253",
			208 => "254",
			209 => "255",
			210 => "256",
			211 => "257",
			212 => "258",
			213 => "259",
			214 => "260",
			215 => "261",
			216 => "262",
			217 => "263",
			218 => "264",
			219 => "265",
			220 => "266",
			221 => "267",
			222 => "268",
			223 => "269",
			224 => "270",
			225 => "271",
			226 => "272",
			227 => "273",
			228 => "274",
			229 => "302",
			230 => "304",
			231 => "305",
			232 => "306",
			233 => "307",
			234 => "308",
			235 => "309",
			236 => "310",
			237 => "311",
			238 => "312",
			239 => "313",
			240 => "314",
			241 => "315",
			242 => "316",
			243 => "317",
			244 => "318",
			245 => "319",
			246 => "320",
			247 => "321",
			248 => "322",
			249 => "323",
			250 => "324",
			251 => "325",
			252 => "326",
			253 => "327",
			254 => "328",
			255 => "329",
			256 => "330",
			257 => "331",
			258 => "332",
			259 => "333",
			260 => "334",
			261 => "335",
			262 => "336",
			263 => "337",
			264 => "338",
			265 => "339",
			266 => "340",
			267 => "341",
			268 => "342",
			269 => "343",
			270 => "344",
			271 => "345",
			272 => "346",
			273 => "347",
			274 => "348",
			275 => "349",
			276 => "350",
			277 => "351",
			278 => "352",
			279 => "353",
			280 => "355",
			281 => "356",
			282 => "357",
			283 => "358",
			284 => "359",
			285 => "360",
			286 => "361",
			287 => "362",
			288 => "363",
			289 => "364",
			290 => "365",
			291 => "366",
			292 => "367",
			293 => "368",
			294 => "369",
			295 => "420",
			296 => "421",
			297 => "422",
			298 => "423",
			299 => "424",
			300 => "425",
			301 => "426",
			302 => "427",
			303 => "428",
			304 => "429",
			305 => "430",
			306 => "431",
			307 => "432",
			308 => "433",
			309 => "434",
			310 => "435",
			311 => "436",
			312 => "437",
			313 => "438",
			314 => "439",
			315 => "440",
			316 => "441",
			317 => "442",
			318 => "443",
			319 => "444",
			320 => "445",
			321 => "446",
			322 => "447",
			323 => "448",
			324 => "449",
			325 => "450",
			326 => "451",
			327 => "452",
			328 => "453",
			329 => "454",
			330 => "455",
			331 => "456",
			332 => "458",
			333 => "459",
			334 => "460",
			335 => "461",
			336 => "462",
			337 => "463",
			338 => "464",
			339 => "465",
			340 => "466",
			341 => "467",
			342 => "468",
			343 => "469",
			344 => "470",
			345 => "483",
			346 => "484",
			347 => "485",
			348 => "486",
			349 => "487",
			350 => "488",
			351 => "489",
			352 => "497",
			353 => "498",
			354 => "499",
			355 => "500",
			356 => "501",
			357 => "502",
			358 => "503",
			359 => "504",
			360 => "507",
			361 => "508",
			362 => "509",
			363 => "510",
			364 => "511",
			365 => "512",
			366 => "513",
			367 => "515",
			368 => "516",
			369 => "519",
			370 => "520",
			371 => "521",
			372 => "522",
			373 => "523",
			374 => "524",
			375 => "525",
			376 => "526",
			377 => "527",
			378 => "528",
			379 => "529",
			380 => "530",
			381 => "531",
			382 => "533",
			383 => "535",
			384 => "536",
			385 => "537",
			386 => "538",
			387 => "539",
			388 => "540",
			389 => "541",
			390 => "542",
			391 => "543",
			392 => "544",
			393 => "545",
			394 => "546",
			395 => "547",
			396 => "548",
			397 => "549",
			398 => "550",
			399 => "551",
			400 => "552",
			401 => "553",
			402 => "554",
			403 => "555",
			404 => "556",
			405 => "557",
			406 => "558",
			407 => "559",
			408 => "560",
			409 => "561",
			410 => "562",
			411 => "563",
			412 => "564",
			413 => "565",
			414 => "566",
			415 => "567",
			416 => "568",
			417 => "569",
			418 => "570",
			419 => "571",
			420 => "572",
			421 => "573",
			422 => "574",
			423 => "575",
			424 => "576",
			425 => "596",
			426 => "597",
			427 => "598",
			428 => "599",
			429 => "600",
			430 => "601",
			431 => "602",
			432 => "603",
			433 => "604",
			434 => "605",
			435 => "606",
			436 => "607",
			437 => "608",
			438 => "609",
			439 => "610",
			440 => "611",
			441 => "612",
			442 => "613",
			443 => "614",
			444 => "615",
			445 => "616",
			446 => "617",
			447 => "618",
			448 => "619",
			449 => "621",
			450 => "622",
			451 => "623",
			452 => "717",
			453 => "719",
			454 => "720",
			455 => "721",
			456 => "722",
			457 => "723",
			458 => "724",
			459 => "725",
			460 => "726",
			461 => "727",
			462 => "728",
			463 => "729",
			464 => "730",
			465 => "731",
			466 => "732",
			467 => "733",
			468 => "734",
			469 => "735",
			470 => "736",
			471 => "737",
			472 => "738",
			473 => "739",
			474 => "740",
			475 => "741",
			476 => "742",
			477 => "743",
			478 => "744",
			479 => "745",
			480 => "746",
			481 => "747",
			482 => "748",
			483 => "749",
			484 => "750",
			485 => "751",
			486 => "752",
			487 => "753",
			488 => "754",
			489 => "755",
			490 => "756",
			491 => "757",
			492 => "758",
			493 => "759",
			494 => "760",
			495 => "761",
			496 => "762",
			497 => "763",
			498 => "764",
			499 => "765",
			500 => "766",
			501 => "767",
			502 => "768",
			503 => "769",
			504 => "770",
			505 => "771",
			506 => "772",
			507 => "773",
			508 => "774",
			509 => "775",
			510 => "776",
			511 => "777",
			512 => "778",
			513 => "779",
			514 => "780",
			515 => "781",
			516 => "782",
			517 => "783",
			518 => "784",
			519 => "785",
			520 => "786",
			521 => "787",
			522 => "788",
			523 => "789",
			524 => "790",
			525 => "791",
			526 => "792",
			527 => "793",
			528 => "794",
			529 => "795",
			530 => "796",
			531 => "797",
			532 => "798",
			533 => "799",
			534 => "800",
			535 => "801",
			536 => "802",
			537 => "803",
			538 => "804",
			539 => "805",
			540 => "806",
			541 => "807",
			542 => "808",
			543 => "809",
			544 => "810",
			545 => "811",
			546 => "812",
			547 => "813",
			548 => "814",
			549 => "815",
			550 => "816",
			551 => "817",
			552 => "818",
			553 => "819",
			554 => "820",
			555 => "821",
			556 => "822",
			557 => "823",
			558 => "824",
			559 => "825",
			560 => "826",
			561 => "827",
			562 => "828",
			563 => "829",
			564 => "830",
			565 => "831",
			566 => "832",
			567 => "833",
			568 => "834",
			569 => "835",
			570 => "836",
			571 => "837",
			572 => "838",
			573 => "839",
			574 => "840",
			575 => "841",
			576 => "842",
			577 => "843",
			578 => "844",
			579 => "845",
			580 => "846",
			581 => "847",
			582 => "848",
			583 => "849",
			584 => "850",
			585 => "851",
			586 => "852",
			587 => "853",
			588 => "854",
			589 => "855",
			590 => "856",
			591 => "857",
			592 => "858",
			593 => "859",
			594 => "860",
			595 => "861",
			596 => "862",
			597 => "863",
			598 => "864",
			599 => "865",
			600 => "866",
			601 => "867",
			602 => "868",
			603 => "869",
			604 => "870",
			605 => "871",
			606 => "872",
			607 => "873",
			608 => "874",
			609 => "875",
			610 => "876",
			611 => "877",
			612 => "878",
			613 => "879",
			614 => "880",
			615 => "882",
			616 => "883",
			617 => "884",
			618 => "885",
			619 => "886",
			620 => "888",
			621 => "889",
			622 => "890",
			623 => "892",
			624 => "893",
			625 => "894",
			626 => "895",
			627 => "898",
			628 => "899",
			629 => "900",
			630 => "902",
			631 => "903",
			632 => "904",
			633 => "905",
			634 => "906",
			635 => "907",
			636 => "908",
			637 => "909",
			638 => "910",
			639 => "911",
			640 => "912",
			641 => "913",
			642 => "914",
			643 => "915",
			644 => "916",
			645 => "917",
			646 => "918",
			647 => "919",
			648 => "920",
			649 => "921",
			650 => "922",
			651 => "923",
			652 => "924",
			653 => "925",
			654 => "926",
			655 => "927",
			656 => "928",
			657 => "929",
			658 => "930",
			659 => "931",
			660 => "932",
			661 => "933",
			662 => "934",
			663 => "935",
			664 => "936",
			665 => "937",
			666 => "938",
			667 => "939",
			668 => "940",
			669 => "941",
			670 => "942",
			671 => "943",
			672 => "944",
			673 => "945",
			674 => "946",
			675 => "947",
			676 => "948",
			677 => "949",
			678 => "950",
			679 => "951",
			680 => "952",
			681 => "953",
			682 => "954",
			683 => "955",
			684 => "956",
			685 => "957",
			686 => "958",
			687 => "959",
			688 => "960",
			689 => "961",
			690 => "962",
			691 => "963",
			692 => "964",
			693 => "965",
			694 => "966",
			695 => "967",
			696 => "968",
			697 => "969",
			698 => "970",
			699 => "971",
			700 => "972",
			701 => "973",
			702 => "974",
			703 => "975",
			704 => "976",
			705 => "977",
			706 => "978",
			707 => "979",
			708 => "980",
			709 => "981",
			710 => "982",
			711 => "983",
			712 => "984",
			713 => "985",
			714 => "986",
			715 => "987",
			716 => "988",
			717 => "989",
			718 => "990",
			719 => "991",
			720 => "992",
			721 => "993",
			722 => "994",
			723 => "995",
			724 => "996",
			725 => "997",
			726 => "998",
			727 => "1000",
			728 => "1001",
			729 => "1002",
			730 => "1003",
			731 => "1004",
			732 => "1005",
			733 => "1006",
			734 => "1007",
			735 => "1008",
			736 => "1009",
			737 => "1010",
			738 => "1011",
			739 => "1012",
			740 => "1013",
			741 => "1014",
			742 => "1015",
			743 => "1016",
			744 => "1017",
			745 => "1018",
			746 => "1019",
			747 => "1020",
			748 => "1021",
			749 => "1022",
			750 => "1023",
			751 => "1024",
			752 => "1025",
			753 => "1026",
			754 => "1027",
			755 => "1028",
			756 => "1029",
			757 => "1030",
			758 => "1031",
			759 => "1032",
			760 => "1033",
			761 => "1034",
			762 => "1035",
			763 => "1036",
			764 => "1037",
			765 => "1038",
			766 => "1039",
			767 => "1040",
			768 => "1041",
			769 => "1042",
			770 => "1043",
			771 => "1044",
			772 => "1045",
			773 => "1046",
			774 => "1047",
			775 => "1048",
			776 => "1049",
			777 => "1050",
			778 => "1051",
			779 => "1052",
			780 => "1053",
			781 => "1054",
			782 => "1055",
			783 => "1056",
			784 => "1057",
			785 => "1058",
			786 => "1059",
			787 => "1060",
			788 => "1061",
			789 => "1062",
			790 => "1063",
			791 => "1064",
			792 => "1065",
			793 => "1066",
			794 => "1067",
			795 => "1068",
			796 => "1069",
			797 => "1070",
			798 => "1071",
			799 => "1072",
			800 => "1073",
			801 => "1074",
			802 => "1075",
			803 => "1076",
			804 => "1077",
			805 => "1078",
			806 => "1079",
			807 => "1080",
			808 => "1081",
			809 => "1082",
			810 => "1083",
			811 => "1084",
			812 => "1085",
			813 => "1086",
			814 => "1087",
			815 => "1088",
			816 => "1089",
			817 => "1090",
			818 => "1091",
			819 => "1092",
			820 => "1093",
			821 => "1094",
			822 => "1095",
			823 => "1096",
			824 => "1097",
			825 => "1098",
			826 => "1099",
			827 => "1100",
			828 => "1101",
			829 => "1102",
			830 => "1103",
			831 => "1104",
			832 => "1105",
			833 => "1106",
			834 => "1107",
			835 => "1108",
			836 => "1109",
			837 => "1110",
			838 => "1111",
			839 => "1112",
			840 => "1113",
			841 => "1114",
			842 => "1115",
			843 => "1116",
			844 => "1117",
			845 => "1118",
			846 => "1119",
			847 => "1120",
			848 => "1121",
			849 => "1122",
			850 => "1123",
			851 => "1124",
			852 => "1125",
			853 => "1126",
			854 => "1127",
			855 => "1128",
			856 => "1129",
			857 => "1130",
			858 => "1131",
			859 => "1132",
			860 => "1133",
			861 => "1134",
			862 => "1135",
			863 => "1136",
			864 => "1137",
			865 => "1138",
			866 => "1139",
			867 => "1140",
			868 => "1141",
			869 => "1142",
			870 => "1143",
			871 => "1144",
			872 => "1145",
			873 => "1146",
			874 => "1147",
			875 => "1148",
			876 => "1149",
			877 => "1150",
			878 => "1151",
			879 => "1152",
			880 => "1153",
			881 => "1154",
			882 => "1155",
			883 => "1156",
			884 => "1157",
			885 => "1158",
			886 => "1160",
			887 => "1161",
			888 => "1162",
			889 => "1163",
			890 => "1164",
			891 => "1165",
			892 => "1166",
			893 => "1167",
			894 => "1168",
			895 => "1169",
			896 => "1170",
			897 => "1171",
			898 => "1172",
			899 => "1173",
			900 => "1174",
			901 => "1175",
			902 => "1176",
			903 => "1177",
			904 => "1178",
			905 => "1179",
			906 => "1180",
			907 => "1181",
			908 => "1182",
			909 => "1183",
			910 => "1184",
			911 => "1185",
			912 => "1186",
			913 => "1187",
			914 => "1188",
			915 => "1189",
			916 => "1190",
			917 => "1191",
			918 => "1192",
			919 => "1193",
			920 => "1194",
			921 => "1195",
			922 => "1196",
			923 => "1197",
			924 => "1198",
			925 => "1199",
			926 => "1200",
			927 => "1201",
			928 => "1202",
			929 => "1203",
			930 => "1204",
			931 => "1205",
			932 => "1206",
			933 => "1207",
			934 => "1208",
			935 => "1209",
			936 => "1210",
			937 => "1211",
			938 => "1212",
			939 => "1213",
			940 => "1325",
			941 => "1326",
			942 => "1327",
			943 => "1328",
			944 => "1329",
			945 => "1330",
			946 => "1331",
			947 => "1332",
			948 => "1333",
			949 => "1334",
			950 => "1335",
			951 => "1336",
			952 => "1337",
			953 => "1338",
			954 => "1339",
			955 => "1340",
			956 => "1341",
			957 => "1342",
			958 => "1343",
			959 => "1344",
			960 => "1345",
			961 => "1346",
			962 => "1347",
			963 => "1348",
			964 => "1349",
			965 => "1350",
			966 => "1351",
			967 => "1352",
			968 => "1353",
			969 => "1354",
			970 => "1355",
			971 => "1356",
			972 => "1357",
			973 => "1358",
			974 => "1359",
			975 => "1360",
			976 => "1361",
			977 => "1362",
			978 => "1363",
			979 => "1364",
			980 => "1365",
			981 => "1366",
			982 => "1367",
			983 => "1368",
			984 => "1369",
			985 => "1370",
			986 => "1371",
			987 => "1372",
			988 => "1373",
			989 => "1374",
			990 => "1375",
			991 => "1376",
			992 => "1377",
			993 => "1378",
			994 => "1379",
			995 => "1380",
			996 => "1381",
			997 => "1382",
			998 => "1383",
			999 => "1384",
			1000 => "1385",
			1001 => "1386",
			1002 => "1387",
			1003 => "1388",
			1004 => "1389",
			1005 => "1390",
			1006 => "1391",
			1007 => "1392",
			1008 => "1393",
			1009 => "1394",
			1010 => "1395",
			1011 => "1396",
			1012 => "1397",
			1013 => "1398",
			1014 => "1399",
			1015 => "1400",
			1016 => "1401",
			1017 => "1402",
			1018 => "1403",
			1019 => "1404",
			1020 => "1405",
			1021 => "1406",
			1022 => "1407",
			1023 => "1408",
			1024 => "1409",
			1025 => "1410",
			1026 => "1411",
			1027 => "1412",
			1028 => "1413",
			1029 => "1414",
			1030 => "1415",
			1031 => "1416",
			1032 => "1417",
			1033 => "1418",
			1034 => "1419",
			1035 => "1420",
			1036 => "1421",
			1037 => "1422",
			1038 => "1423",
			1039 => "1424",
			1040 => "1425",
			1041 => "1426",
			1042 => "1427",
			1043 => "1428",
			1044 => "1429",
			1045 => "1430",
			1046 => "1431",
			1047 => "1432",
			1048 => "1433",
			1049 => "1434",
			1050 => "1435",
			1051 => "1436",
			1052 => "1437",
			1053 => "1438",
			1054 => "1439",
			1055 => "1440",
			1056 => "1441",
			1057 => "1442",
			1058 => "1443",
			1059 => "1444",
			1060 => "1445",
			1061 => "1446",
			1062 => "1447",
			1063 => "1448",
			1064 => "1449",
			1065 => "1450",
			1066 => "1451",
			1067 => "1452",
			1068 => "1453",
			1069 => "1454",
			1070 => "1455",
			1071 => "1456",
			1072 => "1457",
			1073 => "1458",
			1074 => "1459",
			1075 => "1460",
			1076 => "1461",
			1077 => "1462",
			1078 => "1463",
			1079 => "1464",
			1080 => "1465",
			1081 => "1466",
			1082 => "1467",
			1083 => "1468",
			1084 => "1469",
			1085 => "1470",
			1086 => "1483",
			1087 => "1484",
			1088 => "1491",
			1089 => "1492",
			1090 => "1493",
			1091 => "1494",
			1092 => "1495",
			1093 => "1496",
			1094 => "1497",
			1095 => "1498",
			1096 => "1499",
			1097 => "1500",
			1098 => "1501",
			1099 => "1502",
			1100 => "1503",
			1101 => "1504",
			1102 => "1505",
			1103 => "1506",
			1104 => "1507",
			1105 => "1508",
			1106 => "1509",
			1107 => "1510",
			1108 => "1511",
			1109 => "1512",
			1110 => "1513",
			1111 => "1514",
			1112 => "1515",
			1113 => "1516",
			1114 => "1517",
			1115 => "1518",
			1116 => "1519",
			1117 => "1520",
			1118 => "1521",
			1119 => "1522",
			1120 => "1523",
			1121 => "1525",
			1122 => "1526",
			1123 => "1527",
			1124 => "1531",
			1125 => "1532",
			1126 => "1533",
			1127 => "1534",
			1128 => "1541",
			1129 => "1542",
			1130 => "1543",
			1131 => "1544",
			1132 => "1545",
			1133 => "1546",
			1134 => "1547",
			1135 => "1548",
			1136 => "1549",
			1137 => "1550",
			1138 => "1551",
			1139 => "1552",
			1140 => "1554",
			1141 => "1555",
			1142 => "1556",
			1143 => "1557",
			1144 => "1558",
			1145 => "1559",
			1146 => "1560",
			1147 => "1561",
			1148 => "1564",
			1149 => "1565",
			1150 => "1566",
			1151 => "1567",
			1152 => "1568",
			1153 => "1569",
			1154 => "1570",
			1155 => "1571",
			1156 => "1572",
			1157 => "1573",
			1158 => "1574",
			1159 => "1575",
			1160 => "1576",
			1161 => "1577",
			1162 => "1578",
			1163 => "1579",
			1164 => "1580",
			1165 => "1581",
			1166 => "1582",
			1167 => "1583",
			1168 => "1584",
			1169 => "1585",
			1170 => "1586",
			1171 => "1587",
			1172 => "1588",
			1173 => "1589",
			1174 => "1590",
			1175 => "1591",
			1176 => "1592",
			1177 => "1593",
			1178 => "1594",
			1179 => "1595",
			1180 => "1596",
			1181 => "1597",
			1182 => "1598",
			1183 => "1599",
			1184 => "1600",
			1185 => "1601",
			1186 => "1602",
			1187 => "1603",
			1188 => "1604",
			1189 => "1605",
			1190 => "1606",
			1191 => "1607",
			1192 => "1608",
			1193 => "1609",
			1194 => "1610",
			1195 => "1611",
			1196 => "1612",
			1197 => "1613",
			1198 => "1614",
			1199 => "1615",
			1200 => "1616",
			1201 => "1617",
			1202 => "1618",
			1203 => "1619",
			1204 => "1620",
			1205 => "1621",
			1206 => "1622",
			1207 => "1623",
			1208 => "1624",
			1209 => "1625",
			1210 => "1626",
			1211 => "1627",
			1212 => "1628",
			1213 => "1629",
			1214 => "1630",
			1215 => "1631",
			1216 => "1632",
			1217 => "1633",
			1218 => "1634",
			1219 => "1635",
			1220 => "1636",
			1221 => "1637",
			1222 => "1638",
			1223 => "1639",
			1224 => "1640",
			1225 => "1641",
			1226 => "1642",
			1227 => "1643",
			1228 => "1645",
			1229 => "1646",
			1230 => "1647",
			1231 => "1648",
			1232 => "1649",
			1233 => "1650",
			1234 => "1651",
			1235 => "1652",
			1236 => "1653",
			1237 => "1654",
			1238 => "1655",
			1239 => "1656",
			1240 => "1657",
			1241 => "1658",
			1242 => "1659",
			1243 => "1660",
			1244 => "1662",
			1245 => "1663",
			1246 => "1664",
			1247 => "1665",
			1248 => "1666",
			1249 => "1667",
			1250 => "1668",
			1251 => "1669",
			1252 => "1670",
			1253 => "1671",
			1254 => "1672",
			1255 => "1673",
			1256 => "1674",
			1257 => "1675",
			1258 => "1676",
			1259 => "1677",
			1260 => "1678",
			1261 => "1679",
			1262 => "1680",
			1263 => "1683",
			1264 => "1686",
			1265 => "1691",
			1266 => "1692",
			1267 => "1693",
			1268 => "1695",
			1269 => "1696",
			1270 => "1697",
			1271 => "1698",
			1272 => "1699",
			1273 => "1700",
			1274 => "1701",
			1275 => "1702",
			1276 => "1703",
			1277 => "1704",
			1278 => "1705",
			1279 => "1706",
			1280 => "1707",
			1281 => "1708",
			1282 => "1709",
			1283 => "1710",
			1284 => "1711",
			1285 => "1712",
			1286 => "1713",
			1287 => "1714",
			1288 => "1715",
			1289 => "1716",
			1290 => "1717",
			1291 => "1718",
			1292 => "1719",
			1293 => "1720",
			1294 => "1721",
			1295 => "1725",
			1296 => "1726",
			1297 => "1727",
			1298 => "1728",
			1299 => "1730",
			1300 => "1731",
			1301 => "1732",
			1302 => "1733",
			1303 => "1734",
			1304 => "1735",
			1305 => "1736",
			1306 => "1737",
			1307 => "1738",
			1308 => "1739",
			1309 => "1740",
			1310 => "1741",
			1311 => "1742",
			1312 => "1743",
			1313 => "1744",
			1314 => "1745",
			1315 => "1746",
			1316 => "1747",
			1317 => "1749",
			1318 => "1750",
			1319 => "1751",
			1320 => "1752",
			1321 => "1753",
			1322 => "1754",
			1323 => "1755",
			1324 => "1756",
			1325 => "1757",
			1326 => "1758",
			1327 => "1759",
			1328 => "1760",
			1329 => "1761",
			1330 => "1762",
			1331 => "1763",
			1332 => "1764",
			1333 => "1765",
			1334 => "1766",
			1335 => "1767",
			1336 => "1768",
			1337 => "1769",
			1338 => "1770",
			1339 => "1771",
			1340 => "1772",
			1341 => "1773",
			1342 => "1774",
			1343 => "1775",
			1344 => "2061",
			1345 => "2287",
			1346 => "2310",
			1347 => "",
		),
		"CATEGORY_0_iblock_offers" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_services" => array(
			0 => "all",
		),
		"CATEGORY_0_socialnetwork_user" => "",
		"CATEGORY_0_main" => "",
		"CATEGORY_0_forum" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_references" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_faq" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_sale" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_content" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_materials" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_blog" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_rest_entity" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_logic" => array(
			0 => "all",
		),
		"CATEGORY_0_blog" => array(
			0 => "all",
		),
		"CATEGORY_0_socialnetwork" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_vstavki" => array(
			0 => "all",
		)
	),
	false
);*/ ?>

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
                        <input class="search-form__input js-header-search" type="search" name="q" autocomplete="off"
                               placeholder="Поиск"/>
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
                            <ul class="search-result__list js-search-suggest list-reset"
                                data-simplebar="data-simplebar">

                            </ul>
                        </div>
                        <ul class="search-result__list list-reset search-result__list_collection js-search-collection"
                            data-simplebar="data-simplebar">

                        </ul>
                        <div class="js-search-result-items">

                        </div>
                    </div>
                </div>

                <script>
                    let searchRequest = null;
                    let suggestRequest = null;

                    $(document).on('submit', '.js-search-header-from', function (e) {
                        e.preventDefault();
                        let value = $('.js-header-search').val();
                        window.location.href = '/search/?search=' + value;
                    })

                    $(document).ready(function () {
                        $(document).on('keyup', '.js-header-search', function (e) {
                            e.preventDefault();

                            let value = $(this).val();
                            if (value.length >= 2) {
                                if (searchRequest) {
                                    // Отменить предыдущий запрос для товаров
                                    $('.search-result__swiper').hide();
                                    searchRequest.abort();
                                }

                                // Поиск подсказок
                                if (suggestRequest) {
                                    // Отменить предыдущий запрос для подсказок
                                    suggestRequest.abort();
                                }

                                suggestRequest = $.ajax({
                                    url: '/ajax/search/SearchSuggest.php',
                                    method: 'GET',
                                    dataType: 'json',
                                    data: {
                                        q: value,
                                    },
                                    success: function (data) {
                                        let htmlSuggest = '';
                                        if (data.CUSTOM_SEARCH != undefined) {
                                            $.each(data.CUSTOM_SEARCH.SUGGEST, function (key, value) {
                                                let link = value.LINK;
                                                let title = value.TITLE;

                                                let listItem = '<li class="search-result__item">' +
                                                    '<svg class="search-result__svg" width="24" height="24" fill="transparent">' +
                                                    '<use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"></use>' +
                                                    '</svg>' +
                                                    '<a class="search-result__link" href="' + link + '">' +
                                                    title +
                                                    '</a>' +
                                                    '</li>';

                                                htmlSuggest += listItem;
                                            });

                                            $('.js-search-suggest').html(htmlSuggest);

                                            //Коллекции
                                            $.ajax({
                                                url: '/ajax/search/SearchCollectionLoad.php',
                                                method: 'GET',
                                                dataType: 'html',
                                                data: {
                                                    q: value,
                                                },
                                                success: function (dataCollection) {
                                                    let $searchItemsCollection = dataCollection;
                                                    $('.js-search-collection').html($searchItemsCollection);
                                                }
                                            })

                                            if (data.CUSTOM_SEARCH.ITEMS_ID != undefined) {
                                                searchRequest = $.ajax({
                                                    url: '/ajax/search/SearchItemsLoad.php',
                                                    method: 'GET',
                                                    dataType: 'html',
                                                    data: {
                                                        items_id: data.CUSTOM_SEARCH.ITEMS_ID,
                                                        q: value,
                                                    },
                                                    success: function (dataItems) {
                                                        if (value === $('.js-header-search').val()) {
                                                            $('.js-search-result-items').html(dataItems);

                                                            var searchSwiper = new Swiper('.search-result__swiper', {
                                                                slidesPerView: "auto",
                                                                navigation: {
                                                                    nextEl: '.search-result__btn-next',
                                                                    prevEl: '.search-result__btn-prev',
                                                                },
                                                                breakpoints: {
                                                                    120: {
                                                                        spaceBetween: 30,
                                                                        slidesPerView: 2,
                                                                    },
                                                                    576: {
                                                                        spaceBetween: 0,
                                                                        slidesPerView: 3,
                                                                    },
                                                                    992: {
                                                                        slidesPerView: 4,
                                                                    }
                                                                }
                                                            });
                                                            $('.search-result__swiper').show();
                                                        } else {
                                                            $('.search-result__swiper').hide();
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            } else {
                                $('.js-search-suggest').html('');
                                $('.js-search-collection').html('');
                                $('.search-result__swiper').hide();
                            }
                        });
                    });



                </script>

            </div>
        </div>
        <div class="down-bar">
            <div class="down-bar__item">
                <button class="btn-reset down-bar__link toggle-form">
                    <span class="shop-nav__icon shop-nav__icon--search"></span>
                    Поиск
                </button>
            </div>
            <div class="down-bar__item"><a class="down-bar__link" href="/wishlist/">
                    <span class="shop-nav__icon shop-nav__icon--favorite <?= (is_array($arFavorites) && !empty($arFavorites)) ? 'active' : '' ?>"></span>
                    Избранное
                </a>
            </div>
            <div class="down-bar__item"><a class="down-bar__link" href="/cart/"><span
                            class="shop-nav__icon shop-nav__icon--cart"></span>Корзина</a></div>
            <div class="down-bar__item">
                <?
                global $USER;
                if ($USER->IsAuthorized()):
                    ?>
                    <a class="down-bar__link" href="/login/"><span
                                class="shop-nav__icon shop-nav__icon--cabinet"></span>Кабинет</a>
                <? else: ?>
                    <button class="btn-reset down-bar__link modal-btn" data-graph-animation="fadeInUp"
                            data-graph-path="login-or-register" data-graph-speed="500" type="button"><span
                                class="shop-nav__icon shop-nav__icon--cabinet"></span>Вход
                    </button>
                <? endif; ?>
            </div>
        </div>
        <div class="region-selection">
            <div class="region-selection__top">
                <p class="g-title g-title--center region-selection__title region-selection__choice">Москва</p>
                <button class="btn-reset region-selection__close">
                    <svg class="svg-icon cross2">
                        <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#cross2"></use>
                    </svg>
                </button>
            </div>
            <div class="region-selection__container">
                <button class="btn-reset region-selection__close">
                    <svg class="svg-icon cross2">
                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#cross2"></use>
                    </svg>
                </button>
                <p class="g-title g-title--center region-selection__title">Выбрите регион</p>
                <form class="change-city" action="#">
                    <input class="change-city__input" type="search" name="s" placeholder="Введите город"
                           oninput="townInput(this.value)">
                    <button class="btn-reset change-city__btn">
                        <svg class="svg-icon search-icon">
                            <use xlink:href="<?= DEFAULT_TEMPLATE_PATH ?>/img/sprites/sprite.svg#search-icon"></use>
                        </svg>
                    </button>
                </form>
                <div class="cities">
                    <div class="cities-main">
                        <button onclick="setLocationByName('Москва')"
                                class="btn-reset cities-main__btn js-region-selection__btn">МОСКВА
                        </button>
                        <button onclick="setLocationByName('Санкт-Петербург')"
                                class="btn-reset cities-main__btn js-region-selection__btn">Санкт-ПЕТеРБУрГ
                        </button>
                        <button onclick="setLocationByName('Уфа')"
                                class="btn-reset cities-main__btn js-region-selection__btn">УФА
                        </button>
                        <button onclick="setLocationByName('Самара')"
                                class="btn-reset cities-main__btn js-region-selection__btn">самара
                        </button>
                        <button onclick="setLocationByName('Нижний Новгород')"
                                class="btn-reset cities-main__btn js-region-selection__btn">нижний-новгород
                        </button>
                    </div>
                    <div class="cities-regions g-filters">
                        <ul class="g-filters__list cities__filters list-reset">
                            <li style="display: none" class="g-filters__item">
                                <button class="btn-reset g-filters__btn" data-filters-path="city">Регион</button>
                            </li>
                            <li class="g-filters__item">
                                <button class="btn-reset g-filters__btn g-filters__btn--active"
                                        data-filters-path="region">Город
                                </button>
                            </li>
                        </ul>
                        <div class="cities-regions__wrapper">
                            <div style="display: none" class="cities-regions__col g-filters__content"
                                 data-filters-target="city">
                                <p class="g-title g-title--center cities-regions__title">Регион</p>
                                <div class="cities-regions__letters"><a class="cities-regions__letter"
                                                                        href="#letter">А</a><a
                                            class="cities-regions__letter" href="#letter">Б</a><a
                                            class="cities-regions__letter" href="#letter">В</a><a
                                            class="cities-regions__letter" href="#letter">Д</a><a
                                            class="cities-regions__letter" href="#letter">Е</a><a
                                            class="cities-regions__letter" href="#letter">З</a><a
                                            class="cities-regions__letter" href="#letter">И</a><a
                                            class="cities-regions__letter" href="#letter">К</a><a
                                            class="cities-regions__letter" href="#letter">Л</a><a
                                            class="cities-regions__letter" href="#letter">М</a><a
                                            class="cities-regions__letter" href="#letter">Н</a><a
                                            class="cities-regions__letter" href="#letter">О</a><a
                                            class="cities-regions__letter" href="#letter">П</a><a
                                            class="cities-regions__letter" href="#letter">Р</a><a
                                            class="cities-regions__letter" href="#letter">С</a><a
                                            class="cities-regions__letter" href="#letter">Т</a><a
                                            class="cities-regions__letter" href="#letter">У</a><a
                                            class="cities-regions__letter" href="#letter">Х</a><a
                                            class="cities-regions__letter" href="#letter">Ч</a><a
                                            class="cities-regions__letter" href="#letter">Я</a></div>
                                <div class="cities-regions__block" data-simplebar>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">А</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Б</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">В</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Г</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Д</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Б</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">А</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Б</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">А</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Б</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">О</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Адыгея респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">Алтай
                                                Алтай респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Алтайский край
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Амурская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Архангельская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Астраханская обл.
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cities-regions__item"><span class="cities-regions__letter">Б</span>
                                        <div class="cities-regions__items">
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Башкортостан респ.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Белгородская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Брянская обл.
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия
                                            </button>
                                            <button class="btn-reset cities-regions__btn js-region-selection__btn">
                                                Бурятия респ.
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cities-regions__col g-filters__content g-filters__content--active"
                                 data-filters-target="region">
                                <?
                                if ($_POST['ajaxTown'] === 'y') $APPLICATION->RestartBuffer();
                                $towns = [];
                                $townFilter = [
                                    '=TYPE.ID' => '5',
                                    '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                                    '=DEPTH_LEVEL' => [3, 4],
                                ];
                                if ($_POST['s']) {
                                    $townFilter['%NAME.NAME'] = $_POST['s'];
                                }
                                $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                                    'filter' => $townFilter,
                                    'select' => array('NAME_RU' => 'NAME.NAME', 'CODE', 'DEPTH_LEVEL', 'ID')
                                ));
                                while ($item = $res->fetch()) {
                                    $towns[mb_substr($item['NAME_RU'], 0, 1, 'UTF-8')][] = $item;
                                }
                                ksort($towns);
                                ?>
                                <p class="g-title g-title--center cities-regions__title">Город</p>
                                <div class="cities-regions__letters">
                                    <? foreach ($towns as $townLetter => $townArray): ?>
                                        <a class="cities-regions__letter"
                                           href="#town<?= $townLetter ?>"><?= $townLetter ?></a>
                                    <? endforeach; ?>
                                </div>
                                <div class="cities-regions__block" data-simplebar>
                                    <? foreach ($towns as $townLetter => &$townArray): ?>
                                        <div class="cities-regions__item" id="town<?= $townLetter ?>">
                                            <span class="cities-regions__letter"><?= $townLetter ?></span>
                                            <div class="cities-regions__items">
                                                <?
                                                sort($townArray);
                                                foreach ($townArray as $town):?>
                                                    <button onclick="setLocationByName('<?= $town['NAME_RU'] ?>')"
                                                            class="btn-reset cities-regions__btn js-region-selection__btn"><?= $town['NAME_RU'] ?></button>
                                                <? endforeach; ?>
                                            </div>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                                <? if ($_POST['ajaxTown'] === 'y') die(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--button.btn-reset.modal-btn(data-graph-animation="custom" data-graph-path="first" data-graph-speed="500") Открыть окно-->
    </header>
    <div class="overlay"></div>
    <main class="main">
        <a class="btn-reset shop-nav__link shop-nav__link--cabinet modal-btn"
           style="opacity: 0;position: absolute;width: 0;height: 0;z-index: -1;" data-graph-animation="fadeInUp"
           data-graph-path="check-code" data-graph-speed="500" type="button"></a>
        <a class="btn-reset shop-nav__link shop-nav__link--cabinet modal-btn"
           style="opacity: 0;position: absolute;width: 0;height: 0;z-index: -1;" data-graph-animation="fadeInUp"
           data-graph-path="news-form-success" data-graph-speed="500" type="button"></a>
        <a class="btn-reset shop-nav__link shop-nav__link--cabinet modal-btn"
           style="opacity: 0;position: absolute;width: 0;height: 0;z-index: -1;" data-graph-animation="fadeInUp"
           data-graph-path="success-form" data-graph-speed="500" type="button"></a>