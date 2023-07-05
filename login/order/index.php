<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<?//LocalRedirect('/personal/');?>
    <?
    global $USER;
    if(!$USER->IsAuthorized()) LocalRedirect('/')?>
    <section class="orders">
        <div class="container cabinet__container orders__container">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb", Array(
                "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
            ),
                false
            );?>
            <a class="cabinet__back" href="<?=$APPLICATION->GetCurDir() == '/login/order/' ? '/login/' : '/login/order/'?>">
                <svg class="svg-icon arrow">
                    <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                </svg>
                Назад
            </a>
            <?if($APPLICATION->GetCurDir() == '/login/order/'):?>
                <h1 class="g-title g-title--center cabinet__title orders__title">мои заказы</h1>
            <?endif;?>
            <div class="cabinet__body">
                <ul class="cabinet-nav cabinet-nav--inner list-reset">
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link cabinet-nav__link--current">мои заказы</a></li>
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link" href="/login/">ЛИЧНЫЕ ДАННЫЕ</a></li>
                    <li class="cabinet-nav__item">
                        <button class="btn-reset cabinet-nav__link cabinet-nav__link--gray modal-btn" data-graph-animation="fadeInUp" data-graph-path="bonus" data-graph-speed="500">БОНУСНАЯ ПРОГРАММА
                            <svg class="svg-icon tooltip">
                                <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#tooltip"></use>
                            </svg>
                        </button>
                    </li>
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link" href="javascript:void(0)" onclick="logout()">Выйти</a></li>
                </ul>
                <?if($APPLICATION->GetCurDir() == '/login/order/'){
                    $arFilter = Array(
                        "USER_ID" => $USER->GetID(),
                    );

                    $allOrderCount = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter,false,['nPageSize' => 1]);
                    $arFilter = Array(
                        "USER_ID" => $USER->GetID(),
                        "@STATUS_ID" => array("N","P","DT","DS","DN","DG","DF","DDA"),
                        "CANCELED" => "N"
                    );
                    $activeOrderCount = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter,false,['nPageSize' => 1]);

                    $arFilter = Array(
                        "USER_ID" => $USER->GetID(),
                        "@STATUS_ID" => array("F"),
                        "CANCELED" => "N"
                    );
                    $doneOrderCount = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter,false,['nPageSize' => 1]);

                    $arFilter = Array(
                        "USER_ID" => $USER->GetID(),
                        "CANCELED" => "Y"
                    );
                    $canceledOrderCount = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter,false,['nPageSize' => 1]);
                }
                ?>
                <div class="cabinet-content g-filters">
                    <?if($APPLICATION->GetCurDir() == '/login/order/'):?>
                        <ul class="g-filters__list orders-filters list-reset" data-simplebar style="justify-content: flex-start">
                            <a href="/login/order/?show_all=Y" class="g-filters__item orders-filters__item">
                                <button class="<?=$allOrderCount->nSelectedCount > 0 ? '':'orders-filters__btn--gray'?> btn-reset g-filters__btn orders-filters__btn <?=($_GET['show_all']) ? 'g-filters__btn--active': ''?>">ВСЕ ЗАКАЗЫ <?=$allOrderCount->nSelectedCount ? '('.$allOrderCount->nSelectedCount.')': ''?></button>
                            </a>
                            <a href="/login/order/" class="g-filters__item orders-filters__item">
                                <button class="<?=$activeOrderCount->nSelectedCount > 0 ? '':'orders-filters__btn--gray'?> btn-reset g-filters__btn orders-filters__btn <?=($APPLICATION->GetCurDir() == '/login/order/' && !$_GET['show_all'] && !$_GET['filter_history'] && !$_GET['show_canceled']) ? 'g-filters__btn--active': ''?>">активные <?=$activeOrderCount->nSelectedCount ? '('.$activeOrderCount->nSelectedCount.')': ''?></button>
                            </a>
                            <a href="/login/order/?filter_history=Y" class="g-filters__item orders-filters__item">
                                <button class="<?=$doneOrderCount->nSelectedCount > 0 ? '':'orders-filters__btn--gray'?> btn-reset g-filters__btn orders-filters__btn <?=($_GET['filter_history'] && !$_GET['show_canceled']) ? 'g-filters__btn--active': ''?>">ЗАВЕРШЕННЫЕ <?=$doneOrderCount->nSelectedCount ? '('.$doneOrderCount->nSelectedCount.')': ''?></button>
                            </a>
                            <a href="/login/order/?filter_history=Y&show_canceled=Y" class="g-filters__item orders-filters__item">
                                <button class="<?=$canceledOrderCount->nSelectedCount > 0 ? '':'orders-filters__btn--gray'?> btn-reset g-filters__btn orders-filters__btn <?=($_GET['filter_history'] && $_GET['show_canceled']) ? 'g-filters__btn--active': ''?>">ОТМЕНЕННЫЕ <?=$canceledOrderCount->nSelectedCount ? '('.$canceledOrderCount->nSelectedCount.')': ''?></button>
                            </a>
                        </ul>
                    <?endif;?>
                    <div class="g-filters__content orders-content g-filters__content--active">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.personal.order",
                            "personal_order",
                            Array(
                                "ACTIVE_DATE_FORMAT" => "j F Y",
                                "ALLOW_INNER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "3600",
                                "CACHE_TYPE" => "A",
                                "CUSTOM_SELECT_PROPS" => array(""),
                                "DETAIL_HIDE_USER_INFO" => array("0"),
                                "DISALLOW_CANCEL" => "N",
                                "HISTORIC_STATUSES" => array("F"),
                                "NAV_TEMPLATE" => "sale_pagination",
                                "ONLY_INNER_FULL" => "N",
                                "ORDERS_PER_PAGE" => "5",
                                "ORDER_DEFAULT_SORT" => "ID",
                                "PATH_TO_BASKET" => "/cart/",
                                "PATH_TO_CATALOG" => "/products/",
                                "PATH_TO_PAYMENT" => "/login/order/payment/",
                                "PROP_1" => array(),
                                "PROP_2" => array(),
                                "REFRESH_PRICES" => "Y",
                                "RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
                                "SAVE_IN_SESSION" => "Y",
                                "SEF_FOLDER" => "/login/order/",
                                "SEF_MODE" => "Y",
                                "SEF_URL_TEMPLATES" => Array(
                                    "cancel" => "cancel/#ID#/",
                                    "detail" => "detail/#ID#/",
                                    "list" => "index.php"
                                ),
                                "SET_TITLE" => "Y",
                                "STATUS_COLOR_F" => "gray",
                                "STATUS_COLOR_N" => "green",
                                "STATUS_COLOR_P" => "yellow",
                                "STATUS_COLOR_PSEUDO_CANCELLED" => "red"
                            )
                        );?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>