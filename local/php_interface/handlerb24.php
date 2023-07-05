<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
define('PROTOCOL', 'https');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;
/**
 * Совершает запрос с заданными данными по заданному адресу. В ответ ожидается JSON
 *
 * @param string $method GET|POST
 * @param string $url адрес
 * @param array|null $data POST-данные
 *
 * @return array
 */
function query($method, $url, $data = null)
{
	$query_data = "";

	$curlOptions = array(
		CURLOPT_RETURNTRANSFER => true
	);
	if($method == "POST")
	{
		$curlOptions[CURLOPT_POST] = true;
		$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
	}
	elseif(!empty($data))
	{
		$url .= strpos($url, "?") > 0 ? "&" : "?";
		$url .= http_build_query($data);
	}

	$curl = curl_init($url);
	curl_setopt_array($curl, $curlOptions);
	$result = curl_exec($curl);
	return json_decode($result, 1);
}

/**
 * Вызов метода REST.
 *
 * @param string $domain портал
 * @param string $method вызываемый метод
 * @param array $params параметры вызова метода
 *
 * @return array
 */
function call($domain, $method, $params)
{
	return query("GET", "https://russam.bitrix24.ru/rest/419/7hj16w2wm24v20ez/".$method.".json", $params);
}
$domain = 'russam.bitrix24.ru';
$counter_file = $_SERVER['DOCUMENT_ROOT'] . '/apilogs.txt';
$deal_id = $_REQUEST['data']['FIELDS']['ID'];
// Запрашиваем данные этой сделки
$auth = $_REQUEST['auth']['access_token'];
$domain = $_REQUEST['auth']['domain'];
$data = call($domain, "crm.deal.get", array(
        "ID" => $deal_id    
    )
);
if(($deal = $data['result']) && $orderId = $data['result']['ORIGIN_ID']){
    $orderToChange = \Bitrix\Sale\Order::load($orderId);
    if($deal['STAGE_ID'] == 'WON'){
        $orderToChange->setField("STATUS_ID","F");
        $orderToChange->setField("CANCELED", "N");
    }elseif($deal['STAGE_ID'] == 'LOSE'){
        $orderToChange->setField("STATUS_ID", "C");
        $orderToChange->setField("CANCELED", "Y");
    }else{
        $orderToChange->setField("STATUS_ID", "N");
        $orderToChange->setField("CANCELED", "N");
    } 
    $orderToChange->save();
}
