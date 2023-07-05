<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;
$APPLICATION->RestartBuffer();

function ok_code($s) {
    return hexdec(substr(md5($s.date("j. n. Y s")), 7, 5));
}

$phone = preg_replace("/[^0-9]/", '', $_POST['phoneNumber']);
$result = '';
$fio = htmlspecialchars($_POST['fio']);


$fields = [];
$fields['CONTACT_NAME'] = $fio;
$fields['TITLE'] = 'Обратный звонок';



if ($phone[0] == 8) {
    $phone[0] = 7;
}

$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.list';
$queryData = http_build_query(array(
    'order' => ["DATE_CREATE" => "ASC"],
    'filter' => ["PHONE" => $phone],
    'select' => ["ID","NAME","LAST_NAME","PHONE"],
));
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result, 1);
$contactID = $result['result'][0]['ID'];


if($result['total'] == 0) {
    $queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.add';
    $queryData = http_build_query(array(
        'fields' => [
            'NAME' => $fields['CONTACT_NAME'] ? $fields['CONTACT_NAME'] : $phone,
            'PHONE' => [['VALUE' => $phone,"VALUE_TYPE" => "WORK" ]],
        ],
    ));
    // обращаемся к Битрикс24 при помощи функции curl_exec
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    $contactID = $result['result'];
} elseif($fields['CONTACT_NAME']) {
    $queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.contact.update';
    $queryData = http_build_query(array(
        'id' => $contactID,
        'fields' => [
            'NAME' => $fields['CONTACT_NAME'] ? $fields['CONTACT_NAME'] : $phone,
            'PHONE' => [['VALUE' => $phone,"VALUE_TYPE" => "WORK" ]],
        ],
        'params' => [
            "REGISTER_SONET_EVENT" => "Y"
        ],
    ));
    // обращаемся к Битрикс24 при помощи функции curl_exec
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
}
$queryUrl = 'https://russam.bitrix24.ru/rest/1/rgv8t2cgwgx3cj6p/crm.deal.add';
$queryData = http_build_query(array(
    'fields' => array(
        'CATEGORY_ID' => 0, //19
        'CONTACT_ID' => $contactID,
        'TITLE' => $fields['TITLE'],
    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y")
));
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result, 1);
$dealID = $result['result'];


if($dealID){
    echo json_encode($dealID);
}

/*
 * OLD FUNCTIONAL
 *


    $dbCoupon = \Bitrix\Sale\Internals\DiscountCouponTable::GetList(['filter' => ['DESCRIPTION' => $phone,'ACTIVE' => 'Y']]);
    if($arCoupon = $dbCoupon->Fetch())
    {
        $result = $arCoupon['COUPON'];
    }
    else
    {
        $coupon = \Bitrix\Sale\Internals\DiscountCouponTable::generateCoupon(true);
        $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
            'DISCOUNT_ID' => 5,
            'COUPON'      => $coupon,
            'TYPE'        => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
            'MAX_USE'     => 1,
            'USER_ID'     => 0,
            'DESCRIPTION' => $phone
        ));
        if ($addDb->isSuccess()) {
            $result = $coupon;
        } else {
            $result = "ERROR";
        }
    }
    $r = send_sms_mail($phone,'Ваш купон: ' . $result);
    if ($r > 0){
        $result = 'GOOD';
    } else {
        $result = 'ERROR';
    }
    echo json_encode($result);


 *
 * OLD FUNCTIONAL
 *
 * */
die();
