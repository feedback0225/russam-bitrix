<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/config.php');

if (OZON_STATUS && isset($_GET['auth']) && $_GET['auth'] == OZON_AUTH) {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	$header = array(
		"Client-Id: " . OZON_CLIEN_ID . "",
		"Api-Key: " . OZON_API_KEY . "",
		"Content-Type: application/json"
	);
	
	$warehouses = OZON_WARHOUSES;
 
	$products = json_decode(file_get_contents('files/ozon.json'), true); 
	
	$load['prices'] = 0;
	$load['stocks'] = 0;
	$unload = array();
	foreach($products as $key => $product){
		if(($product['quantity'] < 1 || $product['price'] < 1) && $products[str_replace('.0', '', $key)]['price']){
			$products[$key] = $products[str_replace('.0', '', $key)];
			$products[$key]['article'] = $product['article'];
		}
		if(($product['quantity'] < 1 || $product['price'] < 1) && $products[$key.'.0']['price']){
			$products[$key] = $products[$key.".0"];
			$products[$key]['article'] = $product['article'];
		}
	}
	if (!empty($products)) {
		// echo '<pre>';
		// var_dump($products);
		// die;
		
		$products = array_chunk($products, 100);
	 
		foreach($products as $items) {
			$data = array();
			
			foreach($items as $product) {
				
				$data['prices'][] = array(
					'auto_action_enabled'		=> OZON_AUTO_ACTION_ENABLED,
					'currency_code'				=> OZON_CURRENCY_CODE,
					'min_price'					=> strval(!empty($product['price']) ? (int)((int)($product['price'] - ($product['price'] * (OZON_MIN_PRICE / 100)))) : "0"),
					'offer_id'					=> strval($product['article']),
					'old_price'					=> '0',
					'price'						=> "" . (int)$product['price'] . "",
					'product_id'				=> strval($product['product_id']),
				);
				
				foreach($warehouses as $warehouse) {
					$data['stocks'][] = array(
						'offer_id'					=> "" . $product['article'] . "",
						'stock'						=> $product['quantity'] ?? '0',
						'product_id'				=> $product['product_id'],
						'warehouse_id'				=> $warehouse,
					);
				}
				 
			}
			// global $APPLICATION;
			// 	$APPLICATION->RestartBuffer();
			// 	echo '<pre>';
			// 	print_r($data);
			// 	die();
			
			if (!empty($data['prices'])) {
				$data['prices'] = curl('POST', 'https://api-seller.ozon.ru/v1/product/import/prices', $data, $header);
				$stocks = array_chunk($data['stocks'], 100);
				 
		 
			 $data['stocks'] = array();
				foreach($stocks as $stock) {
					 
					$data['stocks'][] = curl('POST', 'https://api-seller.ozon.ru/v2/products/stocks', ['stocks' => $stock], $header);
	 usleep(100);
				}
				 
			}
			
			foreach ($data['prices']['result'] as $dat) {
				if (empty($dat['errors'])) {
					$load['prices']++;
				} else {
					$unload['prices'][] = array(
						'product_id'	=> $dat['product_id'],
						'offer_id'		=> $dat['offer_id'],
						'errors'		=> $dat['errors'],
					);
				}
			}
	 
			foreach ($data['stocks'] as $datssd) {
				foreach ($datssd['result'] as $dat) {
					 
					if (empty($dat['errors'])) {
						$load['stocks']++;
					} else {
						$unload['stocks'][] = array(
							'product_id'	=> $dat['product_id'],
							'offer_id'		=> $dat['offer_id'],
							'errors'		=> $dat['errors'],
						);
					}
				}
			}
 
			unset($data);
		}
		
		//file_put_contents('files/ozon.json', json_encode($data)); 
		 
		echo 'Обновлено цен: ' . $load['prices'];
		echo '<br>Не обновлено цен: ' . count($unload['prices']);
			 
		// echo '<br><br>Обновлено количество: ' . $load['stocks'];
		// echo '<br>Не обновлено количество: ' . count($unload['stocks']);
		
		echo '<pre>';
		print_r($unload['prices']);
		echo '</pre>';
				
	//	echo '<pre>';
	//	print_r($unload['stocks']);
	//	echo '</pre>';
		
		//header("Location: " . $url);
		//die();
	} else {
 
		header('Location: ' . $url . '/autoupdate/start.php?auth=' . OZON_AUTH);
		die();
	}
	
 
	//header("Location: " . $url);
	//die();
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
 
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);  
	
	
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