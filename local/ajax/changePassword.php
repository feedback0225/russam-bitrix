<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;

$APPLICATION->RestartBuffer();
if(strip_tags($_POST['text']) && strip_tags($_POST['control']) && strip_tags($_POST['password_1']) && strip_tags($_POST['repeat_password_1'])){

    global $USER;
    $userLogin = '';
    $filter = Array("EMAIL" => strip_tags($_POST['text']));
    $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
    if($user = $rsUsers->GetNext())
        $userLogin = $user["LOGIN"];

    global $USER;
    $arResult = $USER->ChangePassword($userLogin, strip_tags($_POST['control']), strip_tags($_POST['password_1']), strip_tags($_POST['repeat_password_1']));
    if($arResult["TYPE"] == "OK") {
        $result['message'] = "Пароль успешно сменен.";
    }
    else{
        $result = $arResult;
//        ShowMessage($arResult);
    }
    echo json_encode($result);
}
die();
