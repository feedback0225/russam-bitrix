<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!IsModuleInstalled("subscribe"))
{
    ShowError(GetMessage("SUBSCR_MODULE_NOT_INSTALLED"));
    return;
}

if(!CModule::IncludeModule('subscribe'))
{
    ShowError('Не подключен класс CSubscribe');
    return;
}

if ($_SESSION['SUBSCRIBED'] == 'Y'){
    echo json_encode(["TYPE" => "ERROR", "MESSAGE" => "Вы уже подписаны"]);
    return;
}


global $USER;
$email = htmlspecialchars($_POST['email']);

if($strWarning == "")
{
    $arFields = Array(
        "USER_ID" => ($USER->IsAuthorized()? $USER->GetID():false),
        "FORMAT" => "html",
        "EMAIL" => $email,
        "ACTIVE" => "Y",
        "CONFIRMED" => "Y",
        "SEND_CONFIRM" => 'N',
        "RUB_ID" => array(1)
    );
    $subscr = new CSubscription;

    //can add without authorization
    $ID = $subscr->Add($arFields);
    if($ID>0) {
        CSubscription::Authorize($ID);
        $_SESSION['SUBSCRIBED'] = "Y";

        $arEventFields = [];
        foreach($_POST as $pKey=>$pValue){
            $arEventFields[mb_strtoupper($pKey)] = $pValue;
        }

        $arEventFields['EMAIL'] = $email;
        $arEventFields['EMAIL_TO'] = $email;
        CEvent::Send('SUBSCRIPTION',"s1",$arEventFields,"N","","","");
        CEvent::CheckEvents();

        echo json_encode(["TYPE" => "SUCCESS","MESSAGE" => "Подписка оформлена"]);
    }else
        echo json_encode(["TYPE" => "SUCCESS","MESSAGE" => "Уже подписанны!"]);
//        $strWarning .= "Error adding subscription: ".$subscr->LAST_ERROR."<br>";
    }
//echo json_encode($strWarning);
?>