<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Производство");
?>


    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => '/include/manufacturing.php',
            "EDIT_TEMPLATE" => ""
        )
    );?>
    <section class="subscribe-form">
        <div class="container subscribe-form__container">
            <h2 class="g-title g-title--center subscribe-form__title">Подписка на новости</h2>
            <p class="subscribe-form__desc">Подпишитесь на рассылку и получайте свежие материалы на почту.</p>
            <form class="subscribe-form__form validate-form" action="#" onsubmit="return subscription(this)">
                <div class="subscribe-form__row">
                    <input class="g-input subscribe-form__input" type="email" name="email" placeholder="Email">
                    <button class="btn-reset g-btn g-btn--black subscribe-form__btn">подписаться</button>
                </div>
                <label class="modal-form__label subscribe-form__label">
                    <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                </label>
            </form>
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