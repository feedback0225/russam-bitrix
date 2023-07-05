<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>
	<section class="not-found">
        <div class="container not-found__container">
            <h1 class="g-title not-found__title">ошибка 404</h1>
            <h2 class="g-title g-title--center not-found__subtitle">К сожалению запрашиваемая Вами страница ненайдена...</h2>
            <a class="not-found__link g-btn g-btn--black not-found" href="/">вернуться на главную</a>
            <div class="not-found__desc">Если у вас есть срочный вопрос, звоните нам по бесплатному телефону</div>
            <a class="not-found__tel" href="tel:<?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?>"><?=\Bitrix\Main\Config\Option::get( "askaron.settings", $phoneNumber);?></a>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded',function (){
       $('body').addClass('not-found__wrapper');
    });
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>