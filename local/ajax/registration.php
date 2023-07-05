<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/api/smsc_api.php");
global $APPLICATION, $USER;
$APPLICATION->RestartBuffer();

function ok_code($s) {
    return hexdec(substr(md5($s.date("j. n. Y s")), 7, 5));
}

$email = $_POST['text'];
$code = ok_code($_POST['text']);

if(filter_var($email, FILTER_VALIDATE_EMAIL) && $email != 'feedback0225@gmail.com' && $email != 'feedback0225_1@gmail.com'){
    $el = new CIBlockElement;
    $PROP['125'] = $code;
    $arData = Array(
        "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
        "IBLOCK_ID"      => 12,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $email,
        "ACTIVE"         => "Y",            // активен
    );
    $CODE_ELEMENT_ID = $el->Add($arData);

    if(!$CODE_ELEMENT_ID) {
        $result['message'] = $el->LAST_ERROR;
        die();
    }

    $r = send_sms($_POST['text'], "Ваш код: " . $code, 0, 0, 0, 8, "jewel@russammarket.ru", "subj=Регистрация на сайте «Русские самоцветы»");
    if ($r[1] > 0){
        $result['message'] = "sent";
        $result['to'] = $email;
    }
    else{
        $result['message'] = 'Ошибка!';
    }
} else {
    $phone = preg_replace("/[^0-9]/", '', $_POST['text']);
    if ($phone[0] == 8) {
        $phone[0] = 7;
    }
    $r = send_sms($phone,"Ваш код: " . $code);
    if ($r > 0){
        $el = new CIBlockElement;
        $PROP['125'] = $code;
        $arData = Array(
            "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
            "IBLOCK_ID"      => 12,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $_POST['text'],
            "ACTIVE"         => "Y",            // активен
        );
        $CODE_ELEMENT_ID = $el->Add($arData);

        if(!$CODE_ELEMENT_ID) {
            $result['message'] = $el->LAST_ERROR;
            die();
        }


        $result['message'] = "sent";
        $result['to'] = $_POST['text'];
    } else {
        $result['message'] = 'Неверный email или телефон!';
    }
}

echo json_encode($result);
die();
