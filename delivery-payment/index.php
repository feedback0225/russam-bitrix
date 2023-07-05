<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка и оплата");
?>

    <section class="delivery-payment g-filters">
        <div class="container delivery-payment__container">
            <ul class="g-breadcrumbs__list delivery-payment__breadcrumbs list-reset">
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link" href="/">Главная</a></li>
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link">Доставка и оплата</a></li>
            </ul>
            <h1 class="g-title g-title--center delivery-payment__title">Доставка и оплата</h1>
            <ul class="g-filters__list delivery-payment__filters list-reset">
                <li class="g-filters__item">
                    <button class="btn-reset g-filters__btn g-filters__btn--active" data-filters-path="delivery">Доставка</button>
                </li>
                <li class="g-filters__item">
                    <button class="btn-reset g-filters__btn" data-filters-path="payment">Оплата</button>
                </li>
            </ul>
            <div class="g-filters__content g-filters__content--active delivery-payment__content" data-filters-target="delivery">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => '/include/delivery-payment/delivery.php',
                        "EDIT_TEMPLATE" => ""
                    )
                );?>
            </div>
            <div class="g-filters__content delivery-payment__content" data-filters-target="payment">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => '/include/delivery-payment/payment.php',
                        "EDIT_TEMPLATE" => ""
                    )
                );?>
            </div>
        </div>
    </section>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => '/include/questions.php',
            "EDIT_TEMPLATE" => ""
        )
    );?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>