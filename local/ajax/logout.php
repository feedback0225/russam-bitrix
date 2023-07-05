<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$GLOBALS['APPLICATION']->RestartBuffer();
$USER->Logout();
die();