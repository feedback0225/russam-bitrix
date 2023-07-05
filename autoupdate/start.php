<?php
if(!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
}
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
set_time_limit(0);
ini_set('max_execution_time', 3600);
require_once(__DIR__ . '/config.php');

die();

if (OZON_STATUS && isset($_GET['auth']) && $_GET['auth'] == OZON_AUTH) {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	$header = array(
		"Client-Id: " . OZON_CLIEN_ID . "",
		"Api-Key: " . OZON_API_KEY . "",
		"Content-Type: application/json"
	);
	 
	$products = array();
	$products_count_ozon = array();

	$last_id = '';
	$total = 0;

	for ($i = 1; $i <= 100; $i++) { // https://market.russam.ru/autoupdate/start.php?auth=
		$products_ozon = curl('POST', 'https://api-seller.ozon.ru/v2/product/list', ['last_id' => $last_id, 'limit' => 1000], $header);
 
		if (!empty($products_ozon['result']['items'])) {
			$products = array_merge((array)$products, (array)$products_ozon['result']['items']);
		}
	 
		if (empty($products_ozon['result']['last_id'])) {
			$total = $products_ozon['result']['last_id'];
			break;
		} else {
			$last_id = $products_ozon['result']['last_id'];
		}
 
	}
 
	foreach($products as $item) {
		$products_count_ozon[$item['offer_id']] = $item['offer_id'];
		$products_ids[$item['offer_id']] = $item['product_id'];
	}

	if (!empty($products)) {
		$products = array_chunk($products, 500);
		 
		$products_arrs = array();
		
		foreach ($products as $items) {
			foreach ($items as $product) {
	 
				if (stristr($product['offer_id'], '41492') === FALSE) { // 41581
					//continue;
				}
				
				$unset = false;
				
				$product['variant'] = '';
				$article = $product['offer_id'];
				// $article1 = preg_replace("/\.?0*$/",'', $product['offer_id']);
				$article1 = $product['offer_id'];
				// $article = str_replace('.0', '', $article);
				if (stristr($product['offer_id'], '-') === FALSE) {
				 
				} else {
					$param = explode('-', $product['offer_id']);
					$product['offer_id'] = $param[0];
					$product['variant'] = $param[1];
				}
				 
				$result = $DB->Query("SELECT ID, IBLOCK_ELEMENT_ID FROM `b_iblock_element_property` WHERE (IBLOCK_PROPERTY_ID = '55' AND VALUE = '" . $product['offer_id'] . "') OR (IBLOCK_PROPERTY_ID = '55' AND VALUE LIKE '" . $product['offer_id'] . "%') LIMIT 1");
				$result = $result->Fetch();
				$res = $result;
				$id = $result['IBLOCK_ELEMENT_ID'];
				$result = $DB->Query("SELECT ID, IBLOCK_ELEMENT_ID FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID = '31' AND VALUE = '" . $result['IBLOCK_ELEMENT_ID'] . "'");
		 
				$result2Rows = array();
				   
				while ($row = $result->Fetch()) {
					$resultRow = $row;
					$result2 = $DB->Query("SELECT IBLOCK_PROPERTY_ID, VALUE, IBLOCK_ELEMENT_ID FROM `b_iblock_element_property` WHERE IBLOCK_PROPERTY_ID IN('41', '45', '46') AND IBLOCK_ELEMENT_ID = '" . $row['IBLOCK_ELEMENT_ID'] . "'");
					
					while ($row2 = $result2->Fetch()) {

						$active = $DB->Query("SELECT ACTIVE FROM `b_iblock_element` WHERE ID = '" . $row2['IBLOCK_ELEMENT_ID'] . "' LIMIT 1");
						$active = $active->Fetch();
						
						$price = $DB->Query("SELECT PRICE FROM `b_catalog_price` WHERE PRODUCT_ID = '" . $row2['IBLOCK_ELEMENT_ID'] . "' LIMIT 1");
						$price = $price->Fetch();
			  
						$quantity = $DB->Query("SELECT QUANTITY FROM `b_catalog_product` WHERE ID = '" . (int)$row2['IBLOCK_ELEMENT_ID'] . "'");
						$quantity = $quantity->Fetch();
					 
						if (isset($quantity['QUANTITY']) && !empty($price['PRICE']) && $active['ACTIVE'] == 'Y') {
							if ($row2['IBLOCK_PROPERTY_ID'] == 46) {
								$result2Rows[$row2['IBLOCK_ELEMENT_ID']]['article'] =  $row2['VALUE'];
							} 
							
							$result2Rows[$row2['IBLOCK_ELEMENT_ID']]['price'] = isset($price['PRICE']) ? $price['PRICE'] : 0;
							$result2Rows[$row2['IBLOCK_ELEMENT_ID']]['quantity'] =  $quantity['QUANTITY'];
						}
						if(!$quantity['QUANTITY']){
							$result2Rows[$row2['IBLOCK_ELEMENT_ID']]['quantity'] = CCatalogProduct::GetByID($row2['IBLOCK_ELEMENT_ID'])['QUANTITY'];
							if($result2Rows[$row2['IBLOCK_ELEMENT_ID']]['quantity']){
								$result2Rows[$row2['IBLOCK_ELEMENT_ID']]['price'] = isset($price['PRICE']) ? $price['PRICE'] : 0;
							}
						}
						
					}
					
			 
				}
				if($resultRow['IBLOCK_ELEMENT_ID'] == 114219){
					// global $APPLICATION;
					// $APPLICATION->RestartBuffer();
					// echo '<pre>';
					// print_r($resultRow);
					// die();
				}
				if($id == 113510):
					// global $APPLICATION;
					// $APPLICATION->RestartBuffer();
					// echo '<pre>';
					// print_r($result2Rows);
					// die();
				endif;
				if (empty($result2Rows)) {
					$price = $DB->Query("SELECT PRICE FROM `b_catalog_price` WHERE PRODUCT_ID = '" . $resultRow['IBLOCK_ELEMENT_ID'] . "' LIMIT 1");
					$price = $price->Fetch();
					
					$quantity = $DB->Query("SELECT * FROM `b_catalog_product` WHERE ID = '" . (int)$resultRow['IBLOCK_ELEMENT_ID'] . "'");
					$quantity = $quantity->Fetch();
					if(!$quantity){
						$quantity = CCatalogProduct::GetByID((int)$resultRow['IBLOCK_ELEMENT_ID']);
					}
					$result2Rows['fa']['article'] =  $article;
					$result2Rows['fa']['price'] = isset($price['PRICE']) ? $price['PRICE'] : 0;
					$result2Rows['fa']['quantity'] =  $quantity['QUANTITY'];
					
					 
				}
			 
				if (!empty($result2Rows)) {
					
					usort($result2Rows, function($a, $b){
						return ($a['price'] - $b['price']);
					});
					
					$result2Rowss = array();
					foreach($result2Rows as $result2Row) {
						if (isset($result2Row['price'])) {
							 
							$article2 = explode('-', $result2Row['article']);
							$article2 = isset($article2[1]) ? $product['offer_id'] . '-' . $article2[1] : $article1;
							// $article2 = str_replace('.0', '', $article2);
							// if ($article2 == $article1) {
								if($products_arrs[$article2]['price'] < $result2Row['price']):
									$quantity = 0;
									if(isset($products_arrs[$article2])){
										if($products_arrs[$article2]['quantity'] > $result2Row['quantity']){
											$quantity = $products_arrs[$article2]['quantity'];
										}
									}
									$products_arrs[$article2] = array(
										'product_id'	=> $products_ids[$article2] ?? $product['product_id'],
										'article'		=> $article2,
										'quantity'		=> ($quantity > 0 ? $quantity : ($result2Row['quantity'] ? $result2Row['quantity'] : '0')),
										'price'			=> intval($result2Row['price']),
									);
									$unset = true;
								endif;
								// break;
							// }
						}
					}
					// if($id == 113510):
					// 	global $APPLICATION;
					// 	$APPLICATION->RestartBuffer();
					// 	echo '<pre>';
					// 	print_r($article1);
					// 	print_r($result2Rows);
					// 	die();
					// endif;
					if (empty($unset)) {
						$products_arrs[$article] = array(
							'product_id'	=> $product['product_id'],
							'article'		=> $article,
							'quantity'		=> 0,
							'price'			=> 0,
						);
						
						$unset = true;
					}
			 
					unset($result2Rows);
			 
				} else {
					$products_arrs[$article] = array(
						'product_id'	=> $product['product_id'],
						'article'		=> $article,
						'quantity'		=> 0,
						'price'			=> 0,
					);
					
					unset($products_count_ozon[$article]);
				}
				 
				if (!empty($unset)) {
					unset($products_count_ozon[$article]);
				}
		 
			}
			
			sleep(3);
		}
		
		file_put_contents('files/ozon.json', json_encode($products_arrs)); 
		
		sleep(2);
 
		header('Location: ' . $url . '/autoupdate/update.php?auth=' . OZON_AUTH);
		die();
	}




	/*
	$dataw = array(
		'offer_id'		=> $items['offer_id'],
		'id'	=> $items['id'],
	);

	$products_ozonw = curl('POST', 'https://api-seller.ozon.ru/v2/product/info', $dataw, $header);
 
	*/


	/* */
	
	header("Location: /");
	exit();
} else {
	header("Location: /");
	die();
}	
 
function curl($method = "POST", $url, $data = array(), $headers = array(), $ssl = true) {
	$curl = curl_init(); 

	curl_setopt($curl, CURLOPT_URL, $url);    
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	
	curl_setopt($curl, CURLOPT_HEADER, false);
	
	if ($method == 'POST') {
		curl_setopt($curl, CURLOPT_POST, true);
	}
 
	if (!empty($headers)) {
		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	} else {
	 
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	}
 
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout in seconds
	
	
	if ($ssl == false) {
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	}
	
	$result = curl_exec($curl);   

	$error = curl_error($curl);    
	
	curl_close($curl);
		
	if ($error) {
		$result = $error;
	} else {
		$result = json_decode($result, JSON_UNESCAPED_UNICODE);
	}

	return $result;
} 