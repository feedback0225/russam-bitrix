document.addEventListener('DOMContentLoaded',function () {
    //INIT TIMER FORM
    window.initTimerJS = function(selector,minutes){
        $(selector).attr('onclick','');
        var timeMinut = parseInt(minutes) * 60 - 1;
        var timer = setInterval(function () {
            var seconds = timeMinut%60
            var minutes = timeMinut/60%60
            if (timeMinut <= 0) {
                clearInterval(timer);
                document.querySelector(selector).innerHTML = 'отправить код';
                $(selector).attr('onclick','$(\'[onsubmit="return window.registration(this)"]\').submit();');
            } else {
                let strTimer = `${Math.trunc(minutes)}:${seconds}`;
                document.querySelector(selector).innerHTML = strTimer;
            }
            --timeMinut;
        }, 1000);
    }

    //RESERVE
    window.reserveChange = function (t){
        BX.showWait();
        BX.ajax({
            url:      window.location.origin + window.location.pathname + '?showSize='+t.value, // URL отправки запроса
            method:   "GET",
            dataType: "html",
            data: 'showSize='+t.value,
            onsuccess: function(response) { // Если Данные отправлены успешно
                console.log(response);
                $('#reserve_result').html(response);
                var selects = document.querySelectorAll(".g-select");
                if (selects) {
                    selects.forEach(function (el) {
                        var choices = new Choices(el, {
                            searchPlaceholderValue: el.dataset.placeholder,
                            itemSelectText: '',
                            shouldSort: false,
                            noResultsText: 'Не найдено'
                        });
                    });
                }
                var filtersBtn = document.querySelectorAll(".g-filters__btn");
                filtersBtn.forEach(function (el) {
                    el.addEventListener("click", function () {
                        var filtersPath = el.dataset.filtersPath;
                        el.closest(".g-filters").querySelector('.g-filters__btn--active').classList.remove('g-filters__btn--active');
                        el.closest(".g-filters").querySelector("[data-filters-path=\"".concat(filtersPath, "\"]")).classList.add('g-filters__btn--active');
                        var filtersContent = el.closest(".g-filters").querySelectorAll(".g-filters__content");

                        var switchContent = function switchContent(path, element) {
                            var _element$closest, _element$closest$quer;

                            for (var i = 0; i < filtersContent.length; i++) {
                                var _el = filtersContent[i];

                                _el.classList.remove('g-filters__content--active');
                            }

                            (_element$closest = element.closest(".g-filters")) === null || _element$closest === void 0 ? void 0 : (_element$closest$quer = _element$closest.querySelector("[data-filters-target=\"".concat(path, "\"]"))) === null || _element$closest$quer === void 0 ? void 0 : _element$closest$quer.classList.add('g-filters__content--active');
                        };

                        switchContent(filtersPath, el);
                    });
                });
                var readMore = document.querySelectorAll(".read-more");
                readMore.forEach(function (el) {
                    var flag = 0;
                    el.addEventListener("click", function (e) {
                        var fullText = e.currentTarget.closest(".read-more-wrapper").querySelector(".full-text");
                        var text = e.currentTarget.dataset.text;

                        if (flag == 0) {
                            flag++;
                            fullText.classList.add("active");
                            e.currentTarget.innerHTML = 'Свернуть';
                        } else {
                            flag--;
                            fullText.classList.remove("active");
                            e.currentTarget.innerHTML = text;
                        }
                    });
                });
                BX.closeWait();
            },
            onfailure: function (error) {
                console.log(error);
                BX.closeWait();
            },
        });
    }

    var filtersBtn = document.querySelectorAll(".g-filters__btn");
    filtersBtn.forEach(function (el) {
        el.addEventListener("click", function () {
            var filtersPath = el.dataset.filtersPath;
            el.closest(".g-filters").querySelector('.g-filters__btn--active').classList.remove('g-filters__btn--active');
            el.closest(".g-filters").querySelector("[data-filters-path=\"".concat(filtersPath, "\"]")).classList.add('g-filters__btn--active');
            var filtersContent = el.closest(".g-filters").querySelectorAll(".g-filters__content");

            var switchContent = function switchContent(path, element) {
                var _element$closest, _element$closest$quer;

                for (var i = 0; i < filtersContent.length; i++) {
                    var _el = filtersContent[i];

                    _el.classList.remove('g-filters__content--active');
                }

                (_element$closest = element.closest(".g-filters")) === null || _element$closest === void 0 ? void 0 : (_element$closest$quer = _element$closest.querySelector("[data-filters-target=\"".concat(path, "\"]"))) === null || _element$closest$quer === void 0 ? void 0 : _element$closest$quer.classList.add('g-filters__content--active');
            };

            switchContent(filtersPath, el);
        });
    });
    window.loadNextPageIntoContainer = function (page,container,pagination,pageN = 0) {
        BX.showWait();
        BX.ajax({
            url: window.location.origin + page,
            method: 'POST',
            data: 'loadAjax=Y' + (pageN ? '&page='+pageN: ''),
            dataType: 'html',
            onsuccess: function (html) {
                console.log('try to remove pagination');
                if(pageN){
                    container = document.querySelector('[data-page="'+pageN+'"]').closest('.catalog-grid');
                    pagination = document.querySelector('.catalog-pagination[data-pagination-num="'+pageN+'"]')
                    if(pagination) {
                        pagination.remove();
                    }
                    container.innerHTML = container.innerHTML + html;
                } else{
                    if(document.querySelector(pagination)) {
                        document.querySelector(pagination).remove();
                        console.log('pagination removed');
                    }
                    document.querySelector(container).innerHTML = document.querySelector(container).innerHTML + html;
                }

                var products = document.querySelectorAll('.product');
                if (products) {
                    products.forEach(function (prdct) {
                        var currentProduct = prdct;
                        var imageSwitchItems = currentProduct.querySelectorAll('.image-switch__item');
                        var imagePagination = currentProduct.querySelector('.image-pagination');

                        if (imageSwitchItems.length > 1) {
                            imageSwitchItems.forEach(function (el, index) {
                                el.addEventListener('mouseenter', function (e) {
                                    currentProduct.querySelectorAll('.image-pagination__item').forEach(function (el) {
                                        el.classList.remove('image-pagination__item--active');
                                    });
                                    currentProduct.querySelector(".image-pagination__item[data-index=\"".concat(e.currentTarget.dataset.index, "\"]")).classList.add('image-pagination__item--active');
                                });
                                el.addEventListener('mouseleave', function (e) {
                                    currentProduct.querySelectorAll('.image-pagination__item').forEach(function (el) {
                                        el.classList.remove('image-pagination__item--active');
                                    });
                                    currentProduct.querySelector(".image-pagination__item[data-index=\"0\"]").classList.add('image-pagination__item--active');
                                });
                            });
                        }
                    });
                }
                BX.closeWait();
            },
            onfailure: function (error) {
                console.log(error);
            },
        });
    };
    window.add2Favorite = function (t,id) {
        var productId = id;
        var param = 'id='+id;
        BX.ajax({
            url:     '/local/ajax/add2Favorite.php', // URL отправки запроса
            method:     "POST",
            dataType: "html",
            cache: false,
            data: param,
            onsuccess: function(response) { // Если Данные отправлены успешно
                var result = $.parseJSON(response);
                console.log(result);
                if(result[0] == 1){
                    VK.Retargeting.ProductEvent(272020,'add_to_wishlist',{'products': [{'id':id}]});
                    $(t).addClass('active');
                } else {
                    VK.Retargeting.ProductEvent(272020,'remove_from_wishlist',{'products': [{'id':id}]});
                    if($('.favoritesPage').length){
                        $(t).parents('.catalog-list__item').remove();
                    } else {
                        $(t).removeClass('active');
                    }
                }
                $('.shop-nav__link--favorite .shop-nav__quantity').html(result[1]);
                if(result[1] > 0){
                    $('.down-bar .shop-nav__icon--favorite').addClass('active');
                } else {
                    $('.down-bar .shop-nav__icon--favorite').removeClass('active');
                }
            },
            onfailure: function (error) {
                console.log(error);
            },
        });
    };
    window.clearFavorites = function (){
        BX.ajax({
            url:     '/local/ajax/clearFavorites.php', // URL отправки запроса
            method:     "POST",
            dataType: "html",
            data: '',
            onsuccess: function(response) { // Если Данные отправлены успешно
                window.location = window.location;
            },
            onfailure: function (error) {
                console.log(error);
            },
        });
    };
    window.basket = function (t) {
        var id = $(t).attr('data-basket-id');
        if($(t).hasClass('active')) {
            window.location = '/cart/';
            return false;
            var action = 'remove';
        } else {
            var action = 'add';
        }
        var param = 'id='+id+'&action='+action;
        BX.ajax({
            url:     '/local/ajax/basket.php', // URL отправки запроса
            method:     "POST",
            dataType: "html",
            data: param,
            onsuccess: function(response) { // Если Данные отправлены успешно
                var result = $.parseJSON(response);
                console.log(result);
                if(action == 'remove'){
                    VK.Retargeting.ProductEvent(272020,'remove_from_cart',{'products': [{'id':id}]});
                    $(t).html('В корзину');
                    $(t).removeClass('active');
                } else if(action == 'add'){
                    VK.Retargeting.ProductEvent(272020,'add_to_cart',{'products': [{'id':id}]});
                    $(t).html('✓&nbsp;&nbsp;&nbsp;&nbsp;Изделие в корзине');
                    $(t).addClass('active');
                    VK.Goal('add_to_cart');
                    yaCounter5138863.reachGoal('add-to-cart');
                }
                $('.basketCountDOM').html(result);
            },
            onfailure: function (error) {
                console.log(error);
            },
        });
    };

    window.submitForm = function (t,formTemplate){
        if(!$(t).valid()) return false;
        BX.showWait();
        if($(t).find('input[name="mailTemplate"]').length){
            console.log($(t).find('input[name="mailTemplate"]').val());
            if($(t).find('input[name="mailTemplate"]').val() == 'SITE_SEND_ORDER'){
                yaCounter5138863.reachGoal('fast-order');
            } else if($(t).find('input[name="mailTemplate"]').val() == 'GET_PRODUCT_PRICE'){
                yaCounter5138863.reachGoal('get-price');
            }
        }
        BX.ajax({
            url:     '/local/mail/'+formTemplate+'.php', // URL отправки запроса
            method:     "POST",
            dataType: "html",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                VK.Goal('lead');
                BX.closeWait();
                if(response){
                   window.location = '/thanks/?orderID='+response;
               }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.orderCancelRequest = function(t,formTemplate){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/mail/'+formTemplate+'.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.subscription = function(t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/subscribe.php', // URL отправки запроса
            method:   "POST",
            dataType: "html",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                var res = JSON.parse(response);
                console.log(res);
                $('.subscribe-form__btn').html(res.MESSAGE);
                VK.Goal('lead');
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.login = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/auth.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response){
                    if(response.message){
                        $('.loginErrors').html(response.message);
                    } else if(response.status == true){
                        window.location = '/login/';
                    }
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.registration = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/registration.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response){
                    if(response.message === 'sent'){
                        // window.location = '/personal/';
                        $('.registerLogin').val(response.to);
                        $('.codeSentMessage').html('Мы отправили код подтверждения на ' + response.to);
                        $('[data-graph-path="check-code"]')[0].click();
                        window.initTimerJS('#register_timer',1);
                    } else if(response.message){
                        $('.registrationErrors').html(response.message);
                    }
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.checkCodeAndRegister = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/checkCodeAndRegister.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response){
                    if(response.message === 'enter'){
                        window.location = '/login/';
                    } else if(response.message){
                        $('.checkCodeErrors').html(response.message);
                    }
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.restorePassword = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/restorePassword.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response){
                    if(response.message == 'Контрольная строка для смены пароля выслана.'){
                        $('.loginToRestore').val(response.login);
                        $('.changePasswordErrors').html('Контрольная строка для смены пароля выслана.');
                        $('.restorePasswordStep1').addClass('active');
                        $('.restorePasswordStep2').addClass('active');
                    } else if(response.message){
                        $('.restoreErrors').html(response.message);
                    }
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.changePassword = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/changePassword.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response){
                    if(response.message == 'Пароль успешно сменен.'){
                        $('.restorePasswordStep2').removeClass('active');
                        $('.restorePasswordStep3').addClass('active');
                    } else if(response.MESSAGE){
                        $('.changePasswordErrors').html(response.MESSAGE);
                    }
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
    window.logout = function () {
        $.ajax({
            url:     '/local/ajax/logout.php', // URL отправки запроса
            type:     "POST",
            dataType: "html",
            data: '',
            success: function(response) { // Если Данные отправлены успешно
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown){ // Ошибка
                console.log('Error: '+ errorThrown);
            }
        });
    };
    window.generateCoupon = function (t) {
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/generateCoupon.php', // URL отправки запроса
            method:   "POST",
            dataType: "json",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                console.log(response);
                if(response != 'ERROR'){
                    $('[data-graph-target="reduce-price"] .modal-content').html('<h2 class="g-title g-title--center modal__title">Купон был успешно отправлен</h2>');
                } else {
                    $('[data-graph-target="reduce-price"] .modal-content').html('<h2 class="g-title g-title--center modal__title">Ошибка</h2>');
                }
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }

    window.setInputValueByClass = function (id,value){
        $(id).val(value);
    }

    $('.validate-form-backend').each(function () {
        $(this).validate({
            rules: {
                phoneNumber: {
                    required: true,
                    minlength: 17,
                    maxlength: 17
                },
                promocode: {
                    required: true
                },
                value: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $('.btn-order-save')[0].click();
            }
        });
    });
    $('.locationSelect').on('change',function () {
        var currentOption = $(this).find('option').html();
        $('.locationSelect').each(function () {
            $(this).parent().find('.choices__item').html(currentOption);
        });
        BX.saleOrderAjax.changeLoc(this.value);
    });

    window.myMap = {};
    BX.addCustomEvent('onBasketChange',function(){
        console.log('onBasketChange');
        if($('.order-form').length){
            BX.Sale.OrderAjaxComponent.sendRequest('refreshOrderAjax');
        }
        var steppers = document.querySelectorAll('.g-stepper');
        steppers.forEach(function (stepper) {
            var stepperInput = stepper.querySelector('.g-stepper__input');
            var stepperBtnUp = stepper.querySelector('.g-stepper__btn--up');
            var stepperBtnDown = stepper.querySelector('.g-stepper__btn--down');
            var count = stepperInput.value;

            if (count <= 1) {
                stepperBtnDown.classList.add('g-stepper__btn--disabled');
            } else {
                stepperBtnDown.classList.remove('g-stepper__btn--disabled');
            }

            var isNotApple = function isNotApple() {
                if (!/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                    return false;
                }

                return true;
            };

            function allowNumbersOnly(e) {
                var code = e.which ? e.which : e.keyCode;

                if (code > 31 && (code < 48 || code > 57)) {
                    e.preventDefault();
                }
            }

            stepperInput.addEventListener('keyup', function (e) {
                var self = e.currentTarget;

                if (self.value == '0') {
                    self.value = 1;
                }

                if (isNotApple) {
                    self.style.width = "".concat(self.value.length + 1, "ex");
                } else {
                    self.style.width = "".concat(self.value.length + 2, "ex");
                }

                count = stepperInput.value;

                if (count == 1) {
                    stepperBtnDown.classList.add('g-stepper__btn--disabled');
                } else {
                    stepperBtnDown.classList.remove('g-stepper__btn--disabled');
                }
            });
            stepperInput.addEventListener('keypress', function (e) {
                allowNumbersOnly(e);
            });
            stepperInput.addEventListener('change', function (e) {
                var self = e.currentTarget;

                if (!self.value) {
                    self.value = 1;
                }

                count = stepperInput.value;

                if (count == 1) {
                    stepperBtnDown.classList.add('g-stepper__btn--disabled');
                } else {
                    stepperBtnDown.classList.remove('g-stepper__btn--disabled');
                }
            });
            stepperBtnUp.addEventListener('click', function (e) {
                e.preventDefault();
                count++;

                if (count == 1) {
                    stepperBtnDown.classList.add('g-stepper__btn--disabled');
                } else {
                    stepperBtnDown.classList.remove('g-stepper__btn--disabled');
                }

                stepperInput.value = count;

                if (isNotApple) {
                    stepperInput.style.width = "".concat(stepperInput.value.length + 1, "ex");
                } else {
                    stepperInput.style.width = "".concat(stepperInput.value.length + 2, "ex");
                }
            });
            stepperBtnDown.addEventListener('click', function (e) {
                e.preventDefault();
                count--;

                if (count == 1) {
                    stepperBtnDown.classList.add('g-stepper__btn--disabled');
                } else {
                    stepperBtnDown.classList.remove('g-stepper__btn--disabled');
                }

                stepperInput.value = count;

                if (isNotApple) {
                    stepperInput.style.width = "".concat(stepperInput.value.length + 1, "ex");
                } else {
                    stepperInput.style.width = "".concat(stepperInput.value.length + 2, "ex");
                }
            });
        });
    });
    BX.addCustomEvent('onAjaxSuccess', function(p1,p2,p3){
        var observer = lozad(".lozad");
        observer.observe();
        if($('.order-form').length){
            BX.EShopLogistic.Delivery.sale_order_ajax.getPvz = function (e,name = 'no name') {
                let pvzTitle;
                let choosenPvz = BX(e.dataset.code);

                //pvzTitle = choosenPvz.textContent;
                pvzTitle = name;
                $('.selectedPVZ').html(pvzTitle);
                BX.adjust(BX('eslogistic-description'), { text: pvzTitle});

                if(choosenPvz.dataset.postamat == 1) {
                    pvzTitle += pvzTitle + ' (POSTAMAT)';
                }

                $('.ordering__map').addClass('point_selected');
                if($('.map_switch.switch-tabs__btn--active').length){
                    window.myMap.container.fitToViewport();
                }

                $('.map-right__address').html(name);
                $('.map-right__hours span').html($(e).attr('data-work'));
                $('.map-right__tel').html('Tel.: ' + $(e).attr('data-phone'));
                // $('.map-right__price').html(window.deliveryPVZPriceFrom+"* "+window.deliveryPVZTimeFrom);
                $('.map-right__price').html(window.deliveryPVZTimeFrom);

                BX.adjust(BX('eslogic-pvz-value'), {props: { value: e.dataset.code+', '+pvzTitle}});
                BX.adjust(BX('eslogistic-btn-choose-pvz'), {text: BX.message('ESHOP_LOGISTIC_CHANGE_PVZ_BTN')});
            };

            BX.EShopLogistic.Delivery.sale_order_ajax.getPvzList = function(profileId) {
                console.log('getPvzList');
                let locationFieldId = BX.Sale.OrderAjaxComponent.deliveryLocationInfo.loc;
                let locationInput = document.querySelector('input[name=ORDER_PROP_'+locationFieldId+']');
                let paymentInput = document.querySelector('input[name=PAY_SYSTEM_ID]:checked');
                if(!locationInput){
                    var request = BX.ajax.runAction('eshoplogistic:delivery.api.ajaxhandler.getDefaultCity');

                    request.then(function(response){
                        locationInput = response.data[0]
                        BX.EShopLogistic.Delivery.sale_order_ajax.initPvzList(locationFieldId, locationInput, paymentInput, profileId)
                    });
                }else{
                    BX.EShopLogistic.Delivery.sale_order_ajax.initPvzList(locationFieldId, locationInput.value, paymentInput, profileId)
                }

            };

            BX.EShopLogistic.Delivery.sale_order_ajax.initPvzList = function (locationFieldId, locationInput, paymentInput, profileId){
                console.log('initPvzList');
                let width = window.screen.width/2;
                let height = window.screen.height/2;

                let map_container = BX.create({
                    tag:'div',
                    props: {className: 'ymap-container'},
                    children: [
                        BX.create({
                            tag:'div',
                            props: {id: 'eslogic-loader', className: 'loader loader-default is-active'}
                        }),
                        BX.create({
                            tag:'div',
                            props: {id: 'elog_pvz_map'},
                            style: {height: height+'px', width: width+'px'}
                        }),
                    ]
                });

                // popup = BX.PopupWindowManager.create("elog_pvz_popup", "", {
                //     content: map_container,
                //     width: 'auto',
                //     height: 'auto',
                //     zIndex: 100,
                //     closeIcon: {
                //         opacity: 1
                //     },
                //     overlay : true,
                //     closeByEsc: true,
                //     darkMode: false,
                //     autoHide: true,
                //     draggable: false,
                //     resizable: false,
                //     min_height: 100,
                //     min_width: 100,
                //     lightShadow: false,
                //     angle: false,
                //     events: {
                //         onPopupClose: function (PopupWindow) {
                //             PopupWindow.destroy();
                //         }
                //     }
                // });
                //
                // popup.show();

                ymaps.ready(BX.EShopLogistic.Delivery.sale_order_ajax.initYMap);


                var request = BX.ajax.runAction('eshoplogistic:delivery.api.ajaxhandler.getPvzList', {
                    data: {
                        profileId: profileId,
                        locationCode: locationInput,
                        paymentId: paymentInput.value
                    }
                });

                ymaps.ready(function () {
                    request.then(function(response){
                        geoObjects = [];
                        orderMapgeoObjects = [];
                        let curPhone, curWorkTime, contentBody, contentFooter;
                        let pvzList = response.data[0];

                        if(pvzList !== null && pvzList.terminals.length > 0) {
                            var showCartsHTML = '';

                            pvzList.terminals.forEach(function(item, i, pvzList) {

                                if(item.phones) {
                                    curPhone = item.phones;
                                } else {
                                    curPhone = false;
                                }

                                if(item.workTime) {
                                    curWorkTime = item.workTime;
                                } else {
                                    curWorkTime = false;
                                }
                                contentBody = '';
                                if(curPhone) {
                                    contentBody += '<div class="eslog-point-info">'
                                       + BX.message('ESHOP_LOGISTIC_DELIVERY_PHONE') + curPhone + '</div>';
                                }

                                if(item.is_postamat === 1) {
                                    contentBody += '<div class="eslog-point-postamat">'
                                       + BX.message('ESHOP_LOGISTIC_DELIVERY_POSTAMAT') + '</div>';
                                }

                                if(curWorkTime) {
                                    contentBody += '<div class="eslog-point-info">'
                                       + BX.message('ESHOP_LOGISTIC_DELIVERY_WORK_TIME') + curWorkTime + '</div>'
                                       + '<div class="eslog-point-info">'+item.note+'</div>';
                                }

                                if(item.surcharge === 1) {
                                    contentBody += '<div class="eslog-point-add-payment">'
                                       + BX.message('ESHOP_LOGISTIC_DELIVERY_ADDITIONAL_PAYMENT') +'</div>';
                                }

                                contentFooter = '<div class="eslog-point-info">' +
                                   '<a' +
                                   ' onclick="BX.EShopLogistic.Delivery.sale_order_ajax.getPvz(this)"' +
                                   ' href="javascript:void(0)"' +
                                   ' id="eslogistic-btn-choose-pvz"' +
                                   ' class="eslog-btn-default"' +
                                   ' data-code="'+item.code+'"'+
                                   '>' + BX.message('ESHOP_LOGISTIC_DELIVERY_CHOOSE_BTN') +
                                   '</a>' +
                                   '</div>';

                                geoObjects[i] = new ymaps.Placemark([item.lat, item.lon], {
                                    balloonContent: "<div class=\"offices-item map-item\"><div class=\"store-item__right map-item__right\"><a class=\"offices-item__desc offices-item__single-tel\" href=\"#\">Тел.: "+curPhone+"</a><p class=\"offices-item__desc offices-item__location\">"+item.address+"</p><br><p class=\"offices-item__desc offices-item__hours\">"+curWorkTime+"</p><button data-work=\""+curWorkTime+"\" data-phone=\""+curPhone+"\" id=\""+item.code+"\" onclick=\"BX.EShopLogistic.Delivery.sale_order_ajax.getPvz(this,'"+item.address+"');$('#"+item.code+"').click();$(this).html('Выбранно');\" data-postamat=\""+item.is_postamat+"\" data-code=\""+item.code+"\" class=\"btn-reset g-btn g-btn--stroke cart-shop__choice\" type=\"button\">Выбрать</button></div></div>"
                                }, {
                                    preset: 'islands#darkGreenDotIcon',
                                    iconLayout: 'default#image',
                                    iconImageHref: "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                                    iconImageSize: [40, 40],
                                    iconImageOffset: [-20, -30]
                                });

                                //ADDED
                                showCartsHTML += `
                                    <div class="cart-shop">
                                        <div class="cart-shop__text">
                                            <span class="cart-shop__success">вы выбрали</span>
                                            <address class="cart-shop__address">`+item.address+`</address>
                                            <span class="cart-shop__hours">`+curWorkTime+`</span>
                                            <span class="cart-shop__tel">Тел.: `+curPhone+`</span>
                                        </div>
                                        <span class="cart-shop__price">`+window.deliveryPVZTimeFrom+`</span>
                                        <a class="g-link cart-shop__link" href="javascript:void(0)" onclick="$('.map_switch').click();setTimeout(function(){window.myMap.setZoom(15);window.myMap.setCenter(geoObjects[`+i+`].geometry.getCoordinates());geoObjects[`+i+`].balloon.open();},600)">На карте</a>
                                        <button data-work="`+curWorkTime+`" data-phone="`+curPhone+`" id="`+item.code+`" onclick="BX.EShopLogistic.Delivery.sale_order_ajax.getPvz(this,'`+item.address+`')" data-postamat="`+item.is_postamat+`" data-code="`+item.code+`" class="btn-reset g-btn g-btn--stroke cart-shop__choice" type="button">Выбрать</button>
                                    </div>
                                `;
                                //removed "+window.deliveryPVZPriceFrom+`*" <br> ` before "window.deliveryPVZTimeFrom"

                                orderMapgeoObjects[i] = new ymaps.Placemark([item.lat, item.lon], {
                                    balloonContent: "<div class=\"offices-item map-item\"><div class=\"store-item__right map-item__right\"><a class=\"offices-item__desc offices-item__single-tel\" href=\"#\">Тел.: "+curPhone+"</a><p class=\"offices-item__desc offices-item__location\">"+item.address+"</p><br><p class=\"offices-item__desc offices-item__hours\">"+curWorkTime+"</p><button id=\""+item.code+"\" onclick=\"BX.EShopLogistic.Delivery.sale_order_ajax.getPvz(this,'"+item.address+"');$('#"+item.code+"').click();$(this).html('Выбранно');\" data-postamat=\""+item.is_postamat+"\" data-code=\""+item.code+"\" class=\"btn-reset g-btn g-btn--stroke cart-shop__choice\" type=\"button\">Выбрать</button></div></div>"
                                }, {
                                    preset: 'islands#darkGreenDotIcon',
                                    iconLayout: 'default#image',
                                    iconImageHref: "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                                    iconImageSize: [40, 40],
                                    iconImageOffset: [-20, -30]
                                });
                                // var placemark = new ymaps.Placemark([item.lat, item.lon], {
                                //     balloonContent: "\n\t\t\t\t\t<div class=\"offices-item map-item\">\n\t\t\t\t\t\t<img class=\"offices-item__image map-item__image\" src=\"img/no-image.svg\" alt=\"\u041E\u0444\u0438\u0441 1\">\n\t\t\t\t\t\t<div class=\"store-item__right map-item__right\">\n\t\t\t\t\t\t\t<a class=\"offices-item__desc offices-item__single-tel\" href=\"#\">\u0422\u0435\u043B.: 8 (800) 555-32-98</a>\n\t\t\t\t\t\t\t<p class=\"offices-item__desc offices-item__location\">\u0433. \u0421\u0430\u043D\u043A\u0442-\u041F\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433, \u043F\u043B. \u0424\u0430\u0431\u0435\u0440\u0436\u0435, 8</p>\n\t\t\t\t\t\t\t<span class=\"offices-item__metro offices-item__metro--blue\">\n\t\t\t\t\t\t\t\t<svg width=\"28\" height=\"28\" viewBox=\"0 0 28 28\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n\t\t\t\t\t\t\t\t\t<path d=\"M7.74363 8.24606C8.49925 7.42446 9.40929 6.75974 10.4218 6.28984C11.4343 5.81995 12.5295 5.55408 13.6447 5.50743C14.76 5.46077 15.8735 5.63424 16.9217 6.01793C17.97 6.40162 18.9323 6.98801 19.7539 7.74363C20.5755 8.49925 21.2403 9.40929 21.7102 10.4218C22.1801 11.4343 22.4459 12.5295 22.4926 13.6447C22.5392 14.76 22.3658 15.8735 21.9821 16.9217C21.5984 17.97 21.012 18.9323 20.2564 19.7539C19.5008 20.5755 18.5907 21.2403 17.5782 21.7102C16.5657 22.1801 15.4705 22.4459 14.3553 22.4926C13.24 22.5392 12.1265 22.3658 11.0783 21.9821C10.03 21.5984 9.06766 21.012 8.24606 20.2564C7.42446 19.5008 6.75974 18.5907 6.28984 17.5782C5.81995 16.5657 5.55408 15.4705 5.50743 14.3553C5.46077 13.24 5.63424 12.1265 6.01793 11.0783C6.40162 10.03 6.98801 9.06766 7.74363 8.24606L7.74363 8.24606Z\" stroke=\"var(--color)\"></path>\n\t\t\t\t\t\t\t\t\t<path d=\"M18 10V18H16.751V13.045L14.3939 18H13.6061L11.2426 13.045V18H10V10H11.044L13.9968 16.1581L16.9496 10H18Z\" fill=\"var(--color)\"></path>\n\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t<span class=\"offices-item__desc\">\u0441\u0442. \u043C. \u0422\u0435\u0445\u043D\u043E\u043B\u043E\u0433\u0438\u0447\u0435\u0441\u043A\u0438\u0439 \u0438\u043D\u0441\u0442\u0438\u0442\u0443\u0442 - 2</span>\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t<p class=\"offices-item__desc offices-item__hours\">\u041F\u043D\u2014\u041F\u0442 \u0441 10:00 \u0434\u043E 21:00  \u0421\u0431\u2014\u0412\u0441 \u0441 10:00 \u0434\u043E 17:00</p>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t"
                                // }, {
                                //     preset: 'islands#darkGreenDotIcon',
                                //     iconLayout: 'default#image',
                                //     iconImageHref: "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                                //     iconImageSize: [40, 40],
                                //     iconImageOffset: [-20, -30]
                                // });
                                // window.orderMap.geoObjects.add(placemark);
                            });

                            clusterer = new ymaps.Clusterer({
                                preset: 'islands#darkGreenClusterIcons',
                            }),
                               clusterer.add(geoObjects);

                            window.myMap.geoObjects.add(clusterer);

                            window.myMap.setBounds(clusterer.getBounds(), {
                                checkZoomRange: true
                            });

                            $('.cart-shops .simplebar-content').html(showCartsHTML);
                            var cartShopChoiceBtns = document.querySelectorAll(".cart-shop__choice");
                            var cartShops = document.querySelectorAll(".cart-shop");
                            function handleChoice() {
                                var target = this.textContent;
                                var parent = this.closest(".cart-shop");
                                target !== 'Изменить выбор' ? target = 'Изменить выбор' : target = "Выбрать";
                                this.textContent = target;
                                cartShops.forEach(function (el) {
                                    return el.classList.toggle("cart-shop--hidden");
                                });

                                if(target === 'Изменить выбор'){
                                    console.log('choose!');
                                    $('.cart-shop').addClass('cart-shop--hidden');
                                    $('.cart-shop.cart-shop--selected').removeClass('cart-shop--selected');
                                    $(parent).removeClass('cart-shop--hidden');
                                    $(parent).addClass('cart-shop--selected');
                                    $('.cart-shop button').html('Выбрать');
                                    $(this).html('Изменить выбор');
                                } else {
                                    console.log('rechoose!');
                                    $('.ordering__map').removeClass('point_selected');
                                    $('.cart-shop.cart-shop--selected').removeClass('cart-shop--selected');
                                    $(parent).removeClass('cart-shop--hidden');
                                    $('.cart-shop button').html('Выбрать');
                                    $('.ordering__map').removeClass('point_selected');
                                }
                                parent.scrollIntoView({
                                    block: "center"
                                });
                            }
                            cartShopChoiceBtns.forEach(function (el) {
                                return el.addEventListener("click", handleChoice);
                            });
                        } else {
                            if(!p1.order.ID && ($('#ID_DELIVERY_ID_32:checked').length || $('#ID_DELIVERY_ID_33:checked').length)) {
                                console.log('nothing found: ERROR');
                                popup = BX.PopupWindowManager.create("eslog-popup-message", null, {
                                    content: BX.message('ESHOP_LOGISTIC_POPUP_TEXT'),
                                    darkMode: true,
                                    autoHide: true,
                                    buttons: [
                                        new BX.PopupWindowButton({
                                            text: BX.message('ESHOP_LOGISTIC_POPUP_BTN') ,
                                            className: "popup-window-button-accept" ,
                                            events: {
                                                click: function(){
                                                    this.popupWindow.close();
                                                },
                                                onPopupClose: function (PopupWindow) {
                                                    PopupWindow.destroy();
                                                }

                                            }
                                        }),
                                    ]
                                });
                                popup.show();
                            }
                        }


                        BX.removeClass(BX('eslogic-loader'), 'is-active');
                    })
                });
            }

            BX.EShopLogistic.Delivery.sale_order_ajax.initYMap = function () {
                console.log('create map!');
                window.myMap = new ymaps.Map(document.querySelector(".order_map"), {
                    center: [55.76, 37.64],
                    zoom: 5
                }, {
                    searchControlProvider: 'yandex#search'
                })
                window.myMap.controls.remove('geolocationControl'); // удаляем геолокацию
                window.myMap.controls.remove('searchControl'); // удаляем поиск
                window.myMap.controls.remove('trafficControl'); // удаляем контроль трафика
                window.myMap.controls.remove('typeSelector'); // удаляем тип
                window.myMap.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
                window.myMap.controls.remove('zoomControl'); // удаляем контрол зуммирования
                window.myMap.controls.remove('rulerControl'); // удаляем контрол правил

                $('.ordering__map').removeClass('point_selected');
                window.myMap.container.fitToViewport();
            };

            if(p1.order){
                ymaps.ready(function () {
                    if(window.myMap && window.myMap.destroy){
                        window.myMap.destroy();
                    }
                });

                let locationFieldId = BX.Sale.OrderAjaxComponent.deliveryLocationInfo.loc;
                let locationInput = document.querySelector('input[name=ORDER_PROP_'+locationFieldId+']').value;
                let paymentInput = document.querySelector('input[name=PAY_SYSTEM_ID]:checked');
                BX.EShopLogistic.Delivery.sale_order_ajax.initPvzList(locationFieldId, locationInput, paymentInput, 33);
            }

            if($('#ID_DELIVERY_ID_32:checked').length){
                if($('.bx-soa-pp-list-description').length && $('.bx-soa-pp-list-description')[0].innerHTML){
                    var newHTML = "<span>от "+$('.bx-soa-pp-list-description')[0].innerHTML+", </span>"+$('.bx-soa-pp-list-description')[1].innerHTML;
                } else {
                    var newHTML = "<span>Доставка отсутствует.</span>";
                }
                $('#way2PriceTime').html(newHTML);
            } else if($('#ID_DELIVERY_ID_33:checked').length){
                if($('.bx-soa-pp-list-description').length && $('.bx-soa-pp-list-description')[0].innerHTML){
                    window.deliveryPVZPriceFrom = 'от ' + $('.bx-soa-pp-list-description')[0].innerHTML;
                    window.deliveryPVZTimeFrom = $('.bx-soa-pp-list-description')[1].innerHTML;
                    var newHTML = "<span>от "+$('.bx-soa-pp-list-description')[0].innerHTML+", </span>"+$('.bx-soa-pp-list-description')[1].innerHTML;
                    newHTML = '<span>ПВЗ: </span> <small class="selectedPVZ">'+$('.eslogistic-description').html()+'</small><br>' + newHTML;
                    $('.cart-shop__address').each(function(){
                        if(this.innerHTML.replace(/\s/g, '') == $('.eslogistic-description').html().replace(/\s/g, '')) {
                            $(this).closest('.cart-shop').find('.cart-shop__choice').click();
                        }
                    });
                } else {
                    var newHTML = "<span>Пункты выдачи заказов выбранной доставки отсутствуют.</span>";
                }
                $('#way3PriceTime').html(newHTML);
            }
        }
        console.log(p1);
        console.log(p2.url);
        if(p2.url == '/local/ajax/setLocationByName.php') window.location.reload();
        let params = new URLSearchParams(p2.url);
        if(p2.url.indexOf('/filter/') == 0 && p2.url.indexOf('bxajaxid') != -1){
            var selects1 = document.querySelectorAll(".main-selection-select");
            if (selects1) {
                selects1.forEach(function (el) {
                    var choices = new Choices(el, {
                        itemSelectText: '',
                        shouldSort: false,
                        noResultsText: 'Не найдено',
                        callbackOnCreateTemplates: function (template) {
                            return {
                                item: (classNames, data) => {
                                    return template(`
								<div class="${classNames.item} ${data.highlighted ? classNames.highlightedState : classNames.itemSelectable} ${data.placeholder ? classNames.placeholder : ''}" data-item data-id="${data.id}" data-value="${data.value}" ${data.active ? 'aria-selected="true"' : ''} ${data.disabled ? 'aria-disabled="true"' : ''}>
									${data.label}
								</div>
						  `);
                                },
                                choice: (classNames, data) => {
                                    return template(`
                                <div class="${classNames.item} ${classNames.itemChoice} ${data.placeholder ? 'choices__placeholder': ''} ${data.disabled ? classNames.itemDisabled : classNames.itemSelectable}" data-select-text="${this.config.itemSelectText}" data-choice ${data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable'} data-id="${data.id}" data-value="${data.value}" ${data.groupId > 0 ? 'role="treeitem"' : 'role="option"'}>
                                    ${data.label}
                                </div>
                          `);
                                },
                            };
                        },
                    });
                    el.addEventListener('change',function (event) {
                        console.log(this.value.split('_')[1]);
                        if(this.value.split('_')[1] == 32){
                            $('.catalog-filter__checkbox').prop('checked', false);
                            console.log('remove all filters');
                        }
                        $('#'+this.value).click();
                    });
                });
            }
        }
    });
    BX.addCustomEvent('onCatalogElementChangeOffer',function(data){
        if($('.card').length){
            BX.ajax({
                url:      '/local/ajax/checkBasketElement.php', // URL отправки запроса
                method:   "POST",
                dataType: "html",
                data:     'id='+data.newId,
                onsuccess: function(result) { // Если Данные отправлены успешно
                    var result = $.parseJSON(result);
                    if(result){
                        $('.card__btn[data-basket-id]').html('✓&nbsp;&nbsp;&nbsp;&nbsp;Изделие в корзине');
                        $('.card__btn[data-basket-id]').addClass('active');
                    } else {
                        $('.card__btn[data-basket-id]').html('В корзину');
                        $('.card__btn[data-basket-id]').removeClass('active');
                    }
                    $('.card__btn[data-basket-id]').attr('data-basket-id',data.newId);
                },
                onfailure: function (error) {
                    console.log(error);
                },
            });
            BX.showWait();
            BX.ajax({
                url:      window.location.href, // URL отправки запроса
                method:   "POST",
                dataType: "html",
                data:     'insertGetByID='+data.newId,
                onsuccess: function(result) { // Если Данные отправлены успешно
                    $('#productInsertProperty').html(result);
                    BX.closeWait();
                },
                onfailure: function (error) {
                    console.log(error);
                    BX.closeWait();
                },
            });
        }

    });
    // /?type_decoration=arrFilter_32_635199775&set_filter=y&arrFilter_32_635199775=Y&bxajaxid=3b4be9887c469cc97053684a1047ecbd


    var selects = document.querySelectorAll(".g-select-order");
    if (selects) {
        selects.forEach(function (el) {
            var choices = new Choices(el, {
                searchPlaceholderValue: el.dataset.placeholder,
                itemSelectText: '',
                shouldSort: true,
                sorter: function(a, b) {
                    // console.log(b.label);
                    // console.log(b.label > a.label);
                    return b.label > a.label ? -10 : 10;
                },
                noResultsText: 'Не найдено'
            });
        });
    }

    var bonusTimer;
    window.loadThisPage = function (inputValue = 0){
        if(bonusTimer) {
            clearTimeout(bonusTimer);
        };
        bonusTimer = setTimeout(function(){
            console.log('loadPage!');
            BX.showWait();
            BX.ajax({
                url:      window.location.href, // URL отправки запроса
                method:   "POST",
                dataType: "html",
                data: 'ajax=y&inputValue='+inputValue,
                onsuccess: function(response) { // Если Данные отправлены успешно
                    $('.blog_load_container').html(response);
                    BX.closeWait();
                },
                onfailure: function (error) {
                    BX.closeWait();
                    console.log(error);
                },
            });
        }, 500);
    }

    window.townInput = function (inputValue = 0){
        if(bonusTimer) {
            clearTimeout(bonusTimer);
        };
        bonusTimer = setTimeout(function(){
            console.log('townChange!');
            BX.showWait();
            BX.ajax({
                url:      window.location.href, // URL отправки запроса
                method:   "POST",
                dataType: "html",
                data: 'ajaxTown=y&s='+inputValue,
                onsuccess: function(response) { // Если Данные отправлены успешно
                    $('[data-filters-target="region"]').html(response);
                    BX.closeWait();
                },
                onfailure: function (error) {
                    BX.closeWait();
                    console.log(error);
                },
            });
        }, 500);
    }
    window.setLocationByName = function(town){
        BX.showWait();
        BX.ajax({
            url:      '/local/ajax/setLocationByName.php', // URL отправки запроса
            method:   "POST",
            dataType: "html",
            data: 'townName='+town,
            onsuccess: function(response) { // Если Данные отправлены успешно
                BX.closeWait();
                $('.region-selection__close').click();
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });
    }

    BX.showWait = function (element) {
        var loader = document.createElement('div');
        loader.innerHTML = '<div class="custom-loader" style="position:fixed;top:50%;left:50%;transform: translate(-50%,-50%);z-index: 10000 !important;"><img src="/local/templates/.default/img/bars.svg" alt="preloader"></div>';
        document.querySelector('body').appendChild(loader);
    };
    BX.closeWait = function (element) {
        if(document.querySelector('body .custom-loader')){
            document.querySelector('body .custom-loader').remove();
        }
    };

    if($('.filters-toggle__quantity').html() > 0){
        $('.filters-toggle__quantity').show();
    }

    if(window.innerWidth >= 768){
        if(document.querySelector(".filters-toggle") && localStorage.getItem('desktopFilter') == 'Open'){
            document.querySelector(".filters-toggle").dispatchEvent(new Event('click'));
        }
    }

    window.newsForm = function (t){
        if(!$(t).valid()) return false;
        BX.showWait();
        BX.ajax({
            url:     '/local/mail/newsForm.php', // URL отправки запроса
            method:     "POST",
            dataType: "html",
            data: $(t).serialize(),
            onsuccess: function(response) { // Если Данные отправлены успешно
                $('[data-graph-path="news-form-success"]')[0].click();
                $('.post-form')[0].reset();
                $('.post-form .post-form__input.error').removeClass('error');
                $('.post-form .g-radio__input.error').removeClass('error');
                BX.closeWait();
            },
            onfailure: function (error) {
                BX.closeWait();
                console.log(error);
            },
        });

        return false;
    }
});