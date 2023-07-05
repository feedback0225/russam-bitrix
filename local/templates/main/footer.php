            </main>
            <footer class="footer" <?=ERROR_404 == 'Y' ? 'style="display:none"': ''?>>
                <div class="container footer__container">
                    <div class="footer__top">
                        <div class="footer__col">
                            <p class="g-title footer__title">
                                КАТАЛОГ
                                <svg class="svg-icon arrow">
                                    <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#arrow"></use>
                                </svg>
                            </p>
                            <?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu_left", Array(
                                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                                "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                                "MENU_CACHE_TYPE" => "Y",	// Тип кеширования
                                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                                "ROOT_MENU_TYPE" => "bottom_menu_left",	// Тип меню для первого уровня
                                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                                "COMPONENT_TEMPLATE" => ".default"
                            ),
                                false
                            );?>
                        </div>
                        <div class="footer__col">
                            <p class="g-title footer__title footer__title--2">
                                КАРТА САЙТА
                                <svg class="svg-icon arrow">
                                    <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#arrow"></use>
                                </svg>
                            </p>
                            <?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu_center", Array(
                                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                                "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                                "MENU_CACHE_TYPE" => "Y",	// Тип кеширования
                                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                                "ROOT_MENU_TYPE" => "bottom_menu_center",	// Тип меню для первого уровня
                                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                                "COMPONENT_TEMPLATE" => ".default"
                            ),
                                false
                            );?>
                        </div>
                        <div class="footer__col">
                            <?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu_right", Array(
                                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                                "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                                "MENU_CACHE_TYPE" => "Y",	// Тип кеширования
                                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                                "ROOT_MENU_TYPE" => "bottom_menu_right",	// Тип меню для первого уровня
                                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                                "COMPONENT_TEMPLATE" => ".default"
                            ),
                                false
                            );?>
                        </div>
                        <div class="footer-contacts">
							<div class="tel footer__tel">
                                <span class="tel__desc footer-contacts__desc">Звоните бесплатно по России</span>
                                <a class="tel__value" href="tel:<?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?>"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?></a>
                                <span class="tel__desc footer-contacts__desc"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_WORK_TIME_FOOTER");?></span>
                                <?if(\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_WORK_TIME_FOOTER_S")):?>
                                    <span class="tel__caption"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_WORK_TIME_FOOTER_S")?></span>
                                <?endif;?>
                            </div>
                            <div class="footer-social"><span class="footer-contacts__desc footer-social__title">Наши сообщества</span>
                                <ul class="footer-social__list list-reset">
                                    <li class="footer-social__item">
                                        <a class="footer-social__link" href="tg://resolve?domain=russamocvet" target="_blank">
                                            <svg class="svg-icon telegram">
                                                <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#telegram"></use>
                                            </svg>
                                        </a>
                                    </li>
<!--                                    <li class="footer-social__item">-->
<!--                                        <a class="footer-social__link" href="https://www.instagram.com/russamocvet/" target="_blank">-->
<!--                                            <svg class="svg-icon instagram">-->
<!--                                                <use xlink:href="--><?//=DEFAULT_TEMPLATE_PATH?><!--/img/sprites/sprite.svg#instagram"></use>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </li>-->
                                    <li class="footer-social__item">
                                        <a class="footer-social__link" href="https://vk.com/russammarket" target="_blank">
                                            <svg class="svg-icon vk">
                                                <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#vk"></use>
                                            </svg>
                                        </a>
                                    </li>
<!--                                    <li class="footer-social__item">-->
<!--                                        <a class="footer-social__link" href="https://ru-ru.facebook.com/russam.ru/" target="_blank">-->
<!--                                            <svg class="svg-icon facebook">-->
<!--                                                <use xlink:href="--><?//=DEFAULT_TEMPLATE_PATH?><!--/img/sprites/sprite.svg#facebook"></use>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                            <address class="footer-contacts__desc footer__address">Санкт-Петербург, пл. Фаберже, 8</address>
                            <a class="footer__desc footer__tel--2" href="tel:<?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?>"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?></a>
                            <a class="footer-contacts__desc" href="mailto:<?=\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_EMAIL");?>"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_EMAIL");?></a>
                        </div>
                    </div><span class="footer__copy"><?=date('Y')?> © Русские самоцветы</span>
                    <p class="footer__desc">Предложение не является публичной офертой. Цены на сайте и в розничной сети могут отличаться. Информация на сайте о товаре носит рекламный характер и расценивается как приглашение делать оферты на основании п.1 ст. 437 Гражданского кодекса РФ.</p>
                </div>
            </footer>
            <div class="modal">
                <div class="modal__container" role="dialog" aria-modal="true" data-graph-target="price-request">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Запрос цены</p>
                        <p class="modal__desc modal__desc--center">Мы&nbsp;свяжемся с&nbsp;вами в&nbsp;течение 30&nbsp;мин и&nbsp;сообщим стоимость и&nbsp;условия заказа&nbsp;товара.</p>
                        <form class="modal-form validate-form" action="/ths/?type=default" onsubmit="ym(5138863,'reachGoal','form-send'); return submitForm(this,'createOrder')">
                            <input type="text" value="" name="product" class="orderProductName" style="display: none">
                            <input type="text" value="" name="productPrice" class="orderProductPrice" style="display: none">
                            <input type="text" name="mailTemplate" value="GET_PRODUCT_PRICE" style="display:none;">
<!--                            <input type="hidden" name="order_ths" value="1">-->
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">оставить заявку</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных *в рабочее время</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--2" role="dialog" aria-modal="true" data-graph-target="why-price">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">ПОЧЕМУ <br>НЕТОЧНАЯ ЦЕНА?</p>
                        <p class="modal__desc modal__desc--center">Цена изделия может значительно варьироваться в&nbsp;зависимости от&nbsp;веса готового изделия, характеристик вставок (цвета, чистоты и&nbsp;качества огранки), а&nbsp;также от&nbsp;общего каратного веса драгоценных камней.</p>
                    </div>
                </div>
                <div class="modal__container" role="dialog" aria-modal="true" data-graph-target="order-product">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Заявка на изделие под заказ</p>
                        <p class="modal__desc modal__desc--center">Оставьте заявку на&nbsp;консультацию с&nbsp;экспертом, мы&nbsp;перезвоним в&nbsp;течение 30&nbsp;минут*</p>
                        <form class="modal-form validate-form" action="/thanks/" onsubmit="return submitForm(this,'createOrder')">
                            <input type="text" value="" name="product" class="orderProductName" style="display: none">
                            <input type="text" value="" name="productPrice" class="orderProductPrice" style="display: none">
                            <input type="text" name="mailTemplate" value="ORDER_PRODUCT_FROM_TIME" style="display:none;">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">оставить заявку</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных *в рабочее время</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--2" role="dialog" aria-modal="true" data-graph-target="order-my-size">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Заказать изделие по&nbsp;моему&nbsp;размеру</p>
                        <p class="g-title g-title--center modal__subtitle">Изготовим изделие <br> по вашему размеру <span>за&nbsp;7-45&nbsp;дней</span></p>
                        <p class="modal__desc modal__desc--center">Оставьте заявку на консультацию <br> с экспертом, мы перезвоним <br> в течение 30 минут*</p>
                        <form class="modal-form validate-form" action="/thanks/" onsubmit="return submitForm(this,'createOrder')">
                            <input type="text" value="" name="product" class="orderProductName" style="display: none">
                            <input type="text" value="" name="productPrice" class="orderProductPrice" style="display: none">
                            <input type="text" name="mailTemplate" value="ORDER_PRODUCT_SIZE" style="display:none;">
                            <input type="hidden" name="order_ths" value="1">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">оставить заявку</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных *в рабочее время</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--2" role="dialog" aria-modal="true" data-graph-target="use-promocode">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Как использовать промокод?</p>
                        <p class="modal__desc modal__desc--2 modal__desc--center">Укажите полученный промокод <br> при оформлении заказа и&nbsp;<span>получите СКИДКУ 5%. </span>Или сообщите промокод менеджеру.</p>
                        <p class="modal__desc modal__desc--2 modal__desc--center">Скидка закрепляется за вашим номером <br> телефона и действует 14 дней.</p>
                        <p class="modal__desc modal__desc--2 modal__desc--gray modal__desc--center">Скидка действует <span>только при покупке online </span>в&nbsp;интернет-галерее «Русские самоцветы».</p>
                    </div>
                </div>
                <div class="modal__container modal__container--3" role="dialog" aria-modal="true" data-graph-target="reduce-price">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Снизьте цену на <br> товар за 1 минуту</p>
                        <p class="g-title g-title--center modal__subtitle">Получите промокод на <span>скидку 5%</span></p>
                        <p class="modal__desc modal__desc--center">Отправим промокод SMS-сообщением в&nbsp;течение 1&nbsp;минуты. Промокод закрепляется за&nbsp;вашим номером телефона и&nbsp;действует 14&nbsp;дней<br><span>только при покупке online</span></p>
                        <form class="modal-form validate-form" action="#" onsubmit="return generateCoupon(this)">
                            <input class="g-input modal-form__input" type="hidden" name="url" value="<?=$APPLICATION->GetCurDir()?>">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">ПОЛУЧИТЬ ПОМОКОД</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я даю согласие на sms-рассылку</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--4" role="dialog" aria-modal="true" data-graph-target="found-out-size">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Как узнать размер?</p>
                        <p class="modal__desc modal__desc--center">Обмотайте нужный палец ниткой, шнурком или бумажной лентой в самом толстом месте.</p><img class="lozad modal__image" src="<?=DEFAULT_TEMPLATE_PATH?>/img/found-out-size.jpg" srcset="<?=DEFAULT_TEMPLATE_PATH?>/img/found-out-size@2x.jpg" alt="Как узнать размер?">
                        <p class="modal__desc modal__desc--center">Линейкой замерьте полученную длину</p>
                        <form class="modal-form validate-form" action="#">
                            <label class="modal-form__item"><span class="modal-form__caption">Введите результат измерений в миллиметрах</span>
                                <input class="g-input modal-form__input" type="text" name="value" placeholder="ВВЕДИТЕ ПОЛУЧЕННОЕ ЗНАЧЕНИЕ">
                            </label>
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">расчитать</button>
                        </form>
                        <p class="g-title g-title--center modal__title modal__title--md">НУЖНЫЙ ВАМ РАЗМЕР 19</p>
                    </div>
                </div>
                <div class="modal__container modal__container--5" role="dialog" aria-modal="true" data-graph-target="reserve" id="reserve_result">
                    <?if($_GET['showSize'] > 0) $APPLICATION->RestartBuffer();?>
                        <?$APPLICATION->ShowViewContent('reserve');?>
                    <?if($_GET['showSize'] > 0) die();?>
                </div>
                <div class="modal__container modal__container--6" role="dialog" aria-modal="true" data-graph-target="make-reserve">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <button class="btn-reset modal__back modal-btn" data-graph-animation="fadeInUp" data-graph-path="reserve" data-graph-speed="500">Назад
                        <svg class="svg-icon back">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#back"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--2">Оформить резерв</p>
                        <p class="modal__desc modal__desc--sm modal__desc--center">Срок резерва — 2 дня</p>
                        <div class="reserve__content">
                            <div class="reserve__item"><span class="reserve__caption">Адрес пункта выдачи:</span>
                                <div class="list-reserve__item">
                                    <img class="list-reserve__image" id="storeImg" src="<?=DEFAULT_TEMPLATE_PATH?>/img/list-reserve-1.jpg" alt="">
                                    <div class="list-reserve__content">
                                        <div class="list-reserve__text">
                                            <p class="modal__desc list-reserve__street" id="storeAddress">ул. Дзержинского, 35/3</p>
                                            <span class="list-reserve__hours" id="storeWorkTime">Пн-Пт 10:00-20:00, Сб,Вс 10:00-18:00</span>
                                            <a class="modal__desc modal__desc--sm list-reserve__tel" href="tel:+78127777861" id="storePhone">+7 (812) 777-78-61 </a>
                                            <span class="list-reserve__metro">
                                                <svg class="svg-icon metro">
                                                	<use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#metro"></use>
                                                </svg>
                                                <span id="storeDescription">Ленинский пр.</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reserve__item">
                                <span class="reserve__caption">Информация о товаре:</span>
                                <div class="mini-product">
                                    <img class="mini-product__image" id="storeProductImage" src="<?=DEFAULT_TEMPLATE_PATH?>/img/card-1.jpg" alt="">
                                    <div class="mini-product__right">
                                        <span class="mini-product__name-collection" id="storeCollection">NIGHTSHADE</span>
                                        <p class="g-title mini-product__title" id="storeProductName">Кольцо с турмалином и&nbsp;бриллиантами</p>
                                        <span class="mini-product__price">
                                            Цена изделия:<span id="storeProductPrice">77 975 ₽</span>
                                        </span>
                                        <div class="read-more-wrapper" style="display: none">
                                            <div class="insert-product full-text">
                                                <div class="insert-product__item"><span class="insert-product__title">Размер:</span>
                                                    <div class="insert-product__right"><span class="insert-product__caption">15 мм</span></div>
                                                </div>
                                                <div class="insert-product__item"><span class="insert-product__title">Вставка:</span>
                                                    <div class="insert-product__right">
                                                        <div class="insert-product__content">
                                                            <div class="insert-product__color insert-product__color--green"></div><span class="insert-product__caption">Турмалин — 1, огранка «Октагон», 0.16 crt.</span>
                                                        </div>
                                                        <div class="insert-product__content">
                                                            <div class="insert-product__color insert-product__color--black"></div><span class="insert-product__caption">Бриллиант — 10, огранка «Круг», цвет 7, чистота 9, 0.15 crt.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn-reset g-link read-more list-reserve__more" data-text="Развернуть">Развернуть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="modal-form validate-form reserve__form" action="/thanks/?type=reserve" onsubmit="return submitForm(this,'make-reserve')">
                            <input type="hidden" value="reserve" name="type">
                            <input type="text" value="" name="productImage" class="productImage" style="display: none">
                            <input type="text" value="" name="product" class="orderProductName" style="display: none">
                            <input type="text" value="" name="productSeries" class="productSeries" style="display: none">
                            <input type="text" value="" name="productPrice" class="orderProductPrice" style="display: none">
                            <input type="text" value="" name="storeEmail[]" class="storeReserveEmail" style="display: none">
                            <input type="text" value="" name="storeEmail[]" class="storeReserveName" style="display: none">
                            <input type="text" value="" name="storeEmail[]" class="storeReservePhone" style="display: none">
                            <input type="text" value="" name="productVes" class="productVes" style="display: none">
                            <input type="text" value="" name="productSize" class="productSize" style="display: none">
                            <input type="text" value="" name="productNumber" class="productNumber" style="display: none">
                            <input type="text" value="" name="productHref" class="productHref" style="display: none">
                            <textarea type="text" value="" name="productChar" class="productChar" style="display: none"></textarea>
							<!--germana@russamgold.ru-->
							<!--<input type="text" value="SITE_SEND_ORDER" name="mailTemplate" style="display: none">-->
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">оставить заявку</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container" role="dialog" aria-modal="true" data-graph-target="modal-order">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal-order__title">ОФОРМЛЕНИЕ ЗАКАЗА</p>
                        <p class="modal__desc modal__desc--center">Заполните форму, и&nbsp;мы&nbsp;свяжемся с&nbsp;вами для&nbsp;уточнения деталей заказа</p>
                        <form class="modal-form validate-form" action="/thanks/?type=order" onsubmit="return submitForm(this,'createOrder'); ym(5138863,'reachGoal','form-send');">
                            <input type="text" value="" name="product" class="orderProductName" style="display: none">
                            <input type="text" value="" name="productPrice" class="orderProductPrice" style="display: none">
                            <input type="text" value="SITE_SEND_ORDER" name="mailTemplate" style="display: none">
                            <input type="hidden" name="order_ths" value="1">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
							<!--<a class="btn-reset modal__link modal__promocode">Ввести промокод</a>-->
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">Оформить заказ</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked>
                                <span class="modal-form__switch"></span>
                                <span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--3" role="dialog" aria-modal="true" data-graph-target="tel-order">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Оформим заказ <br> по телефону</p>
                        <p class="modal__desc modal__desc--center">Заполните форму, и мы свяжемся с вами для уточнения деталей заказа</p>
                        <form class="modal-form validate-form" action="/thanks/?type=order">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">оформить быстрый заказ</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
                        <div class="modal-tel">
                            <p class="modal-tel__desc">Вы можете связаться с нами по телефону</p><a class="modal-tel__value" href="tel:88005553298">8 (800) 555-32-98</a>
                        </div>
                    </div>
                </div>

                <div class="modal__container modal__container--3" role="dialog" aria-modal="true" data-graph-target="make-recall">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title">Заказать обратный <br> звонок</p>
                        <p class="modal__desc modal__desc--center">Заполните форму, и мы свяжемся с вами в ближайшее время</p>
                        <form class="modal-form validate-form" action="#" onsubmit="return recallMe(this); ym(5138863,'reachGoal','form-send');">
                            <input class="g-input modal-form__input" type="text" name="fio" placeholder="Введите ваше имя">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn recall-form__btn">перезвоните мне</button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
	<!--                        <div class="modal-tel">-->
	<!--                            <p class="modal-tel__desc">Вы можете связаться с нами по телефону</p><a class="modal-tel__value" href="tel:88005553298">8 (800) 555-32-98</a>-->
	<!--                        </div>-->
                    </div>
                </div>

                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="delete-product">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">Подтвердите действие</p>
                        <p class="modal__desc modal__desc--center">Вы уверены, что хотите удалить этот&nbsp;товар?</p>
                        <div class="modal__btns">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn modal-btn" data-graph-animation="fadeInUp" data-graph-path="product-deleted" data-graph-speed="500">Да, удалить</button>
                            <button class="btn-reset g-btn g-btn--stroke modal-form__btn js-modal-close">Нет, оставить</button>
                        </div>
                    </div>
                </div>
                <div class="modal__container" role="dialog" aria-modal="true" data-graph-target="edit-phone">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">ИЗМЕНИТЬ ТЕЛЕФОН</p>
                        <p class="modal__desc modal__desc--center">На указанный телефон придет СМС&nbsp;уведомление</p>
                        <form class="modal-form validate-form" action="#">
                            <input class="g-input modal-form__input" type="tel" name="phoneNumber" placeholder="Введите телефон">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn">Сохранить изменения </button>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked><span class="modal-form__switch"></span><span class="modal-form__desc">Я согласен на обработку персональных данных<span>*в рабочее время</span></span>
                            </label><span class="modal-form__desc modal-form__desc--2">*в рабочее время</span>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="cancel-order">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <form action="" onsubmit="return orderCancelRequest(this,'orderCancelRequest')">
                            <input type="text" name="mailTemplate" value="ORDER_CANCEL_REQUEST" style="display:none;">
                            <input class="orderIDInput" type="text" name="orderID" value="" style="display:none;">
                            <p class="g-title g-title--center modal__title modal__title--light">отменить Заказ №&nbsp;<span class="orderID"></span></p>
                            <p class="modal__desc modal__desc--center">Вы уверены, что хотите отменить заказ?</p>
                            <div class="modal__btns">
                                <button type="submit" class="btn-reset g-btn g-btn--black modal-form__btn modal-btn" data-graph-animation="fadeInUp" data-graph-path="order-cancelled" data-graph-speed="500">Да, удалить</button>
                                <button type="button" class="btn-reset g-btn g-btn--stroke modal-form__btn js-modal-close">Нет, оставить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--2" role="dialog" aria-modal="true" data-graph-target="order-cancelled">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">Заказ № <span class="orderID"></span></p>
                        <p class="modal__desc modal__desc--center">Заказ будет отменен после подтверждения менеджером.</p>
                    </div>
                </div>
                <div class="modal__container modal__container--8" role="dialog" aria-modal="true" data-graph-target="product-deleted">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="modal__desc modal__desc--center">Кольцо из золота с изумрудом и бриллиантами, удалено.</p>
                    </div>
                </div>
                <div class="modal__container modal__container--8" role="dialog" aria-modal="true" data-graph-target="bonus">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="modal__desc modal__desc--center">Бонусная программа <br> будет доступна позже</p>
                    </div>
                </div>
                <div class="modal__container modal__container--8" role="dialog" aria-modal="true" data-graph-target="birthday">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="modal__desc modal__desc--center">Дату рождения можно указать только один раз. Если вы хотите изменить дату обратитесь в службу поддержки</p>
                    </div>
                </div>

                <div class="modal__container modal__container--2" role="dialog" aria-modal="true" data-graph-target="password-recovery">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <div class="restorePasswordStep1">
                            <p class="g-title g-title--center modal__title modal__title--light">восстановление пароля</p>
                            <p class="modal__desc modal__desc--center">Введите адрес электронной почты, который вы&nbsp;указывали при регистрации на сайте.</p>
                            <form class="modal-form validate-form" action="/thanks/?type=default" onsubmit="return restorePassword(this)">
                                <p class="restoreErrors" style="color: red;font-size: 16px;margin: 0 0 13px 0;"></p>
                                <input class="g-input modal-form__input" type="text" name="text" placeholder="ВВЕДИТЕ ТЕЛЕФОН ИЛИ E-mail">
                                <button class="btn-reset g-btn g-btn--black modal-form__btn">Отправить</button>
                                <label class="modal-form__label">
                                    <input class="modal-form__checkbox" type="checkbox" checked>
                                    <span class="modal-form__switch"></span>
                                    <span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                                </label>
                            </form>
                        </div>
                        <div class="restorePasswordStep2">
                            <p class="g-title g-title--center modal__title modal__title--light">Смена пароля</p>
                            <form class="modal-form validate-form" action="/thanks/?type=default" onsubmit="return changePassword(this)">
                                <p class="changePasswordErrors" style="color: red;font-size: 16px;margin: 0 0 13px 0;"></p>
                                <input class="g-input modal-form__input loginToRestore" type="text" name="text" placeholder="ВВЕДИТЕ ТЕЛЕФОН ИЛИ E-mail" readonly>
                                <input class="g-input modal-form__input" type="text" name="control" placeholder="Контрольная строка">
                                <div class="g-input-password modal-form__label modal-form__label--2 js-cabinet-input">
                                    <input class="g-input modal-form__input g-input-password__input" type="password" name="password_1" placeholder="Введите пароль" aria-invalid="false">
                                    <div class="btn-reset g-input-password__btn">
                                        <svg class="svg-icon show-password">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#show-password"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="g-input-password modal-form__label modal-form__label--2 js-cabinet-input">
                                    <input class="g-input modal-form__input g-input-password__input" type="password" name="repeat_password_1" placeholder="Введите пароль" aria-invalid="false">
                                    <div class="btn-reset g-input-password__btn">
                                        <svg class="svg-icon show-password">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#show-password"></use>
                                        </svg>
                                    </div>
                                </div>
                                <button class="btn-reset g-btn g-btn--black modal-form__btn">Отправить</button>
                                <label class="modal-form__label">
                                    <input class="modal-form__checkbox" type="checkbox" checked>
                                    <span class="modal-form__switch"></span>
                                    <span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                                </label>
                            </form>
                        </div>
                        <div class="restorePasswordStep3">
                            <p class="g-title g-title--center modal__title modal__title--light">Пароль успешно изменен!</p>
                        </div>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="login-or-register">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">войти или зарегистрироваться</p>
                        <form class="modal-form validate-form" action="/thanks/?type=default" onsubmit="return window.registration(this)">
                            <p class="registrationErrors" style="color: red;font-size: 16px;margin: 0 0 13px 0;"></p>
                            <input class="g-input modal-form__input" type="text" name="text" placeholder="ВВЕДИТЕ ТЕЛЕФОН ИЛИ E-mail">
<!--                            <div class="g-input-password modal-form__label modal-form__label--2 js-cabinet-input">-->
<!--                                <input class="g-input modal-form__input g-input-password__input" type="password" name="password" placeholder="Введите пароль">-->
<!--                                <div class="btn-reset g-input-password__btn">-->
<!--                                    <svg class="svg-icon show-password">-->
<!--                                        <use xlink:href="--><?//=DEFAULT_TEMPLATE_PATH?><!--/img/sprites/sprite.svg#show-password"></use>-->
<!--                                    </svg>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="g-input-password modal-form__label modal-form__label--2 js-cabinet-input">-->
<!--                                <input class="g-input modal-form__input g-input-password__input" type="password" name="repeat_password" placeholder="Введите пароль повторно">-->
<!--                                <div class="btn-reset g-input-password__btn">-->
<!--                                    <svg class="svg-icon show-password">-->
<!--                                        <use xlink:href="--><?//=DEFAULT_TEMPLATE_PATH?><!--/img/sprites/sprite.svg#show-password"></use>-->
<!--                                    </svg>-->
<!--                                </div>-->
<!--                            </div>-->
                            <button class="btn-reset g-btn g-btn--black modal-form__btn modal-form__btn--2">Получить код</button>
<!--                            Получить код-->
                            <span class="modal-form__bottom">
                                <span>Другие способы входа:</span>
                                <button class="btn-reset modal__link modal-btn" data-graph-animation="fadeInUp" data-graph-path="login-with-password" data-graph-speed="500" type="button">Войти с паролем</button>
                            </span>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked>
                                <span class="modal-form__switch"></span>
                                <span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="check-code">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">Введите код</p>
                        <p class="modal__desc modal__desc--center" style="margin-bottom: 0;">
                            <span class="codeSentMessage" style="font-weight: 300">Мы отправили код подтверждения на </span>
                            <button class="btn-reset modal__link modal-btn" data-graph-animation="fadeInUp" data-graph-path="login-or-register" data-graph-speed="500" type="button">Изменить</button>
                        </p>
                        <form class="modal-form validate-form" action="/thanks/?type=default" onsubmit="return window.checkCodeAndRegister(this)">
                            <p class="checkCodeErrors" style="color: red;font-size: 16px;margin: 0 0 13px 0;text-align: center"></p>
                            <input name="login" class="registerLogin" type="hidden">
                            <input autocomplete="off" class="g-input modal-form__input" type="text" name="text" placeholder="Введите код">
                            <button class="btn-reset g-btn g-btn--black modal-form__btn modal-form__btn--2">Войти</button>
                            <span class="modal-form__bottom modal__desc--center">
                                <p class="modal-form__desc" style="width: 100%;">
                                    Получить новый код можно через <span id="register_timer" style="display: inline-block;color: #000;cursor: pointer;font-weight: 500">0:59</span>
                                </p>
                            </span>
                        </form>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="news-form-success">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">Благодарим за <br> Регистрацию!</p>
                        <p class="modal__desc modal__desc--center">Мы отправим вам SMS со ссылкой<br>на оплату в течение дня.</p>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="success-form">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">Спасибо!</p>
                        <p class="modal__desc modal__desc--center">Мы получили заявку, менеджер перезвонит вам в ближайшее время</p>
                    </div>
                </div>
                <div class="modal__container modal__container--7" role="dialog" aria-modal="true" data-graph-target="login-with-password">
                    <button class="btn-reset modal__close js-modal-close" aria-label="Закрыть модальное окно">
                        <svg class="svg-icon cross2">
                            <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#cross2"></use>
                        </svg>
                    </button>
                    <div class="modal-content">
                        <p class="g-title g-title--center modal__title modal__title--light">войти c паролем</p>
                        <form class="modal-form validate-form" action="/thanks/?type=default" onsubmit="return window.login(this)">
                            <p class="loginErrors" style="color: red;font-size: 16px;margin: 0 0 13px 0;"></p>
                            <input class="g-input modal-form__input" type="text" name="login" placeholder="ВВЕДИТЕ ТЕЛЕФОН ИЛИ E-mail">
                            <div class="g-input-password modal-form__label modal-form__label--2 js-cabinet-input">
                                <input class="g-input modal-form__input g-input-password__input" type="password" name="password" placeholder="Введите пароль">
                                <div class="btn-reset g-input-password__btn">
                                    <svg class="svg-icon show-password">
                                        <use xlink:href="<?=DEFAULT_TEMPLATE_PATH?>/img/sprites/sprite.svg#show-password"></use>
                                    </svg>
                                </div>
                            </div>
                            <button class="btn-reset g-btn g-btn--black modal-form__btn modal-form__btn--2">Войти</button>
<!--                            Получить код-->
                            <span class="modal-form__bottom">
                                <button class="btn-reset modal__link modal__link--2 modal-btn" data-graph-animation="fadeInUp" data-graph-path="password-recovery" data-graph-speed="500" type="button">Забыли пароль?</button>
                            </span>
                            <label class="modal-form__label">
                                <input class="modal-form__checkbox" type="checkbox" checked>
                                <span class="modal-form__switch"></span>
                                <span class="modal-form__desc">Я согласен на обработку персональных данных</span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>

        </div>

		    <!-- Marquiz script start -->
			<script>
        setTimeout(function () {
            (function(w, d, s, o){
                var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
                    if (document.readyState !== 'loading') Marquiz.init(o);
                    else document.addEventListener("DOMContentLoaded", function() {
                        Marquiz.init(o);
                    });
                };
                d.head.insertBefore(j, d.head.firstElementChild);
            })(window, document, 'script', {
                    host: '//quiz.marquiz.ru',
                    region: 'eu',
                    id: '5d8b956a9e4ce000448e11bb',
                    autoOpen: false,
                    autoOpenFreq: 'once',
                    openOnExit: false,
                    disableOnMobile: false
                }
            );
        },5000);
    </script>
    <!-- Marquiz script end -->
	
	<?/*
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '3040499246177137');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=3040499246177137&ev=PageView &noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '6090192951054439');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=6090192951054439&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->*/?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K9QDV9T');</script>
    <!-- End Google Tag Manager -->

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "https://market.russam.ru/",
            "potentialAction": [{
                "@type": "SearchAction",
                "target": "https://market.russam.ru/main/search/?search={searchbox_target}&referrer=sitelinks_searchbox"
            }]
        }
    </script>
    <?
    //"query-input": "required name=searchbox_target"
    ?>

<!-- BEGIN JIVOSITE INTEGRATION WITH ROISTAT -->
<script type='text/javascript'>
    var getCookie = window.getCookie = function (name) {
        var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };
    function jivo_onLoadCallback() {
        jivo_api.setUserToken(getCookie('roistat_visit'));
    }
</script>
<!-- END JIVOSITE INTEGRATION WITH ROISTAT -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9QDV9T" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

		<?/*<!-- VK -->
		<script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src='https://vk.com/js/api/openapi.js?169',t.onload=function(){VK.Retargeting.Init("VK-RTRG-1584520-ertSa"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1584520-ertSa" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!-- VK -->
		*/?>
		<!-- Top.Mail.Ru counter -->
		<script type="text/javascript">
		var _tmr = window._tmr || (window._tmr = []);
		_tmr.push({id: "3312537", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
		(function (d, w, id) {
		if (d.getElementById(id)) return;
		var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
		ts.src = "https://top-fwz1.mail.ru/js/code.js";
		var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
		if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
		})(document, window, "tmr-code");
		</script>
		<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3312537;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
		<!-- /Top.Mail.Ru counter -->

		<!-- Top.Mail.Ru counter -->
		<script type="text/javascript">
		var _tmr = window._tmr || (window._tmr = []);
		_tmr.push({id: "3312539", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
		(function (d, w, id) {
		if (d.getElementById(id)) return;
		var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
		ts.src = "https://top-fwz1.mail.ru/js/code.js";
		var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
		if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
		})(document, window, "tmr-code");
		</script>
		<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3312539;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
		<!-- /Top.Mail.Ru counter -->
        <script>
            (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
            })(window,document,'https://cdn-ru.bitrix24.ru/b22093030/crm/tag/call.tracker.js');
        </script>
    </body>
</html>