<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;

$APPLICATION->RestartBuffer();
$userID = $USER->GetID();
$user = new CUser;
if(strip_tags($_POST['email'])){
    $fields = Array(
        "EMAIL" => $_POST['email'],
    );
    $user->Update($userID, $fields);
    if(!$user->LAST_ERROR){
        $result['message'] = 'Данные были изменены!';
    } else {
        $result['message'] = $user->LAST_ERROR;
    }
} else if(strip_tags($_POST['fullName'])){
    $fields = Array(
        "NAME" => explode(' ',$_POST['fullName'])[0],
        "LAST_NAME" => explode(' ',$_POST['fullName'])[1]
    );
    $user->Update($userID, $fields);
    if(!$user->LAST_ERROR){
        $result['message'] = 'Данные были изменены!';
    } else {
        $result['message'] = $user->LAST_ERROR;
    }
} else if(strip_tags($_POST['sex'])){
    $fields = Array(
        "PERSONAL_GENDER" => strip_tags($_POST['sex']),
    );
    $user->Update($userID, $fields);
    if(!$user->LAST_ERROR){
        $result['message'] = 'Данные были изменены!';
    } else {
        $result['message'] = $user->LAST_ERROR;
    }
} else if(strip_tags($_POST['old_password']) && strip_tags($_POST['password_2']) && strip_tags($_POST['repeat_password_2'])){
    $res = $USER->Login($USER->GetLogin(), strip_tags($_POST['old_password']));
    $result['result'] = $res;

    if($result['result'] === true){
        $fields = array(
            "PASSWORD"=>strip_tags($_POST['password_2']),//пароль
            "CONFIRM_PASSWORD"=>strip_tags($_POST['repeat_password_2'])//подтверждение пароля
        );
        $user->Update($userID, $fields);
        if($user->LAST_ERROR){
            $result['message'] = $user->LAST_ERROR;
        } else {
            $result['message'] = 'Данные были изменены!';
        }
    }
} else if(strip_tags($_POST['dateBirthday'])){
    if($USER->GetByID($USER->GetID())->Fetch()["UF_BIRTHDAY_CHANGED"] != 1){
        $fields = array(
            "PERSONAL_BIRTHDAY"=>strip_tags($_POST['dateBirthday']),
        );
        $user->Update($userID, $fields);
        if($user->LAST_ERROR){
            $result['message'] = $user->LAST_ERROR;
        } else {
            $result['message'] = 'Данные были изменены!';
            $fields = array(
                "UF_BIRTHDAY_CHANGED"=> 1,
            );
        $user->Update($userID, $fields);
        }
    } else {
        $result['message'] = 'Вы уже меняли дату рождения! <br>Обратитесь в службу поддержки';
    }
}
echo json_encode($result);
die();
