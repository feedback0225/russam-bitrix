<?
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?
global $USER;
//if (!$USER->IsAuthorized()) die();
echo '<pre>';
$start = microtime(true);


$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "ACTIVE" => "Y"), false, array("nPageSize" => 1500), array("ID", "IBLOCK_ID"));
while ($ob = $res->fetch()) {
	$arList[] = $ob['ID'];
}

if (!empty($arList)) {
	$el = new CIBlockElement;
	foreach ($arList as $id) {
		$res = $el->Update($id, array('ACTIVE' => 'N'));
		print_r($id . ' Deactivate<br/>');
	}
}

echo '<hr>Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.';
echo '</pre>';
?>
<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>