$(document).on('keyup', '.js-header-search', function (e) {
    e.preventDefault();
    let value = $(this).val();

    if (value.length >= 2) {
        $.ajax({
            url: window.location.href,
            method: 'get',
            dataType: 'html',
            data: {
                q: value,
                ajax: 'Y',
                block: 'header_search',
            },
            success: function (data) {
                let $headerSearchBlock = $(data).find('.search-result__list').html();
                $('.search-result__list').html($headerSearchBlock);

                let $searchItems = $(data).find('.js-search-result-items').html();
                $('.js-search-result-items').html($searchItems);

                let $searchItemsCollection = $(data).find('.js-search-collection').html();

                $('.js-search-collection').html($searchItemsCollection);

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

            }
        });
    }
})

$(document).on('submit', '.js-search-header-from', function (e) {
    e.preventDefault();
    let value = $('.js-header-search').val();
    window.location.href = '/search/?search=' + value;
})