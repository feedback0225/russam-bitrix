<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>
    <?global $USER;?>
    <?if(!$USER->IsAuthorized()) LocalRedirect('/')?>
    <section class="cabinet">
        <div class="container cabinet__container">
            <ul class="g-breadcrumbs__list cabinet__breadcrumbs list-reset">
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link" href="/">Главная</a></li>
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link">Мой кабинет</a></li>
            </ul>
            <h1 class="g-title g-title--center cabinet__title">Мой кабинет</h1>
            <div class="cabinet__body">
                <ul class="cabinet-nav list-reset">
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link" href="/login/order/">мои заказы</a></li>
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link cabinet-nav__link--current" href="/login/">ЛИЧНЫЕ ДАННЫЕ</a></li>
                    <li class="cabinet-nav__item">
                        <button class="btn-reset cabinet-nav__link cabinet-nav__link--gray modal-btn" data-graph-animation="fadeInUp" data-graph-path="bonus" data-graph-speed="500">БОНУСНАЯ ПРОГРАММА
                            <svg class="svg-icon tooltip">
                                <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#tooltip"></use>
                            </svg>
                        </button>
                    </li>
                    <li class="cabinet-nav__item"><a class="cabinet-nav__link" href="javascript:void(0)" onclick="logout()">Выйти</a></li>
                </ul>
                <div class="cabinet-content">
                    <div class="cabinet-content__column">
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Личные данные</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value cabinet-content__value--gray"><?=$USER->GetFullName()?></span>
                                <?if($USER->GetByID($USER->GetID())->Fetch()["PERSONAL_PHONE"]):?>
                                    <span class="cabinet-content__value"><?=$USER->GetByID($USER->GetID())->Fetch()["PERSONAL_PHONE"]?></span>
                                <?endif;?>
                                <?if($USER->GetEmail()):?>
                                    <span class="cabinet-content__value cabinet-content__value--gray"><?=$USER->GetEmail()?></span>
                                <?endif;?>
                                <a class="cabinet-content__edit" href="/login/edit/">
                                    <span>Редактировать данные</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="cabinet-content__column">
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Способ доставки</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value">Курьерская доставка</span>
                                <span class="cabinet-content__value cabinet-content__value--gray">г. Москва, ул. Восточная, д. 36.</span>
                                <span class="cabinet-content__value cabinet-content__value--gray">Позвонить в домофон *202</span>
                                <a class="cabinet-content__edit" href="/login/edit/"><span>Редактировать данные</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <ul class="cabinet-links list-reset">
                        <li class="cabinet-links__item"><a class="g-link cabinet-links__link" href="/delivery-payment/">Доставка и оплата</a></li>
                        <li class="cabinet-links__item"><a class="g-link cabinet-links__link" href="/guarantee/">Гарантия</a></li>
                        <li class="cabinet-links__item"><a class="g-link cabinet-links__link" href="/shops/">Магазины</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>