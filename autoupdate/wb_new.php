<?php
if(!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
}
ini_set("memory_limit", "10240M");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
set_time_limit(0);
ini_set('max_execution_time', 3600);
require_once(__DIR__ . '/config.php');

die();

if (WB_STATUS && WB_API_KEY && isset($_GET['auth']) && $_GET['auth'] == WB_AUTH) {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	
	
	$errors = array();
	$products_wb = array();
	
	$text = [];
	
	// Получаем все НМ Вб
	$additional = [];
	for ($n = 0; $n <= 10; $n++) {
		$products = curl('POST', 'https://suppliers-api.wildberries.ru/content/v1/cards/cursor/list',  [
            "sort" => [
                "cursor" => array_merge([
                    "limit" => 1000,
                    // 'offset' 		=> $n * 1000,
                ], $additional),
                "filter" => [
                    "withPhoto" => -1
				],
				"sort" => [
					"sortColumn" => "updateAt",
					"ascending" => false
				]
            ]
        ], array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));
		if (isset($products['data']['cards']) && !empty($products['data']['cards'])) {
			foreach ($products['data']['cards'] as $product) {
 
				$barcodes = array();
				foreach ($product['sizes'] as $sizes) {

					$sizes['techSize'] = str_replace(',', '-', $sizes['techSize']);
					$sizes['techSize'] = str_replace('.', '-', $sizes['techSize']);

					foreach ($sizes['skus'] as $sku) {
						$barcodes[$sizes['techSize']] = $sku;
					}
				}

				$products_wb[$product['nmID']] = array(
					'sku'			=> $product['vendorCode'],
					'barcode'		=> "" . (isset($barcodes[0]) ? $barcodes[0] : '') . "",
					'barcodes'		=> $barcodes,
					'nmID'			=> $product['nmID'],
					'price'			=> '',
					'discount'		=> '',
					'warehouseId'	=> '',
					'stock'			=> '',
				);
			}
			$additional = [
				'nmID' => $products['data']['cursor']['nmID'],
				'updatedAt' => $products['data']['cursor']['updatedAt']
			];
		} else {
			break;
		}
		
	}
	


 
	// Получение информации о ценах.
	$products = curl('GET', 'https://suppliers-api.wildberries.ru/public/api/v1/info?quantity=0', [], array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));

	
	if (!empty($products)) {
		foreach ($products as $product) {
			if (isset($product['barcode']) && !empty($product['barcode'])) {
				$products_wb[$product['nmId']]['barcode'] = "" . $product['barcode'] . "";
			}
			$products_wb[$product['nmId']]['price'] = $product['price'];
			$products_wb[$product['nmId']]['discount'] = $product['discount'];
		}
	}

	
	// Получение информации об остатках.
	for ($n = 0; $n <= 10; $n++) {
		$products = curl('GET', 'https://suppliers-api.wildberries.ru/api/v2/stocks?skip=' . ($n * 1000) . '&take=1000', [], array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));
		
		if (!empty($products['stocks'])) {
			foreach ($products['stocks'] as $product) {
				if (isset($product['barcode']) && !empty($product['barcode'])) {
					$products_wb[$product['nmId']]['barcode'] = "" . $product['barcode'] . "";
				}
				
				if (empty($products_wb[$product['nmId']]['barcode'])) {
					// Записываю ошибку остутсвующего бардкоде 
					$errors[] = 'Отсутсвует штрихкод';
					
					unset($products_wb[$product['nmId']]);
				}
				$products_wb[$product['nmId']]['warehouseId'] = 203422;//!empty($product['warehouseId']) ? (int)$product['warehouseId'] : WB_WARHOUSES;
				$products_wb[$product['nmId']]['stock'] = (int)$product['stock'];
			}
		} else {
			break;
		}
	}
 
	// $products_wb = array_chunk($products_wb, 1000);


	$sends = array(
		'prices' => [],
		'stocks' => []
	);
		
	$message = array(
		'prices' => [],
		'stocks' => []
	);
 
	CModule::IncludeModule('iblock');
	CModule::IncludeModule('catalog');
	// foreach ($products_wb as $products) {
		$products = $products_wb;
		$skus = array();
		$skus_variant = array();
		foreach ($products as $product) {
			if (stristr($product['sku'], '-') === FALSE) {
 
			} else { ///
				$param = explode('-', $product['sku']);
				$skus_variant[$param[0]] = $param[1];
			}
			 
			$skus[] = $product['sku'];
			$skus[] = $product['sku'] . '000000';
		}
	 
	 
		/*Получаем все ИД товара*/
		$resIblock = CIBlockElement::GetList(
		   array('ID' => 'ASC'), 
		   array(
		   'IBLOCK_ID' => '5',
		   'PROPERTY_55_9306171' => $skus,
		   'ACTIVE' => 'Y'
		   ), 
		   false, 
		   false,
		   array('ID', 'CODE', 'PROPERTY_55_9306171_VALUE', 'NAME')
		);
		 
	 	
	 
		$productID = array();
		$productIDS = array();
		
		while($arID = $resIblock->Fetch()) {
			$productID[] = $arID['ID'];
			
			$productIDS[$arID['ID']] = [
				'sku' 		=> $arID['PROPERTY_55_9306171_VALUE_VALUE'],
				'size' 		=> [],
				'price' 	=> [],
				'quantity' 	=> [],
				'name' => $arID['NAME']
			];
		}
		 
		
		
		$results = CCatalogSKU::getOffersList(
			$productID, // массив ID товаров
			5, // указываете ID инфоблока только в том случае, когда ВЕСЬ массив товаров из одного инфоблока и он известен
			array('ACTIVE' => 'Y'),
			array('PROPERTY_41_VALUE', 'PROPERTY_40_VALUE', 'PROPERTY_46_VALUE', 'PROPERTY_44_VALUE', 'PROPERTY_45_13901793_VALUE', 'PROPERTY_43_VALUE', 'ACTIVE'),
			array('ID')
		);
		foreach ($results as $key => $result) {
			 	
			
			foreach ($result as $res) {
				$res['PROPERTY_46_VALUE_VALUE'] = str_replace('28-', '', $res['PROPERTY_46_VALUE_VALUE']);
				$res['PROPERTY_46_VALUE_VALUE'] = str_replace('.', '-', $res['PROPERTY_46_VALUE_VALUE']);
			 
				$sklad = strpos($res['PROPERTY_44_VALUE_VALUE'], 'ЮС093'); // Проверка на остатки по складам
				
				if ($res['ACTIVE'] == 'Y') {
					$arFilter = Array("PRODUCT_ID" => $res['ID']);
					$rsStoreAmount = CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array('AMOUNT'));
					$sklads = array();
					
					while($arStoreAmount = $rsStoreAmount->Fetch()) {
						$sklads[] = $arStoreAmount['AMOUNT'];
					}
					
					$res['PROPERTY_44_VALUE_VALUE'] = array_sum($sklads);
					if(!$res['PROPERTY_44_VALUE_VALUE']){
						$res['PROPERTY_44_VALUE_VALUE'] = CCatalogProduct::GetByID($res['ID'])['QUANTITY'];
					}
				}else{
					$res['PROPERTY_44_VALUE_VALUE'] = 0;
				}
				
				// if($productIDS[$key]['sku'] == 41537){
				// 	global $APPLICATION;
				// 	$APPLICATION->RestartBuffer();
				// 	echo '<pre>';
				// 	print_r($productIDS[$key]);
				// 	print_r($res);
				// 	print_r($sklads);
				// 	die();
				// }


				if ($res['PROPERTY_44_VALUE_VALUE']) {
					$productIDS[$key]['size'][!empty($res['PROPERTY_46_VALUE_VALUE']) ? $res['PROPERTY_46_VALUE_VALUE'] : (int)$res['PROPERTY_46_VALUE_VALUE']] += (int)ltrim($res['PROPERTY_44_VALUE_VALUE'], '0');
			 
				} elseif (!$productIDS[$key]['size'][$res['PROPERTY_46_VALUE_VALUE']]) {
					// unset($productIDS[$key]['size'][$res['PROPERTY_46_VALUE_VALUE']]);// = 0;
					$productIDS[$key]['size'][$res['PROPERTY_46_VALUE_VALUE']] = 0;
				}
				$productIDS[$key]['discount'] = CCatalogProduct::GetOptimalPrice($res['ID'])['RESULT_PRICE']['PERCENT'];
				$productIDS[$key]['price'][] = $arPrice = CCatalogProduct::GetOptimalPrice($res['ID'])['PRICE']['PRICE'];//['DISCOUNT_PRICE'];
				// global $APPLICATION;
				// $APPLICATION->RestartBuffer();
				// echo '<pre>';
				// print_r($arPrice);
				// die();
				// $productIDS[$key]['price'][] = (int)$res['PROPERTY_41_VALUE_VALUE'];
				// $productIDS[$key]['price'][] = (int) $res['PROPERTY_43_VALUE_VALUE'] ?? (int)$res['PROPERTY_41_VALUE_VALUE'];
			}
			
		}
		//
		$new_products = array();
		$new_products_quantity = array();



        foreach ($productIDS as $key => $product) {
			$product['sku'] = str_replace("000000", "", $product['sku']);
			
			$sizes = array();
			
			if (!empty($product['size'])) {
				foreach ($product['size'] as $size => $quantity) {
					// $size = preg_replace("/\.?0*$/",'', $size); 
					$sizes[$size] = $sizes[$size] + $quantity;
				}
			}
			$new_products[$product['sku']] = array(
				'price'		=> !empty($product['price']) ? max($product['price']) : 0,
				'size'		=> $sizes,
				'discount' => $product['discount']
				//'quantity'	=> !empty($product['quantity']) ? max($product['quantity']) : 0,
			);

            // if($product['sku'] == 41537){
                // global $APPLICATION;
                // $APPLICATION->RestartBuffer();
			var_dump('Артикул '.$product['sku']);
            echo '<pre>';
            print_r($new_products[$product['sku']]);
                // die();
            // }
		}
        $action_products = array(
			'isset'	=> [],
			'empty'	=> [],
		);
		$action_products_stock = array(
			'isset'	=> [],
			'empty'	=> [],
		);
		$arrayNM = [];
		foreach ($products as $key => $product) {
			if (isset($new_products[$product['sku']]['price']) && !empty($product['nmID'])) {
				$action_products['isset'][] = array(
					'sku'			=> $product['sku'],
					'nmID'			=> $product['nmID'],
					'old_price'		=> $product['price'],
					'price'			=> !empty($new_products[$product['sku']]['price']) ? (int)$new_products[$product['sku']]['price'] : 0,
					'discount'		=> !empty($new_products[$product['sku']]['discount']) ? $new_products[$product['sku']]['discount'] : 0,
					'found'			=> 1,
				);
				
				if(!in_array($product['sku'], $arraySKU) && !in_array($product['nmID'], $arrayNM) && $new_products[$product['sku']]['discount'] > 0 && $new_products[$product['sku']]['price'] > 0):
					$arrayNM[] = $product['nmID'];
					$arraySKU[] = $product['sku'];
					$obj = new stdClass();
					$obj->discount = !empty($new_products[$product['sku']]['discount']) ? $new_products[$product['sku']]['discount'] : 0;
					$obj->nm = $product['nmID'];
					$action_products['discount'][] = $obj;
				endif;

			} else {
				$action_products['empty'][] = array(
					'sku'			=> $product['sku'],
					'nmID'			=> $product['nmID'],
					'found'			=> 0,
				);
			}
			foreach ($product['barcodes'] as $size => $barcode) {
				$size = str_replace('-0', '', $size);
				// if (isset($new_products[$product['sku']]['size'][$size]) && !empty($product['warehouseId']) && !empty($barcode)) {
				if (isset($new_products[$product['sku']]['size'][$size]) && !empty($barcode)) {					
					$action_products_stock['isset'][$product['sku']][] = array(
						'sku'			=> $product['sku'],
						'barcode'		=> $barcode,
						'old_stock'		=> $product['stock'],
						'stock'			=> !empty($new_products[$product['sku']]['size'][$size]) ? (int)$new_products[$product['sku']]['size'][$size] : 0,
						
						'warehouseId'	=> 203422,//$product['warehouseId'] ? (int)$product['warehouseId'] : 203422,
						'found'			=> 1,
					);
					
				} else {
					$action_products_stock['empty'][] = array(
						'sku'			=> $product['sku'],
						'nmID'			=> $product['nmID'],
						'barcode'		=> $barcode,
						'found'			=> 0,
					);
				}
				 
			}
		}
		die;
        // WB ибет мозг, если цена отличается более чем на 20%. Приходится передавать промежуточные цены с разницей не более 20% от старой.
        //обновление старой цены на WB происходит в течении суток, или около того. выяснить точно нет возможности.
        $tmpArr = [];
        $priceArr = $action_products['isset'];
        foreach ($priceArr as $key => &$product) {
            if (intval($product['price']) >= (intval($product['old_price'])*1.2)) {
                $product['price'] = intval($product['old_price'] * 1.15);
                $tmpArr[] = $product;
            }
//            unset($priceArr[$key]);
            unset($product['sku']);
            unset($product['old_price']);
            unset($product['found']);
            if (!$product['nmID'] || !$product['price'])
                unset($priceArr[$key]);
        }
        unset($product);

        $priceArr = array_values($priceArr);
		
		$productsIsset = array_chunk($action_products_stock['isset'], 1000);
		if (!empty($action_products['isset'])) {
			$pricesArr = array_chunk($priceArr, 1000);
			foreach($pricesArr as $prices)
				$sends['prices'][] = curl('POST', 'https://suppliers-api.wildberries.ru/public/api/v1/prices', $prices, array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));
		}
		
		

		if (!empty($action_products_stock['isset'])) {
			foreach ($productsIsset as $products) {
				foreach($products as $product){
					// $stocks = [];
					
					foreach ($product as $sku) {
						$stocks[$sku['warehouseId']][] = ['sku' => $sku['barcode'], 'amount' => $sku['stock']];
					}
					
				}
			}
			foreach($stocks as $warehouse => $prods){
				$prodsNew = array_chunk($prods, 1000);
				foreach ($prodsNew as $newProds) {
					$arr = [
						'stocks' => $newProds
					];
					$sends['stocks'][] = curl('PUT', 'https://suppliers-api.wildberries.ru/api/v3/stocks/56319', $arr, array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"), true);
				}
			}
		}
		if (!empty($action_products['discount'])) {
			$productsIsset = array_chunk($action_products['discount'], 1000);
			foreach($productsIsset as $discounts){
				$temp = array_unique(array_column($discounts, 'nmID'));
				$unique_arr = array_intersect_key($discounts, $temp);
				$sends['discounts'][] = curl('POST', 'https://suppliers-api.wildberries.ru/public/api/v1/updateDiscounts', $discounts, array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"), true, true);
				
			}
				
		}
		// if (!empty($action_products['isset'])) {
		// 	$sends['prices'][] = curl('POST', 'https://suppliers-api.wildberries.ru/public/api/v1/prices', $priceArr, array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));
		// }
		
		// if (!empty($action_products_stock['isset'])) {
		// 	$sends['stocks'][] = curl('POST', 'https://suppliers-api.wildberries.ru/api/v2/stocks', $action_products_stock['isset'], array("Authorization: " . WB_API_KEY . "", "Content-Type: application/json"));
		// }
		
		$message['prices'][] = $action_products;
		$message['stocks'][] = $action_products_stock;
		
		$text[] = [
			'text'		=> [
				'цены: - найдено: ' . count($action_products['isset']) . ';  - не найдено: ' . count($action_products['empty']),
				'количество: - найдено: ' . count($action_products_stock['isset']) . ';  - не найдено: ' . count($action_products_stock['empty'])
			],
			'error'		=> []
		];
		
 
		// debug($sends);
	 
	// }
	 
	?>
<!DOCTYPE html>
<html>
<body>
	<table>
	  <tr>
		<th>Выгрузка</th>
		<th>Сообщение</th>
		<th>Ошибка</th>
	  </tr>
	  <?php
		foreach ($text as $count => $tex) {
			?>
			<tr>
				<td><?php echo ($count + 1); ?></td>
				<td><?php echo implode('<br>', $tex['text']); ?></td>
				<td><?php echo implode('<br>', $tex['error']); ?></td>
			</tr>
			<?php
		}
	  ?>
	 
	</table>
</body>
<style>
table {
	width: 100%;
}
th {
   border: 1px solid grey;
   padding: 5px 10px;
}
td {
   border: 1px solid grey;
   padding: 5px 10px;
}
</style>
</html>
	<?php 
	
	echo '<h2>API Цены</h2><BR>';

	echo '<pre>';
	print_r($sends['prices']);
	echo '</pre>';
	echo '<hr><h2>API Количество</h2><BR>';
	echo '<pre>';
	print_r($sends['stocks']);
	echo '</pre>';
	echo '<h2>Передаваемые данные Скидки</h2><BR>';
	echo '<pre>';
	print_r($sends['discounts']);
	print_r($action_products['discount']);
	
	echo '</pre>';
	echo '<hr>';


    echo '<h2>Товары с ценами отличающиеся более чем на 20%</h2><BR>';
    echo '<pre>';
    print_r($tmpArr);
    echo '</pre>';
	echo '<h2>Передаваемые данные Цены</h2><BR>';
	echo '<pre>';
	print_r($message['prices']);
	echo '</pre>';
	
	echo '<hr><h2>Передаваемые данные Количество</h2><BR>';
	echo '<pre>';
	print_r($message['stocks']);
	echo '</pre>';
 
/*
	debug($action_products);
		debug($action_products_stock);
 */

	/* */
	
	//header("Location: /");
	//exit();
} else {
	header("Location: /");
	die();
}	
 
function curl($method = "POST", $url, $data = array(), $headers = array(), $ssl = true, $makeCurl = false) {
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
	$response = curl_getinfo($curl);
	$error = curl_error($curl);    
	
	curl_close($curl);
		
	if ($error) {
		$result = $error;
	} else {
		$result = json_decode($result, JSON_UNESCAPED_UNICODE);
	}

	return $result;
} 