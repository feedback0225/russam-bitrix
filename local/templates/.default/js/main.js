'use strict';

document.addEventListener('DOMContentLoaded', function () {
    var accordions = document.querySelectorAll('.g-accordion');
    accordions === null || accordions === void 0
        ? void 0
        : accordions.forEach(function (el) {
            new GraphAccordion(el);
        });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var benefitsMoreBtns = document.querySelectorAll('.benefits__more');
    var flag = 0;

    function toggleBenefits(e, hiddenBenefits) {
        hiddenBenefits.forEach(function (el) {
            return el.classList.toggle('benefits__item--hidden');
        });

        if (flag == 0) {
            flag++;
            e.currentTarget.innerHTML = 'Скрыть';
        } else {
            flag--;
            e.currentTarget.innerHTML = 'Все преимущества';
        }
    }

    benefitsMoreBtns === null || benefitsMoreBtns === void 0
        ? void 0
        : benefitsMoreBtns.forEach(function (btn) {
            var benefits = btn.closest('.benefits');
            var hiddenBenefits = benefits.querySelectorAll('.benefits__item--hidden');
            btn.addEventListener('click', function (e) {
                toggleBenefits(e, hiddenBenefits);
            });
        });
});
('use strict');

var userAgent = navigator.userAgent.toLowerCase();
var firefox = /firefox/.test(userAgent);
var chrome = /chrome/.test(userAgent);
var safari = /safari/.test(userAgent);
var opera = /opera/.test(userAgent);

if (navigator.userAgent.indexOf('Mac') > 0) {
    document.body.classList.add('mac-os');

    if (chrome) {
        document.body.classList.add('chrome');
    }

    if (safari) {
        document.body.classList.add('safari');
    }
}

var InternetExplorer = false;
if ((/mozilla/.test(userAgent) && !/firefox/.test(userAgent) && !/chrome/.test(userAgent) && !/safari/.test(userAgent) && !/opera/.test(userAgent)) || /msie/.test(userAgent))
    InternetExplorer = true;
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var cardSliderThumbs = new Swiper('.card-slider__nav', {
        slidesPerView: 'auto',
        spaceBetween: 18,
        watchSlidesProgress: true,
    });
    new Swiper('.card-slider__main', {
        spaceBetween: 18,
        navigation: {
            nextEl: '.card-slider__btn--next',
            prevEl: '.card-slider__btn--prev',
        },
        thumbs: {
            swiper: cardSliderThumbs,
        },
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var cartShopChoiceBtns = document.querySelectorAll('.cart-shop__choice');
    var cartShops = document.querySelectorAll('.cart-shop');

    function handleChoice() {
        var target = this.textContent;
        var parent = this.closest('.cart-shop');
        target !== 'Изменить выбор' ? (target = 'Изменить выбор') : (target = '\u0412\u044B\u0431\u0440\u0430\u0442\u044C');
        this.textContent = target;
        cartShops.forEach(function (el) {
            return el.classList.toggle('cart-shop--hidden');
        });
        parent.classList.toggle('cart-shop--selected');
        parent.classList.remove('cart-shop--hidden');
        parent.scrollIntoView({
            block: 'center',
        });
    }

    cartShopChoiceBtns.forEach(function (el) {
        return el.addEventListener('click', handleChoice);
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var moreFilters = document.querySelectorAll('.catalog-filter__more');

    function loadMoreFilters(e) {
        var filtersContent = e.closest('.catalog-filter__content');
        var hiddenFilters = filtersContent.querySelectorAll('.catalog-filter__item--hidden');
        hiddenFilters.forEach(function (el) {
            return el.classList.remove('catalog-filter__item--hidden');
        });
        e.remove();
    }

    moreFilters === null || moreFilters === void 0
        ? void 0
        : moreFilters.forEach(function (el) {
            el.addEventListener('click', function (e) {
                loadMoreFilters(e.currentTarget);
            });
        });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var catalogFilterTop = document.querySelectorAll('.catalog-filter__top');
    catalogFilterTop.forEach(function (el) {
        return el.addEventListener('click', toggleFilter);
    });

    function toggleFilter() {
        this.closest('.catalog-filter').classList.toggle('isOpen');
    }
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var collectionsSlider = new Swiper('.collections-section-slider', {
        slidesPerView: 'auto',
        centeredSlides: true,
        spaceBetween: 6,
        breakpoints: {
            577: {
                centeredSlides: false,
            },
            769: {
                spaceBetween: 12,
                centeredSlides: false,
            },
        },
        scrollbar: {
            el: '.collections-section-slider__scrollbar',
        },
        navigation: {
            nextEl: '.collections-section-slider__btn--next',
            prevEl: '.collections-section-slider__btn--prev',
        },
    });
});
('use strict');

function _slicedToArray(arr, i) {
    return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}

function _nonIterableRest() {
    throw new TypeError('Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.');
}

function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === 'Object' && o.constructor) n = o.constructor.name;
    if (n === 'Map' || n === 'Set') return Array.from(o);
    if (n === 'Arguments' || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) {
        arr2[i] = arr[i];
    }
    return arr2;
}

function _iterableToArrayLimit(arr, i) {
    var _i = arr == null ? null : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) || arr['@@iterator'];
    if (_i == null) return;
    var _arr = [];
    var _n = true;
    var _d = false;
    var _s, _e;
    try {
        for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
            _arr.push(_s.value);
            if (i && _arr.length === i) break;
        }
    } catch (err) {
        _d = true;
        _e = err;
    } finally {
        try {
            if (!_n && _i['return'] != null) _i['return']();
        } finally {
            if (_d) throw _e;
        }
    }
    return _arr;
}

function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr;
}

document.addEventListener('DOMContentLoaded', function () {
    var countdowns = document.querySelectorAll('.countdown');
    countdowns.forEach(function (el) {
        var dateEndString = el.dataset.count;
        var digitElement = el.querySelectorAll('.countdown__digit'); // Adding of span element to the each digit

        digitElement.forEach(function (el) {
            var digitWrapper = document.createElement('span');
            digitWrapper.classList.add('countdown__digit-num');

            for (var x = 0; x <= 9; x++) {
                var digitItem = document.createElement('span');
                digitItem.innerText = x + '';
                digitWrapper.appendChild(digitItem);
            }

            el.innerHTML = '';
            el.appendChild(digitWrapper);
        }); // main function to run the countdown
        // endTime - Date with time

        function makeCountdown(endTime) {
            var hideDaysIfEmpty = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
            var endTimeParse = Date.parse(endTime) / 1000;
            var now = new Date();
            var nowParse = Date.parse(now) / 1000;
            var timeLeft = endTimeParse - nowParse;
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - days * 86400) / 3600);
            var minutes = Math.floor((timeLeft - days * 86400 - hours * 3600) / 60);
            var seconds = Math.floor(timeLeft - days * 86400 - hours * 3600 - minutes * 60);

            if (timeLeft < 0) {
                days = 0;
                hours = 0;
                seconds = 0;
                minutes = 0;
            }

            if (hours < '10') {
                hours = '0' + hours;
            }

            if (minutes < '10') {
                minutes = '0' + minutes;
            }

            if (seconds < '10') {
                seconds = '0' + seconds;
            }

            if (days <= 0 && hideDaysIfEmpty) {
                var dayElement = el.querySelector('.countdown #timer-day');

                if (dayElement) {
                    dayElement.style.display = 'none';
                }
            } else {
                updateCountdown(days, 'timer-day');
            }

            updateCountdown(hours, 'timer-hour');
            updateCountdown(minutes, 'timer-minute');
            updateCountdown(seconds, 'timer-second');
        } // updating the display

        function updateCountdown(value, elementId) {
            var element = el.querySelector('.countdown #'.concat(elementId));
            var firstDigitElement = element.querySelector('.countdown__digit-first > span');
            var secondDigitElement = element.querySelector('.countdown__digit-second > span');

            if (elementId === 'timer-day') {
                var elementSecond = element.querySelector('.countdown__digit-first');
                var elementHundred = element.querySelector('.countdown__digit-hundred');

                if (value < 10) {
                    value = '0' + value;
                }

                if (value >= 10) {
                    if (elementSecond) {
                        elementSecond.style.display = 'inline-block';
                    }
                }

                if (value >= 100) {
                    if (elementHundred) {
                        elementHundred.style.display = 'inline-block';
                    }
                }
            }

            var digitHeight = secondDigitElement.offsetHeight / 10;
            var _ref = [0, 0],
                firstDigit = _ref[0],
                secondDigit = _ref[1],
                hundredDigit = _ref[2];

            if (elementId === 'timer-day') {
                if (parseInt(value) >= 100) {
                    var _value$toString$split = value.toString().split('').map(Number);

                    var _value$toString$split2 = _slicedToArray(_value$toString$split, 3);

                    hundredDigit = _value$toString$split2[0];
                    firstDigit = _value$toString$split2[1];
                    secondDigit = _value$toString$split2[2];
                    var hundredDigitElement = element.querySelector('.countdown__digit-hundred > span');
                    hundredDigitElement.style.transform = 'translateY(-' + hundredDigit * digitHeight + 'px)';
                } else {
                    var _value$toString$split3 = value.toString().split('').map(Number);

                    var _value$toString$split4 = _slicedToArray(_value$toString$split3, 2);

                    firstDigit = _value$toString$split4[0];
                    secondDigit = _value$toString$split4[1];
                }
            } else {
                var _value$toString$split5 = value.toString().split('').map(Number);

                var _value$toString$split6 = _slicedToArray(_value$toString$split5, 2);

                firstDigit = _value$toString$split6[0];
                secondDigit = _value$toString$split6[1];
            }

            firstDigitElement.style.transform = 'translateY(-' + firstDigit * digitHeight + 'px)';
            secondDigitElement.style.transform = 'translateY(-' + secondDigit * digitHeight + 'px)';
        }

        var countdownInterval = setInterval(function () {
            // Pass the date here
            makeCountdown(new Date(dateEndString), false);
        }, 100);
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var dateInputs = document.querySelectorAll('.g-input-date');
    Datepicker.locales.ru = {
        days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        daysShort: ['Вск', 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Суб'],
        daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        today: 'Сегодня',
        clear: 'Очистить',
        format: 'dd.mm.yyyy',
        weekStart: 1,
        monthsTitle: 'Месяцы',
    };
    dateInputs.forEach(function (el) {
        var datepicker = new Datepicker(el, {
            language: 'ru',
            format: 'dd.mm.yyyy',
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.entry-slider', {
        slidesPerView: 'auto',
        spaceBetween: 25,
        pagination: {
            el: '.entry-slider__pag',
            type: 'bullets',
            clickable: true,
        },
        navigation: {
            nextEl: '.entry-slider__btn--next',
            prevEl: '.entry-slider__btn--prev',
        },
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var catalogToggle = document.querySelector('.filters-toggle');
    var catalogFilters = document.querySelector('.catalog-filters');
    var catalogFiltersClose = document.querySelector('.catalog-filters__close');

    function toggleFilters() {
        this.classList.toggle('isOpen');
        catalogFilters.classList.toggle('isOpen');
        document.body.classList.toggle('filters-open');
    }

    function hiddenFilters() {
        catalogFilters.classList.remove('isOpen');
        document.body.classList.remove('filters-open');
        catalogToggle.classList.remove('isOpen');
    }

    catalogToggle === null || catalogToggle === void 0 ? void 0 : catalogToggle.addEventListener('click', toggleFilters);
    catalogFiltersClose === null || catalogFiltersClose === void 0 ? void 0 : catalogFiltersClose.addEventListener('click', hiddenFilters);
});
var checboxes = document.querySelectorAll('input[type=checkbox]');
checboxes.forEach(function (el) {
    el.addEventListener('change', function (e) {
        console.log(e.currentTarget);
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var sliderTimeline = document.querySelector('.swiper-timeline');
    var buttonPrev = document.querySelector('.history__timeline-prev');
    var buttonNext = document.querySelector('.history__timeline-next');

    var switchContent = function switchContent(path, element, filtersContent) {
        var _element$closest, _element$closest$quer;

        for (var i = 0; i < filtersContent.length; i++) {
            var el = filtersContent[i];
            el.classList.remove('g-filters__content--active');
        }

        (_element$closest = element.closest('.g-filters')) === null || _element$closest === void 0
            ? void 0
            : (_element$closest$quer = _element$closest.querySelector('[data-filters-target="'.concat(path, '"]'))) === null || _element$closest$quer === void 0
                ? void 0
                : _element$closest$quer.classList.add('g-filters__content--active');

        if (sliderTimeline !== null) {
            if (sliderTimeline.querySelector('.swiper-slide:first-child .g-filters__btn--active') !== null) {
                if (buttonPrev !== null) {
                    buttonPrev.classList.add('swiper-button-disabled');
                }
            } else {
                if (buttonPrev !== null) {
                    buttonPrev.classList.remove('swiper-button-disabled');
                }
            }

            if (sliderTimeline.querySelector('.swiper-slide:last-child .g-filters__btn--active') !== null) {
                if (buttonNext !== null) {
                    buttonNext.classList.add('swiper-button-disabled');
                }
            } else {
                if (buttonNext !== null) {
                    buttonNext.classList.remove('swiper-button-disabled');
                }
            }
        }
    };

    if (sliderTimeline !== null) {
        var _moveSlider = function _moveSlider(direction) {
            var countSlides = 10;

            if (window.innerWidth <= 575) {
                countSlides = 7;
            }

            var currentSlide = sliderTimeline.querySelector('.g-filters__btn--active').closest('.swiper-slide');
            var sliderWidth = sliderTimeline.clientWidth;

            if (currentSlide !== null) {
                if (direction == 'next') {
                    var nextSlide = currentSlide.nextElementSibling;

                    if (nextSlide !== null) {
                        currentSlide.querySelector('.g-filters__btn--active').classList.remove('g-filters__btn--active');
                        nextSlide.querySelector('.g-filters__btn').classList.add('g-filters__btn--active');
                        var filtersPath = nextSlide.querySelector('.g-filters__btn').dataset.filtersPath;
                        var filtersContent = nextSlide.closest('.g-filters').querySelectorAll('.g-filters__content');
                        switchContent(filtersPath, nextSlide.querySelector('.g-filters__btn'), filtersContent);

                        if (nextSlide.offsetLeft + swiperTimeline.getTranslate() + 5 >= Math.floor((sliderWidth / countSlides) * (countSlides - 1))) {
                            swiperTimeline.slideTo(swiperTimeline.activeIndex + countSlides - 1);
                        }
                    }
                } else if (direction == 'prev') {
                    var prevSlide = currentSlide.previousElementSibling;

                    if (prevSlide !== null) {
                        currentSlide.querySelector('.g-filters__btn--active').classList.remove('g-filters__btn--active');
                        prevSlide.querySelector('.g-filters__btn').classList.add('g-filters__btn--active');
                        var _filtersPath = prevSlide.querySelector('.g-filters__btn').dataset.filtersPath;

                        var _filtersContent = prevSlide.closest('.g-filters').querySelectorAll('.g-filters__content');

                        switchContent(_filtersPath, prevSlide.querySelector('.g-filters__btn'), _filtersContent);

                        if (prevSlide.offsetLeft + swiperTimeline.getTranslate() - 5 <= (sliderWidth / countSlides) * (countSlides - countSlides)) {
                            swiperTimeline.slideTo(swiperTimeline.activeIndex - countSlides + 1);
                        }
                    }
                } else {
                    if (currentSlide.offsetLeft + swiperTimeline.getTranslate() >= Math.floor((sliderWidth / countSlides) * (countSlides - 2))) {
                        swiperTimeline.slideNext();
                        swiperTimeline.slideNext();
                    }

                    if (currentSlide.offsetLeft + swiperTimeline.getTranslate() <= (sliderWidth / countSlides) * (countSlides - (countSlides - 2))) {
                        swiperTimeline.slidePrev();
                        swiperTimeline.slidePrev();
                    }
                }
            }
        };

        var swiperTimeline = new Swiper(sliderTimeline, {
            slidesPerView: 7,
            // slidesPerGroup: 7,
            spaceBetween: 0,
            //longSwipes: false,
            loop: false,

            /*
      pagination: {
          el: '.history__timeline-pagination',
          clickable: true,
          type: 'progressbar'
      },
      */
            scrollbar: {
                el: '.history__timeline-scrollbar',
                draggable: true,
            },
            navigation: false,
            breakpoints: {
                576: {
                    slidesPerView: 10,
                    slidesPerGroup: 1,
                    allowTouchMove: false, //spaceBetween: 15
                },
            },
        });

        if (buttonPrev !== null) {
            buttonPrev.addEventListener('click', function () {
                _moveSlider('prev');
            });
        }

        if (buttonNext !== null) {
            buttonNext.addEventListener('click', function () {
                _moveSlider('next');
            });
        }
    }

    var filtersBtn = document.querySelectorAll('.g-filters__btn');
    filtersBtn.forEach(function (el) {
        el.addEventListener('click', function () {
            var filtersPath = el.dataset.filtersPath;
            el.closest('.g-filters').querySelector('.g-filters__btn--active').classList.remove('g-filters__btn--active');
            el.closest('.g-filters').querySelector('[data-filters-path="'.concat(filtersPath, '"]')).classList.add('g-filters__btn--active');
            var filtersContent = el.closest('.g-filters').querySelectorAll('.g-filters__content');
            switchContent(filtersPath, el, filtersContent);

            if (sliderTimeline !== null) {
                moveSlider();
            }
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var footerTitles = document.querySelectorAll('.footer__title');
    footerTitles.forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.currentTarget.classList.toggle('active');
            el.closest('.footer__col').querySelector('.footer-menu').classList.toggle('active');
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    const videoWrappers = document.querySelectorAll('.swiper-slide--video');
    if (videoWrappers.length > 0)
        videoWrappers.forEach((videoWrapper) => {
            let video = videoWrapper.querySelector('.hero-slide--video > .hero-slide__video');
            let preview = videoWrapper.querySelector('.hero-slide--video > img');
            console.log(video);
            video.addEventListener('canplaythrough', () => {
                if (video.getAttribute('data-status') === null) {
                    video.setAttribute('data-status', 'played');
                    setTimeout(() => {
                        preview.style.display = 'none';
                        video.play();
                    }, 500);
                }
            });
        });

    let hero = new Swiper('.hero-slider', {
        loop: true,
        navigation: {
            nextEl: '.hero-slider__btn--next',
            prevEl: '.hero-slider__btn--prev',
        },
        pagination: {
            el: '.hero-slider__pag',
            type: 'bullets',
            clickable: true,
        },
    });

    hero.on('activeIndexChange', (e) => {
        let slides = e.slides;
        if (slides[e.activeIndex].classList.contains('swiper-slide--video')) {
            slides[e.activeIndex].children[0].children[0].play();
            if (slides[e.activeIndex].children[0].children[0].getAttribute('data-status') !== 'played') {
                slides[e.activeIndex].children[0].children[0].setAttribute('data-status', 'played');
                setTimeout(() => {
                    if (slides[e.activeIndex].children[0].children[1] !== undefined) {
                        slides[e.activeIndex].children[0].children[1].style.display = 'none';
                    }
                }, 100);
            }

            console.log('Проигрывается');
        } else {
            slides.forEach((i) => {
                if (i.classList.contains('swiper-slide--video') && !i.classList.contains('swiper-slide-duplicate')) {
                    let f = i.children[0].children[0];
                    slides.forEach((j) => {
                        if (j.classList.contains('swiper-slide--video') && j.classList.contains('swiper-slide-duplicate')) {
                            let s = j.children[0].children[0];
                            s.pause();
                            if (f.currentTime > s.currentTime && f.children[0].src === s.children[0].src) {
                                s.currentTime = f.currentTime;
                            } else if (s.currentTime >= f.currentTime && f.children[0].src === s.children[0].src) {
                                f.currentTime = s.currentTime;
                            }
                        }
                    });
                    f.pause();
                    console.log('На паузе');
                }
            });
        }
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var inputPasswordBtns = document.querySelectorAll('.g-input-password__btn');
    inputPasswordBtns.forEach(function (el) {
        el.addEventListener('click', function () {
            var parent = el.closest('.g-input-password');
            var input = parent.querySelector('input');
            input.type !== 'password' ? (input.type = 'password') : (input.type = 'text');
        });
    });
});
('use strict');

var tels = document.querySelectorAll('input[type="tel"]');
tels.forEach(function (el) {
    var isInput = true;
    var phoneMask = IMask(el, {
        mask: '+{7} (000) 000 0000',
    });
    phoneMask.on('accept', function (event) {
        if (event.data == '8' && el.value.length == 5 && isInput) {
            phoneMask.value = '+7 (';
            isInput = false;
        }

        if (phoneMask.value == '') {
            isInput = true;
        }
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.interesting-slider', {
        spaceBetween: 12,
        slidesPerView: 1,
        breakpoints: {
            577: {
                slidesPerView: 2,
            },
            769: {
                slidesPerView: 3,
            },
            1025: {
                slidesPerView: 4,
            },
        },
        navigation: {
            nextEl: '.interesting-slider__btn--next',
            prevEl: '.interesting-slider__btn--prev',
        },
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var jsHideBtns = document.querySelectorAll('.js-hide-btn-section');

    function hideSection() {
        var content = this.closest('.js-section').querySelector('.js-section-content');
        this.innerText !== 'Показать блок:' ? (this.innerText = 'Показать блок:') : (this.innerText = 'Скрыть блок:');
        this.classList.toggle('active');
        content.classList.toggle('hide-section');
    }

    jsHideBtns === null || jsHideBtns === void 0
        ? void 0
        : jsHideBtns.forEach(function (el) {
            return el.addEventListener('click', hideSection);
        });
});
/* document.addEventListener("DOMContentLoaded", () => {
    const textareas = document.querySelectorAll(".js-textarea-auto-height");

    textareas.forEach(el => {
        el.style.height = el.setAttribute('style', 'height: ' + (el.scrollHeight - 2) + 'px');
        el.addEventListener('input', e => {
            el.classList.add('auto');
            el.style.height = 'auto';
            el.style.height = (el.scrollHeight) + 'px';
        });
    })
}); */
('use strict');
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var cabinetContentInputs = document.querySelectorAll('.js-toggle-input');

    function toggleInputs() {
        var txt = this.querySelector('span');
        var target = this.dataset.text;
        var parent = this.closest('.cabinet-accordion__content');
        var input = parent.querySelector('input');

        if (!input.classList.contains('error')) {
            parent.classList.toggle('active');
            this.classList.add('cabinet-content__edit--active');
            txt.innerHTML !== 'Сохранить изменения' ? (txt.innerHTML = 'Сохранить изменения') : (txt.innerHTML = target);
        }
    }

    cabinetContentInputs === null || cabinetContentInputs === void 0
        ? void 0
        : cabinetContentInputs.forEach(function (el) {
            return el.addEventListener('click', toggleInputs);
        });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var anchorLinks = document.querySelectorAll('.anchor-link');
    anchorLinks.forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var blockID = el.getAttribute('href').substr(1);
            document.getElementById(blockID).scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        });
    });
});
('use strict');

function _slicedToArray(arr, i) {
    return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}

function _nonIterableRest() {
    throw new TypeError('Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.');
}

function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === 'Object' && o.constructor) n = o.constructor.name;
    if (n === 'Map' || n === 'Set') return Array.from(o);
    if (n === 'Arguments' || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) {
        arr2[i] = arr[i];
    }
    return arr2;
}

function _iterableToArrayLimit(arr, i) {
    var _i = arr == null ? null : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) || arr['@@iterator'];
    if (_i == null) return;
    var _arr = [];
    var _n = true;
    var _d = false;
    var _s, _e;
    try {
        for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
            _arr.push(_s.value);
            if (i && _arr.length === i) break;
        }
    } catch (err) {
        _d = true;
        _e = err;
    } finally {
        try {
            if (!_n && _i['return'] != null) _i['return']();
        } finally {
            if (_d) throw _e;
        }
    }
    return _arr;
}

function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr;
}

gsap.registerPlugin(ScrollTrigger);
gsap.utils.toArray('.logos').forEach(function (section, index) {
    var w = section.querySelector('.logos-slider .swiper-wrapper');

    var _ref = index % 2 ? ['100%', (w.scrollWidth - section.offsetWidth) * -0.2] : [w.scrollWidth * -0.2, 0],
        _ref2 = _slicedToArray(_ref, 2),
        x = _ref2[0],
        xEnd = _ref2[1];

    gsap.fromTo(
        w,
        {
            x: x,
        },
        {
            x: xEnd,
            scrollTrigger: {
                trigger: section,
                scrub: 1,
            },
        },
    );
});
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.logos-slider', {
        slidesPerView: 'auto',
        spaceBetween: 22,
        loop: true,
        centeredSlides: true,
    });
});
('use strict');

var observer = lozad('.lozad');
observer.observe();
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var manufacturingSlider = document.querySelector('.about-manufacturing-slider');

    if (manufacturingSlider) {
        var mySwiper;

        var initializeSlider = function initializeSlider() {
            mySwiper = new Swiper(manufacturingSlider, {
                slidesPerView: 1,
                spaceBetween: 10,
                scrollbar: {
                    el: '.about-manufacturing-slider__scrollbar',
                    draggable: true,
                    dragSize: 24,
                },
            });
        };

        if (window.innerWidth <= 768) {
            initializeSlider();
            manufacturingSlider.dataset.mobile = 'true';
        }

        var mobileSlider = function mobileSlider() {
            if (window.innerWidth <= 768 && manufacturingSlider.dataset.mobile == 'false') {
                initializeSlider();
                manufacturingSlider.dataset.mobile = 'true';
            }

            if (window.innerWidth > 768) {
                manufacturingSlider.dataset.mobile = 'false';

                if (manufacturingSlider.classList.contains('swiper-initialized')) {
                    mySwiper.destroy();
                }
            }
        };

        mobileSlider();
        window.addEventListener('resize', function () {
            mobileSlider();
        });
    }
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var _window$ymaps2;

    var maps = document.querySelectorAll('.map');
    maps.forEach(function (el) {
        var _window$ymaps;

        function init() {
            var center = [48.8866527839977, 2.34310679732974];
            var map = new ymaps.Map(el, {
                center: center,
                zoom: 17,
            });
            var placemark1 = new ymaps.Placemark(
                [48.8866527839977, 2.34010679732974],
                {
                    balloonContent:
                        '\n\t\t\t\t\t<div class="offices-item map-item">\n\t\t\t\t\t\t<img class="offices-item__image map-item__image" src="img/no-image.svg" alt="\u041E\u0444\u0438\u0441 1">\n\t\t\t\t\t\t<div class="store-item__right map-item__right">\n\t\t\t\t\t\t\t<a class="offices-item__desc offices-item__single-tel" href="#">\u0422\u0435\u043B.: 8 (800) 555-32-98</a>\n\t\t\t\t\t\t\t<p class="offices-item__desc offices-item__location">\u0433. \u0421\u0430\u043D\u043A\u0442-\u041F\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433, \u043F\u043B. \u0424\u0430\u0431\u0435\u0440\u0436\u0435, 8</p>\n\t\t\t\t\t\t\t<span class="offices-item__metro offices-item__metro--blue">\n\t\t\t\t\t\t\t\t<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">\n\t\t\t\t\t\t\t\t\t<path d="M7.74363 8.24606C8.49925 7.42446 9.40929 6.75974 10.4218 6.28984C11.4343 5.81995 12.5295 5.55408 13.6447 5.50743C14.76 5.46077 15.8735 5.63424 16.9217 6.01793C17.97 6.40162 18.9323 6.98801 19.7539 7.74363C20.5755 8.49925 21.2403 9.40929 21.7102 10.4218C22.1801 11.4343 22.4459 12.5295 22.4926 13.6447C22.5392 14.76 22.3658 15.8735 21.9821 16.9217C21.5984 17.97 21.012 18.9323 20.2564 19.7539C19.5008 20.5755 18.5907 21.2403 17.5782 21.7102C16.5657 22.1801 15.4705 22.4459 14.3553 22.4926C13.24 22.5392 12.1265 22.3658 11.0783 21.9821C10.03 21.5984 9.06766 21.012 8.24606 20.2564C7.42446 19.5008 6.75974 18.5907 6.28984 17.5782C5.81995 16.5657 5.55408 15.4705 5.50743 14.3553C5.46077 13.24 5.63424 12.1265 6.01793 11.0783C6.40162 10.03 6.98801 9.06766 7.74363 8.24606L7.74363 8.24606Z" stroke="var(--color)"></path>\n\t\t\t\t\t\t\t\t\t<path d="M18 10V18H16.751V13.045L14.3939 18H13.6061L11.2426 13.045V18H10V10H11.044L13.9968 16.1581L16.9496 10H18Z" fill="var(--color)"></path>\n\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t<span class="offices-item__desc">\u0441\u0442. \u043C. \u0422\u0435\u0445\u043D\u043E\u043B\u043E\u0433\u0438\u0447\u0435\u0441\u043A\u0438\u0439 \u0438\u043D\u0441\u0442\u0438\u0442\u0443\u0442 - 2</span>\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t<p class="offices-item__desc offices-item__hours">\u041F\u043D\u2014\u041F\u0442 \u0441 10:00 \u0434\u043E 21:00  \u0421\u0431\u2014\u0412\u0441 \u0441 10:00 \u0434\u043E 17:00</p>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t',
                },
                {
                    iconLayout: 'default#image',
                    iconImageHref:
                        "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                    iconImageSize: [40, 40],
                    iconImageOffset: [-20, -30],
                },
            );
            var placemark2 = new ymaps.Placemark(
                [48.8856527839977, 2.34310679732974],
                {
                    balloonContent:
                        '\n\t\t\t\t\t<div class="offices-item map-item">\n\t\t\t\t\t\t<img class="offices-item__image map-item__image" src="img/no-image.svg" alt="\u041E\u0444\u0438\u0441 1">\n\t\t\t\t\t\t<div class="store-item__right map-item__right">\n\t\t\t\t\t\t\t<a class="offices-item__desc offices-item__single-tel" href="#">\u0422\u0435\u043B.: 8 (800) 555-32-98</a>\n\t\t\t\t\t\t\t<p class="offices-item__desc offices-item__location">\u0433. \u0421\u0430\u043D\u043A\u0442-\u041F\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433, \u043F\u043B. \u0424\u0430\u0431\u0435\u0440\u0436\u0435, 8</p>\n\t\t\t\t\t\t\t<span class="offices-item__metro offices-item__metro--blue">\n\t\t\t\t\t\t\t\t<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">\n\t\t\t\t\t\t\t\t\t<path d="M7.74363 8.24606C8.49925 7.42446 9.40929 6.75974 10.4218 6.28984C11.4343 5.81995 12.5295 5.55408 13.6447 5.50743C14.76 5.46077 15.8735 5.63424 16.9217 6.01793C17.97 6.40162 18.9323 6.98801 19.7539 7.74363C20.5755 8.49925 21.2403 9.40929 21.7102 10.4218C22.1801 11.4343 22.4459 12.5295 22.4926 13.6447C22.5392 14.76 22.3658 15.8735 21.9821 16.9217C21.5984 17.97 21.012 18.9323 20.2564 19.7539C19.5008 20.5755 18.5907 21.2403 17.5782 21.7102C16.5657 22.1801 15.4705 22.4459 14.3553 22.4926C13.24 22.5392 12.1265 22.3658 11.0783 21.9821C10.03 21.5984 9.06766 21.012 8.24606 20.2564C7.42446 19.5008 6.75974 18.5907 6.28984 17.5782C5.81995 16.5657 5.55408 15.4705 5.50743 14.3553C5.46077 13.24 5.63424 12.1265 6.01793 11.0783C6.40162 10.03 6.98801 9.06766 7.74363 8.24606L7.74363 8.24606Z" stroke="var(--color)"></path>\n\t\t\t\t\t\t\t\t\t<path d="M18 10V18H16.751V13.045L14.3939 18H13.6061L11.2426 13.045V18H10V10H11.044L13.9968 16.1581L16.9496 10H18Z" fill="var(--color)"></path>\n\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t<span class="offices-item__desc">\u0441\u0442. \u043C. \u0422\u0435\u0445\u043D\u043E\u043B\u043E\u0433\u0438\u0447\u0435\u0441\u043A\u0438\u0439 \u0438\u043D\u0441\u0442\u0438\u0442\u0443\u0442 - 2</span>\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t<p class="offices-item__desc offices-item__hours">\u041F\u043D\u2014\u041F\u0442 \u0441 10:00 \u0434\u043E 21:00  \u0421\u0431\u2014\u0412\u0441 \u0441 10:00 \u0434\u043E 17:00</p>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t',
                },
                {
                    iconLayout: 'default#image',
                    iconImageHref:
                        "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                    iconImageSize: [40, 40],
                    iconImageOffset: [-20, -30],
                },
            );
            map.controls.remove('geolocationControl'); // удаляем геолокацию

            map.controls.remove('searchControl'); // удаляем поиск

            map.controls.remove('trafficControl'); // удаляем контроль трафика

            map.controls.remove('typeSelector'); // удаляем тип

            map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим

            map.controls.remove('zoomControl'); // удаляем контрол зуммирования

            map.controls.remove('rulerControl'); // удаляем контрол правил
            // map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
            // map.geoObjects.add(placemark);

            map.geoObjects.add(placemark1).add(placemark2);
        }

        (_window$ymaps = window.ymaps) === null || _window$ymaps === void 0 ? void 0 : _window$ymaps.ready(init);
    });

    function init() {
        var modalMap = document.querySelector('.modal-map__item');
        var center = [48.8866527839977, 2.34310679732974];

        if (modalMap) {
            var map = new ymaps.Map(modalMap, {
                center: center,
                zoom: 17,
            });
            var placemark1 = new ymaps.Placemark(
                [48.8866527839977, 2.34310679732974],
                {
                    balloonContent:
                        '\n\t\t\t\t\t<div class="mini-office">\n\t\t\t\t\t\t<p class="modal__desc list-reserve__street">\u0443\u043B. \u0414\u0437\u0435\u0440\u0436\u0438\u043D\u0441\u043A\u043E\u0433\u043E, 35/3</p>\n\t\t\t\t\t\t<p class="list-reserve__hours mini-office__hours">\u041F\u043D-\u041F\u0442 10:00-20:00, \u0421\u0431,\u0412\u0441 10:00-18:00</p>\n\t\t\t\t\t\t<a class="mini-office__tel" href="#">+7 (812) 777-78-61 </a>\n\t\t\t\t\t\t<span class="list-reserve__metro">\n\t\t\t\t\t\t\t<svg width="23" height="26" viewBox="0 0 23 26" fill="none" xmlns="http://www.w3.org/2000/svg">\n\t\t\t\t\t\t\t\t<path d="M2.74363 6.24606C3.49925 5.42446 4.40929 4.75974 5.4218 4.28984C6.43432 3.81995 7.52947 3.55408 8.64473 3.50743C9.75999 3.46077 10.8735 3.63424 11.9217 4.01793C12.97 4.40162 13.9323 4.98801 14.7539 5.74363C15.5755 6.49925 16.2403 7.40929 16.7102 8.4218C17.1801 9.43432 17.4459 10.5295 17.4926 11.6447C17.5392 12.76 17.3658 13.8735 16.9821 14.9217C16.5984 15.97 16.012 16.9323 15.2564 17.7539C14.5008 18.5755 13.5907 19.2403 12.5782 19.7102C11.5657 20.1801 10.4705 20.4459 9.35527 20.4926C8.24001 20.5392 7.12648 20.3658 6.07826 19.9821C5.03004 19.5984 4.06766 19.012 3.24606 18.2564C2.42446 17.5008 1.75974 16.5907 1.28984 15.5782C0.819948 14.5657 0.554083 13.4705 0.507428 12.3553C0.460773 11.24 0.634242 10.1265 1.01793 9.07826C1.40162 8.03004 1.98801 7.06766 2.74363 6.24606L2.74363 6.24606Z" stroke="#111111"/>\n\t\t\t\t\t\t\t\t<path d="M13 8V16H11.751V11.045L9.39392 16H8.60608L6.24259 11.045V16H5V8H6.04404L8.9968 14.1581L11.9496 8H13Z" fill="#111111"/>\n\t\t\t\t\t\t\t</svg>\t\t\t\n\t\t\t\t\t\t\t\u041B\u0435\u043D\u0438\u043D\u0441\u043A\u0438\u0439 \u043F\u0440.\n\t\t\t\t\t\t</span>\n\t\t\t\t\t</div>\n\t\t\t\t',
                },
                {
                    iconLayout: 'default#image',
                    iconImageHref:
                        "data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='path-1-inside-1_996_24966' fill='white'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z'/%3E%3C/mask%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M29.0883 20.4587L19.8317 35.6837L10.575 20.4587C9.57687 18.8159 9.0338 16.9372 9.00153 15.0152C8.96925 13.0933 9.44893 11.1974 10.3913 9.52203C11.3338 7.84669 12.705 6.45226 14.3642 5.48186C16.0235 4.51145 17.9111 4 19.8333 4C21.7555 4 23.6431 4.51145 25.3024 5.48186C26.9617 6.45226 28.3329 7.84669 29.2753 9.52203C30.2177 11.1974 30.6974 13.0933 30.6651 15.0152C30.6329 16.9372 30.0898 18.8159 29.0917 20.4587H29.0883ZM23.1129 11.8845C22.3315 11.103 21.2717 10.6641 20.1667 10.6641C19.0616 10.6641 18.0018 11.103 17.2204 11.8845C16.439 12.6659 16 13.7257 16 14.8307C16 15.9358 16.439 16.9956 17.2204 17.777C18.0018 18.5584 19.0616 18.9974 20.1667 18.9974C21.2717 18.9974 22.3315 18.5584 23.1129 17.777C23.8943 16.9956 24.3333 15.9358 24.3333 14.8307C24.3333 13.7257 23.8943 12.6659 23.1129 11.8845Z' fill='%23111111'/%3E%3Cpath d='M19.8317 35.6837L18.9772 36.2032L19.8317 37.6086L20.6861 36.2032L19.8317 35.6837ZM29.0883 20.4587V19.4587H28.526L28.2339 19.9392L29.0883 20.4587ZM10.575 20.4587L9.72039 20.9779L9.72053 20.9782L10.575 20.4587ZM9.00153 15.0152L8.00167 15.032L9.00153 15.0152ZM10.3913 9.52203L11.2629 10.0123L10.3913 9.52203ZM14.3642 5.48186L14.8691 6.34507L14.3642 5.48186ZM25.3024 5.48186L25.8073 4.61864V4.61864L25.3024 5.48186ZM29.2753 9.52203L28.4038 10.0123L29.2753 9.52203ZM29.0917 20.4587V21.4587H29.6542L29.9463 20.9779L29.0917 20.4587ZM23.1129 11.8845L23.8201 11.1773L23.8201 11.1773L23.1129 11.8845ZM17.2204 11.8845L17.9275 12.5916H17.9275L17.2204 11.8845ZM17.2204 17.777L17.9275 17.0699L17.9275 17.0699L17.2204 17.777ZM20.6861 36.2032L29.9428 20.9782L28.2339 19.9392L18.9772 35.1642L20.6861 36.2032ZM9.72053 20.9782L18.9772 36.2032L20.6861 35.1642L11.4295 19.9392L9.72053 20.9782ZM8.00167 15.032C8.03692 17.1314 8.63012 19.1835 9.72039 20.9779L11.4296 19.9394C10.5236 18.4483 10.0307 16.743 10.0014 14.9984L8.00167 15.032ZM9.51978 9.03175C8.49037 10.8617 7.96642 12.9327 8.00167 15.032L10.0014 14.9984C9.97209 13.2539 10.4075 11.533 11.2629 10.0123L9.51978 9.03175ZM13.8594 4.61864C12.047 5.67863 10.5492 7.20177 9.51978 9.03175L11.2629 10.0123C12.1183 8.49161 13.363 7.2259 14.8691 6.34507L13.8594 4.61864ZM19.8333 3C17.7337 3 15.6718 3.55866 13.8594 4.61864L14.8691 6.34507C16.3752 5.46424 18.0886 5 19.8333 5V3ZM25.8073 4.61864C23.9948 3.55866 21.933 3 19.8333 3V5C21.5781 5 23.2915 5.46424 24.7976 6.34507L25.8073 4.61864ZM30.1469 9.03175C29.1175 7.20177 27.6197 5.67863 25.8073 4.61864L24.7976 6.34507C26.3037 7.2259 27.5483 8.49161 28.4038 10.0123L30.1469 9.03175ZM31.665 15.032C31.7003 12.9327 31.1763 10.8617 30.1469 9.03175L28.4038 10.0123C29.2592 11.533 29.6946 13.2539 29.6653 14.9984L31.665 15.032ZM29.9463 20.9779C31.0366 19.1835 31.6297 17.1314 31.665 15.032L29.6653 14.9984C29.636 16.743 29.143 18.4483 28.2371 19.9394L29.9463 20.9779ZM29.0883 21.4587H29.0917V19.4587H29.0883V21.4587ZM20.1667 11.6641C21.0065 11.6641 21.812 11.9977 22.4058 12.5916L23.8201 11.1773C22.8511 10.2084 21.537 9.66406 20.1667 9.66406V11.6641ZM17.9275 12.5916C18.5214 11.9977 19.3268 11.6641 20.1667 11.6641V9.66406C18.7964 9.66406 17.4822 10.2084 16.5133 11.1773L17.9275 12.5916ZM17 14.8307C17 13.9909 17.3336 13.1854 17.9275 12.5916L16.5133 11.1773C15.5443 12.1463 15 13.4604 15 14.8307H17ZM17.9275 17.0699C17.3336 16.476 17 15.6706 17 14.8307H15C15 16.201 15.5443 17.5152 16.5133 18.4841L17.9275 17.0699ZM20.1667 17.9974C19.3268 17.9974 18.5214 17.6638 17.9275 17.0699L16.5133 18.4841C17.4822 19.4531 18.7964 19.9974 20.1667 19.9974V17.9974ZM22.4058 17.0699C21.812 17.6638 21.0065 17.9974 20.1667 17.9974V19.9974C21.537 19.9974 22.8511 19.4531 23.8201 18.4841L22.4058 17.0699ZM23.3333 14.8307C23.3333 15.6706 22.9997 16.476 22.4058 17.0699L23.8201 18.4841C24.789 17.5152 25.3333 16.201 25.3333 14.8307H23.3333ZM22.4058 12.5916C22.9997 13.1854 23.3333 13.9909 23.3333 14.8307H25.3333C25.3333 13.4604 24.789 12.1463 23.8201 11.1773L22.4058 12.5916Z' fill='black' mask='url(%23path-1-inside-1_996_24966)'/%3E%3C/svg%3E%0A",
                    iconImageSize: [40, 40],
                    iconImageOffset: [-20, -30],
                },
            );
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
    }

    (_window$ymaps2 = window.ymaps) === null || _window$ymaps2 === void 0 ? void 0 : _window$ymaps2.ready(init);
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var menuSliders = document.querySelectorAll('.menu-slider');
    menuSliders.forEach(function (slider) {
        new Swiper(slider, {
            freeMode: true,
            slidesPerView: 'auto',
            spaceBetween: 6,
            breakpoints: {
                577: {
                    spaceBetween: 12,
                },
            },
            navigation: {
                nextEl: '.menu-slider__btn--next',
                prevEl: '.menu-slider__btn--prev',
            },
        });
    });
});
('use strict');

var nav = document.querySelector('.nav'),
    menu = document.querySelector('.menu'),
    burger = document.querySelector('.burger'),
    header = document.querySelector('.header'),
    navItems = document.querySelectorAll('.nav__item--drop'),
    menus = document.querySelectorAll('.menu'),
    burgerClose = document.querySelector('.burger-close'),
    overlay = document.querySelector('.overlay'),
    menuNavLinks = document.querySelectorAll('.menu-nav__link');

var desktopMenu = function desktopMenu() {
    if (window.innerWidth > 1024) {
        var isClicked = false;
        var flag = 0;
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('nav__item--drop')) {
                var navItem = e.target;
                isClicked = true;
                var currentMenu = navItem.querySelector('.menu');
                overlay.classList.add('active');
                header.classList.add('m-open');
                navItems.forEach(function (el) {
                    return el.classList.remove('active');
                });
                navItem.classList.add('active');

                if (flag == 0) {
                    flag++;

                    if (!currentMenu.classList.contains('menu--visible')) {
                        document.querySelectorAll('.menu').forEach(function (mn) {
                            $(mn).slideUp(300);
                        });
                        setTimeout(function () {
                            $(currentMenu).slideDown(300);
                        }, 0);
                    }
                } else {
                    document.querySelectorAll('.menu').forEach(function (mn) {
                        $(mn).slideUp(300);
                    });
                    setTimeout(function () {
                        $(currentMenu).slideDown(300);
                    }, 300);
                }
            } else if (!e.target.closest('.nav')) {
                isClicked = false;
                flag--;
                navItems.forEach(function (el) {
                    return el.classList.remove('active');
                });
                overlay.classList.remove('active');
                header.classList.remove('m-open');
                menus.forEach(function (el) {
                    $(el).slideUp(300);
                });
            }
        });
        menuNavLinks.forEach(function (el) {
            el.addEventListener('click', function (e) {
                var menuContent = e.currentTarget.closest('.menu-nav').querySelectorAll('.menu-content');
                menuContent.forEach(function (el) {
                    return el.classList.remove('show');
                });
                menuNavLinks.forEach(function (el) {
                    return el.classList.remove('active');
                });
                e.currentTarget.classList.add('active');
                e.currentTarget.closest('.js-open-menu').querySelector('.menu-content').classList.add('show');
            });
            el.addEventListener('mouseenter', function (e) {
                var menuContent = e.currentTarget.closest('.menu-nav').querySelectorAll('.menu-content');
                menuContent.forEach(function (el) {
                    return el.classList.remove('show');
                });
                menuNavLinks.forEach(function (el) {
                    return el.classList.remove('active');
                });
                e.currentTarget.classList.add('active');
                e.currentTarget.closest('.js-open-menu').querySelector('.menu-content').classList.add('show');
            });
        });
    }
};

desktopMenu();

var initialMenu = function initialMenu() {
    document.querySelectorAll('.js-nav-list').forEach(function (el) {
        return el.classList.remove('animation');
    });
    document
        .querySelector('.nav')
        .querySelectorAll('.dropdown-menu')
        .forEach(function (el) {
            return el.classList.remove('animation');
        });
    scrollTop();
};

var scrollTop = function scrollTop() {
    menu.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
};

var openNav = function openNav(e) {
    document.body.classList.add('lock');
    e.currentTarget.classList.add('is-active');
    nav.classList.add('show');
    initialMenu();
};

var navClose = function navClose(e) {
    document.body.classList.remove('lock');
    e.currentTarget.classList.remove('is-active');
    nav.classList.remove('show');
    initialMenu();
};

burgerClose === null || burgerClose === void 0 ? void 0 : burgerClose.addEventListener('click', navClose);
burger === null || burger === void 0 ? void 0 : burger.addEventListener('click', openNav);
nav === null || nav === void 0
    ? void 0
    : nav.addEventListener('click', function (e) {
        if (e.target.classList.contains('js-open-menu')) {
            nav.classList.add('nav-lock');
            e.target.closest('.js-nav-list').classList.add('animation');
            e.target.querySelector('.dropdown-menu').classList.add('animation');
            scrollTop();
        }

        if (e.target.closest('.nav__mobile-back')) {
            e.target.closest('.dropdown-menu').classList.remove('animation');
            e.target.closest('.nav').querySelector('.nav__list').classList.remove('animation');
            scrollTop();
        }

        if (e.target.classList.contains('nav__link') && !e.target.classList.contains('nav__link--drop')) {
            nav.classList.remove('show');
        }

        if (!document.querySelector('.dropdown-menu').classList.contains('animation')) {
            nav.classList.remove('nav-lock');
        }
    });

var changeHeight = function changeHeight() {
    var vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', ''.concat(vh, 'px'));
};

changeHeight();
window.addEventListener('resize', function () {
    changeHeight();
    desktopMenu();
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var modalPromocode = document.querySelector('.modal__promocode');
    var flag = 0;

    function returnPromocode() {
        return '<input class="g-input modal-form__input modal__promocode-input" type="text" name="promocode" placeholder="\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u043F\u0440\u043E\u043C\u043E\u043A\u043E\u0434">';
    }

    modalPromocode === null || modalPromocode === void 0
        ? void 0
        : modalPromocode.addEventListener('click', function (e) {
            if (flag == 0) {
                e.currentTarget.insertAdjacentHTML('afterend', returnPromocode());
                flag++;
            } else {
                var _document$querySelect;

                (_document$querySelect = document.querySelector('.modal__promocode-input')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.remove();
                flag--;
            }
        });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    /* Variables */
    var openFormBtns = document.querySelectorAll('.toggle-form');
    var searchForms = document.querySelectorAll('.search-form');
    var searchResult = document.querySelectorAll('.search-result');
    var closeForm = document.querySelector('.search-form__close');

    /* Functions */

    function closeSearchForm(e) {
        if (document.body.clientWidth < 992) {
            document.body.classList.toggle('overflowY');
        }
        searchForms.forEach(function (el) {
            return el.classList.remove('active');
        });
    }

    function toggleSearchForm(e) {
        e.currentTarget.classList.toggle('active');
        if (document.body.clientWidth < 992) {
            document.body.classList.toggle('overflowY');
        } else {
            searchResult.forEach(item => item.classList.add('_padding'))
        }
        searchForms.forEach(function (el) {
            return el.classList.toggle('active');
        });
    }

    /* Events */

    openFormBtns.forEach(function (btn) {
        return btn.addEventListener('click', toggleSearchForm);
    });
    closeForm.addEventListener('click', closeSearchForm);
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var orderingOpenPopupBtns = document.querySelectorAll('.js-toggle-ordering-popup');
    var orderingList = document.querySelector('.ordering-list');
    var body = document.body;

    function showOrderingPopup() {
        orderingList.classList.toggle('show');
        body.classList.toggle('lock');
    }

    orderingOpenPopupBtns.forEach(function (el) {
        el.addEventListener('click', showOrderingPopup);
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var perfectCombinationSlider = document.querySelector('.perfect-combination-slider');
    var perfectCombinationSliderItems = document.querySelectorAll('.perfect-combination__item');

    if (perfectCombinationSlider) {
        var mySwiper;

        var initializeSlider = function initializeSlider() {
            if (perfectCombinationSliderItems.length == 1) mySwiper.destroy();
            mySwiper = new Swiper(perfectCombinationSlider, {
                slidesPerView: 'auto',
                spaceBetween: 6,
                centeredSlides: true,
                breakpoints: {
                    577: {
                        centeredSlides: false,
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                },
                scrollbar: {
                    el: '.perfect-combination-slider__scrollbar',
                },
                navigation: {
                    nextEl: '.perfect-combination-slider__btn--next',
                    prevEl: '.perfect-combination-slider__btn--prev',
                },
            });
        };

        if (window.innerWidth <= 768) {
            initializeSlider();
            perfectCombinationSlider.dataset.mobile = 'true';
        }

        var mobileSlider = function mobileSlider() {
            if (window.innerWidth <= 768 && perfectCombinationSlider.dataset.mobile == 'false') {
                initializeSlider();
                perfectCombinationSlider.dataset.mobile = 'true';
            }

            if (window.innerWidth > 768) {
                perfectCombinationSlider.dataset.mobile = 'false';

                if (perfectCombinationSlider.classList.contains('swiper-initialized')) {
                    mySwiper.destroy();
                }
            }
        };

        mobileSlider();
        window.addEventListener('resize', function () {
            mobileSlider();
        });
    }
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var moreCategories = document.querySelector('.more-categories');
    var hiddenCategories = document.querySelectorAll('.popular-category--hidden');
    var popularCategoriesItems = document.querySelectorAll('.popular-category__item');
    moreCategories === null || moreCategories === void 0
        ? void 0
        : moreCategories.addEventListener('click', function (e) {
            hiddenCategories.forEach(function (el) {
                return el.classList.remove('popular-category--hidden');
            });
            popularCategoriesItems.forEach(function (el) {
                TweenMax.staggerTo(
                    el,
                    0.5,
                    {
                        scale: 1,
                        opacity: 1,
                        ease: Back.easeIn.config(1),
                    },
                    0.3,
                );
            });
        });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var popularCategoriesSlider = document.querySelector('.popular-categories-slider');

    if (popularCategoriesSlider) {
        var mySwiper;

        var initializeSlider = function initializeSlider() {
            mySwiper = new Swiper(popularCategoriesSlider, {
                slidesPerView: 'auto',
                spaceBetween: 6,
                centeredSlides: true,
                breakpoints: {
                    577: {
                        centeredSlides: false,
                    },
                },
                scrollbar: {
                    el: '.popular-categories-slider__scrollbar',
                },
                navigation: {
                    nextEl: '.popular-categories-slider__btn--next',
                    prevEl: '.popular-categories-slider__btn--prev',
                },
            });
        };

        if (window.innerWidth <= 768) {
            initializeSlider();
            popularCategoriesSlider.dataset.mobile = 'true';
        }

        var mobileSlider = function mobileSlider() {
            if (window.innerWidth <= 768 && popularCategoriesSlider.dataset.mobile == 'false') {
                initializeSlider();
                popularCategoriesSlider.dataset.mobile = 'true';
            }

            if (window.innerWidth > 768) {
                popularCategoriesSlider.dataset.mobile = 'false';

                if (popularCategoriesSlider.classList.contains('swiper-initialized')) {
                    mySwiper.destroy();
                }
            }
        };

        mobileSlider();
        window.addEventListener('resize', function () {
            mobileSlider();
        });
    }
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var postSlider = new Swiper('.post-slider', {
        slidesPerView: 'auto',
        spaceBetween: 25,
        navigation: {
            nextEl: '.post-slider__btn--next',
            prevEl: '.post-slider__btn--prev',
        },
    });
});
('use strict');

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
                    currentProduct.querySelector('.image-pagination__item[data-index="'.concat(e.currentTarget.dataset.index, '"]')).classList.add('image-pagination__item--active');
                });
                el.addEventListener('mouseleave', function (e) {
                    currentProduct.querySelectorAll('.image-pagination__item').forEach(function (el) {
                        el.classList.remove('image-pagination__item--active');
                    });
                    currentProduct.querySelector('.image-pagination__item[data-index="0"]').classList.add('image-pagination__item--active');
                });
            });
        }
    });
}
('use strict');

var rangeSlider = document.getElementById('range-slider');

if (rangeSlider) {
    noUiSlider.create(rangeSlider, {
        start: [0, 999999],
        connect: true,
        step: 1,
        range: {
            min: [0],
            max: [999999],
        },
    });
    var input0 = document.getElementById('input-0');
    var input1 = document.getElementById('input-1');
    var inputs = [input0, input1];
    rangeSlider.noUiSlider.on('update', function (values, handle) {
        inputs[handle].value = Math.round(values[handle]);
    });

    var setRangeSlider = function setRangeSlider(i, value) {
        var arr = [null, null];
        arr[i] = value;
        rangeSlider.noUiSlider.set(arr);
    };

    inputs.forEach(function (el, index) {
        el.addEventListener('change', function (e) {
            setRangeSlider(index, e.currentTarget.value);
        });
    });
}
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var readMore = document.querySelectorAll('.read-more');
    readMore.forEach(function (el) {
        var flag = 0;
        el.addEventListener('click', function (e) {
            var fullText = e.currentTarget.closest('.read-more-wrapper').querySelector('.full-text');
            var text = e.currentTarget.dataset.text;

            if (flag == 0) {
                flag++;
                fullText.classList.add('active');
                e.currentTarget.innerHTML = 'Свернуть';
            } else {
                flag--;
                fullText.classList.remove('active');
                e.currentTarget.innerHTML = text;
            }
        });
    });
});
/* const fixBlock = document.querySelector('.fix-block');
const fixBlockHeight = fixBlock?.offsetTop;

const toggleFixed = () => {
    if (fixBlockHeight <= window.pageYOffset) {
        fixBlock?.classList.add('fixed');
    } else {
        fixBlock?.classList.remove('fixed');
    }

}

window.addEventListener('scroll', toggleFixed);

toggleFixed(); */
('use strict');
('use strict');

var selects = document.querySelectorAll('.g-select');
document.addEventListener('DOMContentLoaded', function () {
    if (selects) {
        selects.forEach(function (el) {
            var choices = new Choices(el, {
                searchPlaceholderValue: el.dataset.placeholder,
                itemSelectText: '',
                shouldSort: false,
                noResultsText: 'Не найдено',
            });
        });
    }
});
('use strict');

var simplebars = document.querySelectorAll('[data-simplebar]');
``
if (simplebars) {
    simplebars.forEach(function (el) {
        new SimpleBar(el);
    });
}
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var sortBy = document.querySelector('.sort-by');
    var sortByCurrent = document.querySelector('.sort-by__current');
    var sortByClose = document.querySelector('.sort-by__close');

    function visibleSort(e) {
        sortBy.classList.add('isOpen');
        document.body.classList.add('sort-open');

        if (e.classList.contains('sort-by__item')) {
            document.querySelectorAll('.sort-by__item').forEach(function (el) {
                return el.classList.remove('active');
            });
            e.classList.add('active');
            var text = e.textContent;
            sortByCurrent.textContent = text;
            hiddenSort();
        }
    }

    function hiddenSort() {
        sortBy === null || sortBy === void 0 ? void 0 : sortBy.classList.remove('isOpen');
        document.body.classList.remove('sort-open');
    }

    document.addEventListener('click', function (e) {
        if (e.target.closest('.open-sort-by') && !e.target.closest('.sort-by__close')) {
            visibleSort(e.target);
        } else if (e.target !== sortBy) {
            hiddenSort();
        }
    });
    sortByClose === null || sortByClose === void 0 ? void 0 : sortByClose.addEventListener('click', hiddenSort);
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
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
                self.style.width = ''.concat(self.value.length + 1, 'ex');
            } else {
                self.style.width = ''.concat(self.value.length + 2, 'ex');
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
                stepperInput.style.width = ''.concat(stepperInput.value.length + 1, 'ex');
            } else {
                stepperInput.style.width = ''.concat(stepperInput.value.length + 2, 'ex');
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
                stepperInput.style.width = ''.concat(stepperInput.value.length + 1, 'ex');
            } else {
                stepperInput.style.width = ''.concat(stepperInput.value.length + 2, 'ex');
            }
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var switchTabsBtn = document.querySelectorAll('.switch-tabs__btn');
    switchTabsBtn.forEach(function (el) {
        el.addEventListener('click', function () {
            var switchPath = el.dataset.switchPath;
            var switchTabs = el.closest('.switch-tabs');
            var switchContent = el.closest('.switch-tabs').querySelectorAll('.switch-tabs__content');
            switchTabs.querySelector('.switch-tabs__btn--active').classList.remove('switch-tabs__btn--active');
            switchTabs.querySelector('[data-switch-path="'.concat(switchPath, '"]')).classList.add('switch-tabs__btn--active');

            var handleContent = function handleContent(path, el) {
                var _el$closest, _el$closest$querySele;

                switchContent.forEach(function (el) {
                    return el.classList.remove('switch-tabs__content--active');
                });
                (_el$closest = el.closest('.switch-tabs')) === null || _el$closest === void 0
                    ? void 0
                    : (_el$closest$querySele = _el$closest.querySelector('[data-switch-target="'.concat(path, '"]'))) === null || _el$closest$querySele === void 0
                        ? void 0
                        : _el$closest$querySele.classList.add('switch-tabs__content--active');
            };

            handleContent(switchPath, el);
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var moreTabsBtn = document.querySelectorAll('.g-tabs__btn--more');
    var catalogTabs = document.querySelector('.catalog__tabs');

    var moreTabs = function moreTabs(e, hiddenTabs) {
        e.classList.toggle('active');
        e.closest('.g-tabs').classList.toggle('active');
        hiddenTabs.forEach(function (el) {
            return el.classList.toggle('g-tabs__item--hidden');
        });
    };

    moreTabsBtn === null || moreTabsBtn === void 0
        ? void 0
        : moreTabsBtn.forEach(function (btn) {
            var hiddenTabs = btn.closest('.g-tabs').querySelectorAll('.g-tabs__item--hidden');
            btn.addEventListener('click', function (e) {
                moreTabs(e.currentTarget, hiddenTabs);
            });
        });

    if (catalogTabs) {
        var moveTabs = function moveTabs() {
            var windowWidth = window.innerWidth;

            if (windowWidth > 1240) {
                var catalogTabsWidth = catalogTabs.offsetWidth;
                var tabsItems = catalogTabs.querySelectorAll('.g-tabs__item');
                var tabItemMore = catalogTabs.querySelector('.g-tabs__item--more');
                var tabsDropdown = catalogTabs.querySelector('.g-tabs-dropdown');
                var resultWidth = -100; // tabsItems.reverse();

                if (tabsDropdown) {
                    var tabsDropdownItems = tabsDropdown.querySelectorAll('.g-tabs__item');
                    tabsDropdownItems.forEach(function (tabItem) {
                        if (tabItem !== tabItemMore) {
                            catalogTabs.insertBefore(tabItem, tabItemMore);
                        }
                    });
                }

                catalogTabsWidth = catalogTabs.offsetWidth;

                if (tabItemMore) {
                    resultWidth = tabItemMore.offsetWidth;
                }

                var isMove = true;
                tabsItems.forEach(function (tabItem) {
                    var tabWidth = tabItem.offsetWidth;
                    var marginLeft = parseInt(getComputedStyle(tabItem, true).marginLeft);
                    var marginRight = parseInt(getComputedStyle(tabItem, true).marginRight);
                    tabWidth = tabWidth + marginLeft + marginRight;

                    if (tabItem !== tabItemMore) {
                        if (resultWidth + tabWidth <= catalogTabsWidth) {
                            resultWidth += tabWidth;
                        } else {
                            if (tabsDropdown) {
                                tabsDropdown.appendChild(tabItem);
                            }
                        }
                    }
                });
            }
        };

        moveTabs();
        window.addEventListener('resize', moveTabs);
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.catalog__tabs') && catalogTabs.classList.contains('active')) {
                var _document$querySelect, _document$querySelect2;

                (_document$querySelect = document.querySelector('.catalog__tabs')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.classList.remove('active');
                (_document$querySelect2 = document.querySelector('.catalog__tabs-more')) === null || _document$querySelect2 === void 0
                    ? void 0
                    : _document$querySelect2.classList.remove('active');
            }
        });
    }
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    /* Variables */
    var toggleLocationBtns = document.querySelectorAll('.toggle-location');
    var regionSelection = document.querySelector('.region-selection');
    var regionSelectionBtns = document.querySelectorAll('.js-region-selection__btn');
    var regionSelectionChoice = document.querySelectorAll('.region-selection__choice');
    var regionSelectionCloseBtns = document.querySelectorAll('.region-selection__close');
    var nav = document.querySelector('.nav');
    var body = document.body;

    /* Functions */

    function toggleLocation() {
        regionSelection.classList.toggle('isOpen');

        if (!(nav !== null && nav !== void 0 && nav.classList.contains('show'))) {
            body.classList.toggle('lock');
        }
    }

    function hiddenLocation() {
        regionSelection.classList.remove('isOpen');

        if (!(nav !== null && nav !== void 0 && nav.classList.contains('show'))) {
            body.classList.remove('lock');
        }
    }

    function changeLocation(e) {
        regionSelectionChoice.forEach(function (el) {
            return (el.textContent = e.currentTarget.textContent);
        });
        hiddenLocation();
    }

    /* Events */

    toggleLocationBtns.forEach(function (btn) {
        btn.addEventListener('click', toggleLocation);
    });
    regionSelectionBtns.forEach(function (btn) {
        btn.addEventListener('click', changeLocation);
    });
    regionSelectionCloseBtns.forEach(function (btn) {
        btn.addEventListener('click', hiddenLocation);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && regionSelection.classList.contains('isOpen')) hiddenLocation();
    });
});
('use strict');

$(document).ready(function () {
    $('.validate-form').each(function () {
        $(this).validate({
            rules: {
                phoneNumber: {
                    required: true,
                    minlength: 17,
                    maxlength: 17,
                },
                promocode: {
                    required: true,
                },
                value: {
                    required: true,
                },
                text: {
                    required: true,
                },
                condition: {
                    required: true,
                },
                name: {
                    required: true,
                },
                password: {
                    required: true,
                },
                email: {
                    required: true,
                },
            },
        });
    });
});
('use strict');

document.addEventListener('DOMContentLoaded', function () {
    var waresSlider = document.querySelectorAll('.wares-slider');

    if (waresSlider) {
        waresSlider.forEach(function (el) {
            var mySwiper;

            var initializeSlider = function initializeSlider() {
                mySwiper = new Swiper(el, {
                    slidesPerView: 2,
                    loop: false,
                    spaceBetween: 15,
                    breakpoints: {
                        769: {
                            slidesPerView: 2,
                        },
                        1025: {
                            slidesPerView: 4,
                        },
                    },
                    navigation: {
                        nextEl: '.wares-slider__btn--next',
                        prevEl: '.wares-slider__btn--prev',
                    },
                });
                mySwiper.on('slideChange', function () {
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
                                        currentProduct
                                            .querySelector('.image-pagination__item[data-index="'.concat(e.currentTarget.dataset.index, '"]'))
                                            .classList.add('image-pagination__item--active');
                                    });
                                    el.addEventListener('mouseleave', function (e) {
                                        currentProduct.querySelectorAll('.image-pagination__item').forEach(function (el) {
                                            el.classList.remove('image-pagination__item--active');
                                        });
                                        currentProduct.querySelector('.image-pagination__item[data-index="0"]').classList.add('image-pagination__item--active');
                                    });
                                });
                            }
                        });
                    }
                });
            };

            if (window.innerWidth <= 576) {
                if (el.classList.contains('swiper-initialized')) {
                    mySwiper.destroy();
                }

                el.dataset.mobile = 'true';
            }

            var mobileSlider = function mobileSlider() {
                if (window.innerWidth <= 576 && el.dataset.mobile == 'false') {
                    el.dataset.mobile = 'true';

                    if (el.classList.contains('swiper-initialized')) {
                        mySwiper.destroy();
                    }
                }

                if (window.innerWidth >= 576) {
                    initializeSlider();
                    el.dataset.mobile = 'false';
                }
            };

            mobileSlider();
            window.addEventListener('resize', function () {
                mobileSlider();
            });
        });
    }
});
('use strict');


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

const searchLists = $('.search-result__list');
const searchSwiperDisp = $('.search-result__swiper');
const searchListWrapper = $('.search-result__wrapper');
const searchResult = $('.search-result');
document.querySelector('.search-form__input').addEventListener('input', (event) => {
    if (event.target.value.length >= 2) {
        searchLists.fadeIn(300);
        searchResult.removeClass('_padding');
        searchListWrapper.fadeIn(300);
        searchSwiperDisp.fadeIn(300);
    } else {
        searchLists.fadeOut(300);
        searchResult.addClass('_padding');
        searchListWrapper.fadeOut(300);
        searchSwiperDisp.fadeOut(300);
    }
})