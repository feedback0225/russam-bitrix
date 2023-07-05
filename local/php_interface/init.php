<?
include_once "defines.php";
include_once "functions.php";
include_once "handlers.php";
include_once "Bitrix24CustomApi.php";
include_once "updateDiscounts.php";
include_once "bitrix24.php";
// include_once "newsearch.php";
AddEventHandler("search", "OnSearch", Array("MyClass", "OnSearchHandler"));

class MyClass
{
    // создаем обработчик события "BeforeIndex"
    public static function OnSearchHandler($strQuery)
    {
    }
}
function discountsAgent()
{
    updateDiscounts();
    return "discountsAgent();";
}


// AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("IblockAfterHandlerClass", "OnAfterIBlockElementUpdateHandler"));

// class IblockAfterHandlerClass {
    // public static function OnAfterIBlockElementUpdateHandler(&$arFields)
    // {
		// if($arFields["IBLOCK_ID"] == 5) {
			// $price = CPrice::GetBasePrice($arFields["ID"]);
			// AddMessage2Log("<br/><br/><pre>".print_r($price,true)."</pre><br/><br/>", "test");
			// if($price["PRICE"] == '0.00') {
				// $connection = Bitrix\Main\Application::getConnection();
				// $id = $price["ID"];
				// $result = $connection->query('DELETE FROM b_catalog_price WHERE ID='.$id);
				// $price = CPrice::GetBasePrice($arFields["ID"]);
				// CPrice::SetBasePrice($arFields["ID"],"",$price["CURRENCY"]);
				// CPrice::DeleteByProduct($arFields["ID"]);
				// CPrice::Delete($price["ID"]);
				// AddMessage2Log("<br/><br/><pre>".print_r($price,true)."</pre><br/><br/>", "test");
				// AddMessage2Log("<br/><br/><pre>".print_r(CPrice::DeleteByProduct($arFields["ID"]),true)."</pre><br/><br/>", "test");
			// }
			
			// AddMessage2Log("<br/><br/><pre>".print_r(CPrice::GetBasePrice($arFields["ID"]),true)."</pre><br/><br/>", "test");
			// AddMessage2Log("<br/><br/><pre>".print_r($arFields,true)."</pre><br/><br/>", "test");
			// return false;
		// }
    // }
// }
