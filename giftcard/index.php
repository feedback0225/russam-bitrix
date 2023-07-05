<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подарочная карта");
?>

    <section class="gift_card">
        <div class="container gift_card__container">
            <ul class="g-breadcrumbs__list delivery-payment__breadcrumbs list-reset">
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link" href="/">Главная</a></li>
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link">Подарочная карта</a></li>
            </ul>
            <h1 class="g-title g-title--center delivery-payment__title">Подарочная карта</h1>
            <div class="gift_card__description">
                <p class="gift_card__asc delivery-payment__desc--center">Подарочная карта от русских самоцветов - отличный подарок к любому случаю.
                <p class="gift_card__desc delivery-payment__desc--center">
                    Получать подарки всегда приятно. И мы знаем, что еще приятнее подарки дарить!</br>
                    Подарочная карта от РУССКИХ САМОЦВЕТОВ – отличная идея для тех, кто хочет порадовать своих близких!</p>
            </div>
            <h2 class="g-title g-title--center gift_card__form-name">оформление заявки на подарочную карту</h2>
            <div class="gift_card__form">
                <div class="gift_card__form-left">
                    <form class="modal-form validate-form" action="#" onsubmit="return submitGift(this)" novalidate="novalidate">
                        <input class="g-input modal-form__input" type="text" name="fio" placeholder="Введите ваше имя">
                        <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон" aria-invalid="true">
                        <input class="g-input modal-form__input" type="number" name="nominal" placeholder="Номинал карты" min="5000" aria-invalid="true">
                        <button class="btn-reset g-btn g-btn--black modal-form__btn recall-form__btn">Заказать подарочную карту</button>
                        <label class="modal-form__label">
                            <input class="modal-form__checkbox" type="checkbox" checked=""><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                        </label>
                    </form>
                </div>
                <div class="gift_card__form-right">
                    <img src="/local/templates/.default/img/giftcard/gift.jpg" alt="Подарочная карта" title="Подарочная карта">
                </div>
            </div>
            <div class="gift_card__bottom">
                <div>
                    <h3>ПРАВИЛА ИСПОЛЬЗОВАНИЯ ПОДАРОЧНЫХ КАРТ:</h3>
                    <p>
                        1. Срок действия карты – 1 год с момента приобретения;</br>
                        2. Номинал карты может быть любой от 5000 рублей;</br>
                        3. Если стоимость выбранных изделий превышает номинал карты, возможно произвести доплату; если стоимость выбранных изделий меньше номинала карты, остаток суммы может быть использован для приобретения других изделий в течение срока карты;</br>
                        4. Карта может быть использована для оплаты изделий только в интернет-галерее «Русские самоцветы» по адресу <a href="https://market.russam.ru">market.russam.ru</a>.
                    </p>
                </div>
                <div>
                    <h3>Оплата карты</h3>
                    <p>Оплатить карту можно онлайн, наличными средствами или безналичным способом курьеру или менеджеру в нашем офисе.</p>
                </div>
                <div>
                    <h3>Доставка подарочной карты</h3>
                    <p>Мы осуществляем доставку карт курьером до двери или в пункт самовывоза компании СДЭК по всей России. Также вы можете забрать карту в нашем офисе в Санкт-Петербурге.</p>
                </div>

            </div>




            </p>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>