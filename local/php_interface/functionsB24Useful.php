<?
$b24ApiNumber = '1';
$b24ApiKey = 'rgv8t2cgwgx3cj6p';

function b24DealList($order = ['ID' => 'ASC'],$filter = ['ID' => 1],$select = ["ID", "TITLE", "STAGE_ID", "PROBABILITY", "OPPORTUNITY", "CURRENCY_ID"]){
    global $b24ApiNumber;
    global $b24ApiKey;
    $queryUrl = 'https://russam.bitrix24.ru/rest/'.$b24ApiNumber.'/'.$b24ApiKey.'/crm.deal.list';
    $queryData = http_build_query(array(
        'order' => $order,
        'filter' => $filter,
        'select' => $select
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
    return $result['result'];
}

function b24DealUpdate($id,$fields = []){
    global $b24ApiNumber;
    global $b24ApiKey;
    $queryUrl = 'https://russam.bitrix24.ru/rest/'.$b24ApiNumber.'/'.$b24ApiKey.'/crm.deal.update';
    $queryData = http_build_query(array(
        'id' => $id,
        'fields' => $fields,
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
    return $result['result'];
}