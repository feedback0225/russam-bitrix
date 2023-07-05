<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Магазины");
use \Bitrix\Catalog;
\Bitrix\Main\Page\Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?apikey=09fde6c3-515b-47ff-ab53-6876a1f37784&amp;lang=ru_RU');
?>

    <section class="contacts">
        <div class="container contacts__container">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb", Array(
                "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
            ),
                false
            );?>
            <h1 class="g-title g-title--center contacts__title">Магазины</h1>
            <h2 class="g-title contacts__subtitle">Сеть фирменных магазинов</h2>
            <div class="g-filters">
                <?$APPLICATION->IncludeComponent("bitrix:catalog.store.list", "store_list", Array(
                    "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "MAP_TYPE" => "0",	// Тип карты
                    "PATH_TO_ELEMENT" => "store/#store_id#",	// Шаблон пути к странице с информацией о складе
                    "PHONE" => "Y",	// Отображать телефон
                    "SCHEDULE" => "Y",	// Отображать график работы
                    "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                    "TITLE" => "",	// Заголовок страницы
                ),
                    false
                );?>
            </div>
            <?if(\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SHOP_OFFICES")):?>
                <h2 class="g-title contacts__subtitle">Офисы Интернет-галереи</h2>
                <div class="g-filters">
                    <ul class="g-filters__list contacts-filters contacts-filters--3 list-reset">
                        <?foreach (\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SHOP_OFFICES") as $key=>$val):?>
                            <?
                            $arStore = Catalog\StoreTable::getRow([
                                'select' => ['TITLE','ADDRESS','PHONE','IMAGE_ID','SCHEDULE','DESCRIPTION',"SORT"],
                                'filter' => [
                                    'ID' => $val,
//                                    'ACTIVE' => 'Y'
                                ]
                            ]);
                            if ( $arStore )
                            {?>
                                <li class="g-filters__item">
                                    <button class="btn-reset g-filters__btn <?=$key == 0 ? 'g-filters__btn--active': ''?>" data-filters-path="<?=Cutil::translit($arStore['ADDRESS'],"ru",array("replace_space"=>"-","replace_other"=>"-"))?>"><?=$arStore['ADDRESS']?></button>
                                </li>
                            <?}?>
                        <?endforeach;?>
                    </ul>
                    <?foreach (\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SHOP_OFFICES") as $key=>$val):?>
                        <?
                        $arStore = Catalog\StoreTable::getRow([
                            'select' => ['TITLE','ADDRESS','PHONE','IMAGE_ID','SCHEDULE','DESCRIPTION','EMAIL'],
                            'filter' => [
                                'ID' => $val,
//                                'ACTIVE' => 'Y'
                            ]
                        ]);
                        if ( $arStore )
                        {?>
                            <div class="g-filters__content contacts__content <?=$key == 0 ? 'g-filters__content--active': ''?>" data-filters-target="<?=Cutil::translit($arStore['ADDRESS'],"ru",array("replace_space"=>"-","replace_other"=>"-"))?>">
                                <div class="offices-item contacts__offices-item">
                                    <?if($arStore['IMAGE_ID']):?>
                                        <?
                                        if($arStore['IMAGE_ID']){
                                            $image = imageX2($arStore['IMAGE_ID'],450);
                                        }
                                        ?>
                                        <img class="offices-item__image lozad" style="object-fit: none" src="<?=IMG_LOADER?>" data-src="<?=$arStore['IMAGE_ID'] ? $image[0] : '/local/templates/.default/img/no-image.svg'?>" alt="Офис <?=$key?>">
                                    <?endif;?>
                                    <a class="offices-item__desc offices-item__single-tel" href="tel:<?=$arStore['PHONE']?>">
                                        Единый номер: <?=$arStore['PHONE']?> <br>
                                        <br>
                                        <?if($val == 19):?>
                                            Номер в Санкт-Петербурге: 7 (812) 448-65-88
                                        <?elseif($val == 16):?>
                                            Номер в Москве: 7 (495) 649-61-78
                                        <?endif;?>
                                    </a>
                                    <p class="offices-item__desc offices-item__location">
                                        <?=$arStore['ADDRESS']?>
                                    </p>
                                    <span class="offices-item__metro offices-item__metro--yellow">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.74363 8.24606C8.49925 7.42446 9.40929 6.75974 10.4218 6.28984C11.4343 5.81995 12.5295 5.55408 13.6447 5.50743C14.76 5.46077 15.8735 5.63424 16.9217 6.01793C17.97 6.40162 18.9323 6.98801 19.7539 7.74363C20.5755 8.49925 21.2403 9.40929 21.7102 10.4218C22.1801 11.4343 22.4459 12.5295 22.4926 13.6447C22.5392 14.76 22.3658 15.8735 21.9821 16.9217C21.5984 17.97 21.012 18.9323 20.2564 19.7539C19.5008 20.5755 18.5907 21.2403 17.5782 21.7102C16.5657 22.1801 15.4705 22.4459 14.3553 22.4926C13.24 22.5392 12.1265 22.3658 11.0783 21.9821C10.03 21.5984 9.06766 21.012 8.24606 20.2564C7.42446 19.5008 6.75974 18.5907 6.28984 17.5782C5.81995 16.5657 5.55408 15.4705 5.50743 14.3553C5.46077 13.24 5.63424 12.1265 6.01793 11.0783C6.40162 10.03 6.98801 9.06766 7.74363 8.24606L7.74363 8.24606Z" stroke="var(--color)"/>
                                            <path d="M18 10V18H16.751V13.045L14.3939 18H13.6061L11.2426 13.045V18H10V10H11.044L13.9968 16.1581L16.9496 10H18Z" fill="var(--color)"/>
                                        </svg>
                                        <span class="offices-item__desc"><?=$arStore['DESCRIPTION']?></span>
                                    </span>
                                    <p class="offices-item__desc offices-item__hours">
                                        <?=$arStore['SCHEDULE']?>
                                    </p>
                                    <a class="offices-item__link" href="mailto:<?=$arStore['EMAIL']?>"><?=$arStore['EMAIL']?></a>
                                </div>
                                <div class="contacts__map">
                                    <div class="map-style office-map<?=$key?>"></div>
                                </div>
                            </div>
                        <?}?>
                    <?endforeach;?>
                </div>
                <script>
                   document.addEventListener('DOMContentLoaded',function () {
                      <?foreach (\Bitrix\Main\Config\Option::get( "askaron.settings", "UF_SHOP_OFFICES") as $key=>$val):?>
                        <?
                           $arStore = Catalog\StoreTable::getRow([
                               'select' => ['TITLE','ADDRESS','PHONE','IMAGE_ID','SCHEDULE','DESCRIPTION','EMAIL','GPS_N','GPS_S'],
                               'filter' => [
                                   'ID' => $val,
                               ]
                           ]);
                           if ( $arStore ):
                            ?>
                                var maps = document.querySelectorAll(".office-map<?=$key?>");
                                maps.forEach(function (el) {
                                   var _window$ymaps;

                                   console.log(el);
                                   function init() {
                                      var center = [<?=$arStore['GPS_N']?>, <?=$arStore['GPS_S']?>];
                                      var map = new ymaps.Map(el, {
                                         center: center,
                                         zoom: 15
                                      });

                                       <?if($arStore['GPS_N'] && $arStore['GPS_S']):?>
                                          var placemark1 = new ymaps.Placemark([<?=$arStore['GPS_N']?>, <?=$arStore['GPS_S']?>], {
                                             balloonContent: "<div class=\"offices-item map-item\"><img class=\"offices-item__image map-item__image\" src=\"<?=$arStore['IMAGE_ID'] ? CFile::GetPath($arStore['IMAGE_ID']): '/local/templates/.default/img/no-image.svg'?>\" alt=\"\u041E\u0444\u0438\u0441 1\"><div class=\"store-item__right map-item__right\"><a class=\"offices-item__desc offices-item__single-tel\" href=\"tel:<?=$arStore['PHONE']?>\">\u0422\u0435\u043B.: <?=$arStore['PHONE']?></a>\n\t\t\t\t\t\t\t<p class=\"offices-item__desc offices-item__location\"><?=str_replace("'",'',$arStore['ADDRESS'])?></p><span class=\"offices-item__metro offices-item__metro--blue\"><svg width=\"28\" height=\"28\" viewBox=\"0 0 28 28\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7.74363 8.24606C8.49925 7.42446 9.40929 6.75974 10.4218 6.28984C11.4343 5.81995 12.5295 5.55408 13.6447 5.50743C14.76 5.46077 15.8735 5.63424 16.9217 6.01793C17.97 6.40162 18.9323 6.98801 19.7539 7.74363C20.5755 8.49925 21.2403 9.40929 21.7102 10.4218C22.1801 11.4343 22.4459 12.5295 22.4926 13.6447C22.5392 14.76 22.3658 15.8735 21.9821 16.9217C21.5984 17.97 21.012 18.9323 20.2564 19.7539C19.5008 20.5755 18.5907 21.2403 17.5782 21.7102C16.5657 22.1801 15.4705 22.4459 14.3553 22.4926C13.24 22.5392 12.1265 22.3658 11.0783 21.9821C10.03 21.5984 9.06766 21.012 8.24606 20.2564C7.42446 19.5008 6.75974 18.5907 6.28984 17.5782C5.81995 16.5657 5.55408 15.4705 5.50743 14.3553C5.46077 13.24 5.63424 12.1265 6.01793 11.0783C6.40162 10.03 6.98801 9.06766 7.74363 8.24606L7.74363 8.24606Z\" stroke=\"var(--color)\"></path>\n\t\t\t\t\t\t\t\t\t<path d=\"M18 10V18H16.751V13.045L14.3939 18H13.6061L11.2426 13.045V18H10V10H11.044L13.9968 16.1581L16.9496 10H18Z\" fill=\"var(--color)\"></path></svg><span class=\"offices-item__desc\"><?=$arStore['DESCRIPTION']?></span></span><p class=\"offices-item__desc offices-item__hours\"><?=$arStore['SCHEDULE']?></p></div></div>"
                                          }, {
                                             iconLayout: 'default#image',
                                             iconImageHref: "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                                             iconImageSize: [40, 40],
                                             iconImageOffset: [-20, -30]
                                          });
                                       <?endif;?>

                                      map.controls.remove('geolocationControl'); // удаляем геолокацию

                                      map.controls.remove('searchControl'); // удаляем поиск

                                      map.controls.remove('trafficControl'); // удаляем контроль трафика

                                      map.controls.remove('typeSelector'); // удаляем тип

                                      map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим

                                      map.controls.remove('zoomControl'); // удаляем контрол зуммирования

                                      map.controls.remove('rulerControl'); // удаляем контрол правил
                                      // map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
                                      // map.geoObjects.add(placemark);

                                      map.geoObjects.add(placemark1);
                                   }

                                   (_window$ymaps = window.ymaps) === null || _window$ymaps === void 0 ? void 0 : _window$ymaps.ready(init);
                                });
                            <?endif;?>
                      <?endforeach;?>
                   });
                </script>
            <?endif;?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => '/include/recv_ooo_dan.php',
                    "EDIT_TEMPLATE" => ""
                )
            );?>
        </div>
    </section>
<br>
<br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>