<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$GLOBALS['APPLICATION']->RestartBuffer();
GLOBAL $APPLICATION;
GLOBAL $USER;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
$application = Application::getInstance();
$context = $application->getContext();
/* Избранное */

if(!$USER->IsAuthorized()) // Для неавторизованного
{
    //$APPLICATION->get_cookie('favorites')
    $arElements = unserialize($APPLICATION->get_cookie('favorites'));
    foreach ($arElements as $key=>$tempElement){
        unset($arElements[$key]);
    }
    $result = 'clearFavorites';
    $cookie = new Cookie("favorites", serialize($arElements), time() + 60*60*24*60,'/');
    $cookie->setDomain($context->getServer()->getHttpHost());
    $cookie->setHttpOnly(false);
    $context->getResponse()->addCookie($cookie);
    $context->getResponse()->flush(json_encode($result));
    die();
}
else { // Для авторизованного
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
    foreach ($arElements as $key=>$tempElement){
        unset($arElements[$key]);
    }
    $result = 'clearFavorites';
    $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
}
/* Избранное */
echo json_encode($result);
die();