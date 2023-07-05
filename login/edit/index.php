<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Изменение данных");
?>
    <?
    global $USER;
    if(!$USER->IsAuthorized()) LocalRedirect('/')?>
    <section class="cabinet">
        <div class="container cabinet__container">
            <ul class="g-breadcrumbs__list cabinet__breadcrumbs list-reset">
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link" href="/">Главная</a></li>
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link" href="/login/">Мой кабинет</a></li>
                <li class="g-breadcrumbs__item"><a class="g-breadcrumbs__link">Личные данные</a></li>
            </ul>
            <a class="cabinet__back" href="/login/">
                <svg class="svg-icon arrow">
                    <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                </svg>
                Назад
            </a>
            <h1 class="g-title g-title--center cabinet__title">ЛИЧНЫЕ ДАННЫЕ</h1>
            <div class="cabinet__body">
                <ul class="cabinet-nav cabinet-nav--inner list-reset">
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
                <form class="cabinet-content validate-form" action="#">
                    <div class="cabinet-content__column">
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Имя, фамилия</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value cabinet-content__value-name"><?=$USER->GetFullName()?></span>
                                <input class="g-input cabinet-content__input cabinet-content__input--text js-cabinet-input" type="text" name="fullName" value="<?=$USER->GetFullName()?>" placeholder="Введите текст">
                                <button class="btn-reset cabinet-content__edit js-toggle-input" data-text="Редактировать данные" type="button">
                                    <span>Редактировать данные</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Пол</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value cabinet-content__value-gender"><?=$USER->GetParam('PERSONAL_GENDER') == 'M' ? 'Мужской': 'Женский'?></span>
                                <div class="cabinet-content__row js-cabinet-input">
                                    <label class="g-radio cabinet-content__radio">
                                        <input class="g-radio__input" type="radio" value="M" name="sex" <?=$USER->GetParam('PERSONAL_GENDER') == 'M' ? 'checked': ''?>>
                                        <span class="g-radio__caption">Мужской</span>
                                    </label>
                                    <label class="g-radio cabinet-content__radio">
                                        <input class="g-radio__input" type="radio" value="F" name="sex" <?=$USER->GetParam('PERSONAL_GENDER') == 'F' ? 'checked': ''?>>
                                        <span class="g-radio__caption">Женский</span>
                                    </label>
                                </div>
                                <button class="btn-reset cabinet-content__edit js-toggle-input" data-text="Изменить пол" type="button"><span>Изменить пол</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Дата рождения</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <p class="birthdayError" style="color: red;font-size: 16px;margin: 0;"></p>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value cabinet-content__value-birthday"><?=$USER->GetByID($USER->GetID())->Fetch()["PERSONAL_BIRTHDAY"]?></span>
                                <span class="cabinet-content__desc">Подарим скидку 10% в день рождения
                                    <svg class="svg-icon tooltip">
                                      <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#tooltip"></use>
                                    </svg>
                                </span>
                                <p class="cabinet-content__warning">Дату рождения можно указать только один раз. Если вы хотите изменить дату обратитесь в службу поддержки</p>
                                <input class="g-input js-cabinet-input cabinet-content__input g-input-date" type="text" name="dateBirthday" placeholder="Введите дату рождения">
                                <button class="btn-reset cabinet-content__edit js-toggle-input" data-text="Редактировать дату рождения" type="button"><span>Редактировать дату рождения</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Пароль</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <p class="passwrdError" style="color: red;font-size: 16px;margin: 0;"></p>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <div class="g-input-password cabinet-content__input-password js-cabinet-input">
                                    <input class="g-input cabinet-content__input g-input-password__input" type="password" name="old_password" placeholder="Введите пароль">
                                    <div class="btn-reset g-input-password__btn">
                                        <svg class="svg-icon show-password">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#show-password"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="g-input-password cabinet-content__input-password js-cabinet-input">
                                    <input class="g-input cabinet-content__input g-input-password__input" type="password" name="password_2" placeholder="Введите новый пароль">
                                    <div class="btn-reset g-input-password__btn">
                                        <svg class="svg-icon show-password">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#show-password"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="g-input-password cabinet-content__input-password js-cabinet-input">
                                    <input class="g-input cabinet-content__input g-input-password__input" type="password" name="repeat_password_2" placeholder="Введите новый пароль повторно">
                                    <div class="btn-reset g-input-password__btn">
                                        <svg class="svg-icon show-password">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#show-password"></use>
                                        </svg>
                                    </div>
                                </div>
                                <button class="btn-reset cabinet-content__edit js-toggle-input" data-text="Изменить пароль" type="button">
                                    <span>Изменить пароль</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="cabinet-content__column">
                        <?if($USER->GetByID($USER->GetID())->Fetch()["PERSONAL_PHONE"]):?>
                            <div class="cabinet-accordion g-accordion isOpen">
                                <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                    <span>Номер телефона</span>
                                    <i class="g-accordion__icon">
                                        <svg class="svg-icon arrow">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                        </svg>
                                    </i>
                                </button>
                                <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                    <span class="cabinet-content__value cabinet-content__value-phone"><?=$USER->GetByID($USER->GetID())->Fetch()["PERSONAL_PHONE"]?></span>
                                    <button class="btn-reset cabinet-content__edit modal-btn" data-graph-animation="fadeInUp" data-graph-path="edit-phone" data-graph-speed="500" type="button">
                                        <span>Редактировать данные</span>
                                        <svg class="svg-icon edit">
                                            <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?endif;?>
                        <?if($USER->GetEmail()):?>
                            <div class="cabinet-accordion g-accordion isOpen">
                            <button class="btn-reset g-accordion__control cabinet-accordion__title" aria-expanded="true" type="button">
                                <span>Электронная почта</span>
                                <i class="g-accordion__icon">
                                    <svg class="svg-icon arrow">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                    </svg>
                                </i>
                            </button>
                            <div class="g-accordion__content cabinet-accordion__content" aria-hidden="false">
                                <span class="cabinet-content__value cabinet-content__value-email"><?=$USER->GetEmail()?></span>
                                <input class="g-input cabinet-content__input cabinet-content__input--text js-cabinet-input" type="email" name="email" value="<?=$USER->GetEmail()?>" placeholder="Введите email">
                                <button class="btn-reset cabinet-content__edit js-toggle-input" data-text="Редактировать email" type="button">
                                    <span>Редактировать Email</span>
                                    <svg class="svg-icon edit">
                                        <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#edit"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <?endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded',function () {
           $('.cabinet-content__edit').on('click',function () {
              if($(this).find('span').html().indexOf('Редактировать email') == 0){
                 console.log('change email!');
                 BX.showWait();
                 BX.ajax({
                    url:      '/local/ajax/changeUserData.php', // URL отправки запроса
                    method:   "POST",
                    dataType: "json",
                    data: 'email='+$('[name="email"]').val(),
                    onsuccess: function(response) { // Если Данные отправлены успешно
                       BX.closeWait();
                       if(response.message == 'Данные были изменены!'){
                            $('.cabinet-content__value-email').html($('[name="email"]').val());
                       } else {
                          $('.cabinet-content__value-email').html(response.message);
                       }
                       console.log(response);
                    },
                    onfailure: function (error) {
                       BX.closeWait();
                       console.log(error);
                    },
                 });
              } else if($(this).find('span').html().indexOf('Редактировать данные') == 0){
                 console.log('change name!');
                 BX.showWait();
                 BX.ajax({
                    url:      '/local/ajax/changeUserData.php', // URL отправки запроса
                    method:   "POST",
                    dataType: "json",
                    data: 'fullName='+$('[name="fullName"]').val(),
                    onsuccess: function(response) { // Если Данные отправлены успешно
                       BX.closeWait();
                       if(response.message == 'Данные были изменены!'){
                          $('.cabinet-content__value-name').html($('[name="fullName"]').val());
                       } else {
                          $('.cabinet-content__value-name').html(response.message);
                       }
                       console.log(response);
                    },
                    onfailure: function (error) {
                       BX.closeWait();
                       console.log(error);
                    },
                 });
              } else if($(this).find('span').html().indexOf('Изменить пол') == 0){
                 console.log('change gender!');
                 BX.showWait();
                 BX.ajax({
                    url:      '/local/ajax/changeUserData.php', // URL отправки запроса
                    method:   "POST",
                    dataType: "json",
                    data: 'sex='+$('[name="sex"]:checked').val(),
                    onsuccess: function(response) { // Если Данные отправлены успешно
                       BX.closeWait();
                       if(response.message == 'Данные были изменены!'){
                          if($('[name="sex"]:checked').val() == 'M'){
                              $('.cabinet-content__value-gender').html('Мужской');
                          } else if($('[name="sex"]:checked').val() == 'F'){
                              $('.cabinet-content__value-gender').html('Женский');
                          }
                       } else {
                          $('.cabinet-content__value-gender').html(response.message);
                       }
                       console.log(response);
                    },
                    onfailure: function (error) {
                       BX.closeWait();
                       console.log(error);
                    },
                 });
              } else if($(this).find('span').html().indexOf('Редактировать дату рождения') == 0){
                 console.log('change birthday!');
                  BX.showWait();
                  BX.ajax({
                      url:      '/local/ajax/changeUserData.php', // URL отправки запроса
                      method:   "POST",
                      dataType: "json",
                      data: 'dateBirthday='+$('[name="dateBirthday"]').val(),
                      onsuccess: function(response) { // Если Данные отправлены успешно
                          BX.closeWait();
                          console.log(response);
                          // birthdayError
                          if(response){
                              if(response.message == 'Данные были изменены!'){
                                $('.cabinet-content__value-birthday').html($('[name="dateBirthday"]').val());
                              } else {
                                $('.birthdayError').html(response.message);
                              }
                          }
                      },
                      onfailure: function (error) {
                          BX.closeWait();
                          console.log(error);
                      },
                  });
              } else if($(this).find('span').html().indexOf('Изменить пароль') == 0){
                 console.log('change password!');
                 BX.showWait();
                 BX.ajax({
                    url:      '/local/ajax/changeUserData.php', // URL отправки запроса
                    method:   "POST",
                    dataType: "json",
                    data: 'old_password='+$('[name="old_password"]').val()+'&password_2='+$('[name="password_2"]').val()+'&repeat_password_2='+$('[name="repeat_password_2"]').val(),
                    onsuccess: function(response) { // Если Данные отправлены успешно
                       BX.closeWait();
                       console.log(response);
                       if(response){
                          if(response.message == 'Данные были изменены!'){
                             $('.passwrdError').html('Пароль успешно изменен!');
                             $('.passwrdError').css({'color':'green'});
                          } else if(response.result.MESSAGE){
                             $('.passwrdError').html(response.result.MESSAGE);
                             $('.passwrdError').css({'color':'red'})
                          } else if(response.message){
                             $('.passwrdError').html(response.message);
                             $('.passwrdError').css({'color':'red'})
                          }
                       }
                    },
                    onfailure: function (error) {
                       BX.closeWait();
                       console.log(error);
                    },
                 });
              }
           });
        });
    </script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>