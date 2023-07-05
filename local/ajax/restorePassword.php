<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;

$APPLICATION->RestartBuffer();
if(strip_tags($_POST['text'])){

    global $USER;
    $userLogin = '';
    if(filter_var($_POST['text'], FILTER_VALIDATE_EMAIL)){
        $filter = Array("EMAIL" => strip_tags($_POST['text']));
        $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
        if($user = $rsUsers->GetNext())
            $userLogin = $user["LOGIN"];
    } else {
        $filter = Array("PERSONAL_PHONE" => preg_replace("/[^0-9]/", '', $_POST['text']));
        $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
        if($user = $rsUsers->GetNext())
            $userLogin = $user["LOGIN"];
    }

    $arResult = $USER->SendPassword($userLogin, strip_tags($_POST['text']));
    if($arResult["TYPE"] == "OK") {
        $result['login'] = strip_tags($_POST['text']);
        $result['message'] = "Контрольная строка для смены пароля выслана.";
    }else{
        $result['message'] = "Введенные логин (email) не найдены.";
    }
    echo json_encode($result);
}
die();
