<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION, $USER;
$APPLICATION->RestartBuffer();



if($_POST['login'] && $_POST['text']){

    $codeMatch = false;

    CModule::IncludeModule("iblock");
    $arFilter = Array("IBLOCK_ID"=>12, "ACTIVE"=>"Y","NAME" => $_POST['login']);
    $res = CIBlockElement::GetList(Array('ID' => 'DESC'), $arFilter, false, Array("nPageSize"=>1));
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        if($arProps['CODE']['VALUE'] == $_POST['text']){
            $codeMatch = true;
        }
    }

    if($codeMatch){
        $email = $_POST['login'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $findUser = false;
            $order = array('id' => 'desc');
            $tmp = 'desc';
            $filter = ['EMAIL' => $_POST['login']];
            $rsUsers = CUser::GetList($order, $tmp,$filter,["NAV_PARAMS" => ["nTopCount"=>1]]);
            while($arUser = $rsUsers->Fetch()){
                $result['message'] = 'enter';
                $USER->Authorize($arUser['ID']);
                $findUser = true;
            };

            if(!$findUser){
                $user = new CUser;
                $arFields = Array(
                    "NAME"              => "New",
                    "LAST_NAME"         => "User",
                    "EMAIL"             => strip_tags($_POST['login']),
                    "LOGIN"             => explode('@',strip_tags($_POST['login']))[0] . ' :' . date('d.m.Y'),
                    "LID"               => "ru",
                    "ACTIVE"            => "Y",
                    "GROUP_ID"          => array(2),
                    "PERSONAL_GENDER"   => "M",
                    "PERSONAL_BIRTHDAY" => "",
                    "PASSWORD"          => strip_tags($_POST['text']),
                    "CONFIRM_PASSWORD"  => strip_tags($_POST['text']),
                );
                $ID = $user->Add($arFields);
                if (intval($ID) > 0){
                    $result['message'] = 'enter';
                    $USER->Authorize($ID);
                }
                else{
                    $result['message'] = $user->LAST_ERROR;
                }
            }
        } else {
            $phone = preg_replace("/[^0-9]/", '', $_POST['login']);

            $findUser = false;
            $order = array('id' => 'desc');
            $tmp = 'desc';
            $filter = ['PERSONAL_PHONE' => $phone];
            $rsUsers = CUser::GetList($order, $tmp,$filter,["NAV_PARAMS" => ["nTopCount"=>1]]);
            while($arUser = $rsUsers->Fetch()){
                $result['message'] = 'enter';
                $USER->Authorize($arUser['ID']);
                $findUser = true;
            };

            if(!$findUser){
                $user = new CUser;
                $arFields = Array(
                    "NAME"              => "New",
                    "LAST_NAME"         => "User",
                    "EMAIL"             => 'email'.$phone.'@gmail.com',
                    "PERSONAL_PHONE"    => strip_tags($phone),
                    "LOGIN"             => 'email'.$phone . ' :' . date('d.m.Y'),
                    "LID"               => "ru",
                    "ACTIVE"            => "Y",
                    "GROUP_ID"          => array(2),
                    "PERSONAL_GENDER"   => "M",
                    "PERSONAL_BIRTHDAY" => "01.01.1980",
                    "PASSWORD"          => strip_tags($_POST['text']),
                    "CONFIRM_PASSWORD"  => strip_tags($_POST['text']),
                );
                $ID = $user->Add($arFields);
                if (intval($ID) > 0){
                    $result['message'] = 'enter';
                    $USER->Authorize($ID);
                }
                else{
                    $result['message'] = $user->LAST_ERROR;
                }
            }
        }
    } else {
        $result['message'] = 'Код неверный!';
    }
    echo json_encode($result);
}
die();
