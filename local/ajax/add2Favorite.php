<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$GLOBALS['APPLICATION']->RestartBuffer();
GLOBAL $APPLICATION;
GLOBAL $USER;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
$application = Application::getInstance();
$context = $application->getContext();
/* Избранное */

if($_POST['id'])
{
    if(!$USER->IsAuthorized()) // Для неавторизованного
    {
        //$APPLICATION->get_cookie('favorites')
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));
        if(!in_array($_POST['id'], $arElements))
        {
            $arElements[] = $_POST['id'];
            $result = [1,count($arElements)]; // Датчик. Добавляем
        }
        else {
            $key = array_search($_POST['id'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);

            $result = [2,count($arElements)]; // Датчик. Удаляем
        }
//		setcookie("favorites", serialize($arElements), time()+3600*60,'/');
        foreach ($arElements as &$element){
            $element = intval($element);
        }
        $cookie = new Cookie("favorites", serialize($arElements), time() + 60*60*24*60,'/');
//        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setDomain('market.russam.ru');
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
        if(!in_array($_POST['id'], $arElements)) // Если еще нету этой позиции в избранном
        {
            $arElements[] = $_POST['id'];
            $result = [1,count($arElements)];
        }
        else {
            $key = array_search($_POST['id'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $result = [2,count($arElements)];
        }
        $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
    }
}
/* Избранное */
echo json_encode($result);
die();