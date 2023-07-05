<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;

$APPLICATION->RestartBuffer();

$userLogin = '';
if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){
    $filter = Array("EMAIL" => strip_tags($_POST['login']));
    $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
    if($user = $rsUsers->GetNext())
        $userLogin = $user["LOGIN"];
} else {
    $filter = Array("PERSONAL_PHONE" => preg_replace("/[^0-9]/", '', $_POST['login']));
    $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
    if($user = $rsUsers->GetNext())
        $userLogin = $user["LOGIN"];
}

if($userLogin && strip_tags($_POST['login']) && strip_tags($_POST['password']) && !$USER->IsAuthorized()) {
    $res = $USER->Login(strip_tags($userLogin), strip_tags($_POST['password']), 'Y');
    if (empty($res['MESSAGE'])) {
        $result['status'] = true;
    } else {
        $result['message'] = strip_tags($res['MESSAGE']);
    }

    echo json_encode($result);
} elseif($USER->IsAuthorized()){
    $result['message'] = 'Вы уже авторизованы!';
    echo json_encode($result);
} else {
    $result['message'] = 'Что-то пошло не так!';
    echo json_encode($result);
}
die();
