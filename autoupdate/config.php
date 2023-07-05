<?php 
define('OZON_STATUS', true); // Включить автообновление - true, выключить - false
define('OZON_AUTH', '123554653463888232'); // Простейшая безопасность в ссылке домен?auth.php=код = https://market.russam.ru/autoupdate/start.php?auth=123554653463888232
define('OZON_CLIEN_ID', '157357'); // ID клиента
define('OZON_API_KEY', '9a110887-4e97-4c6a-b1bb-1c0b032f6959'); // Ключ API

define('OZON_WARHOUSES', [
	22599587401000,
	22641064527000,
]); // ID складов
 
define('OZON_MIN_PRICE', '30'); // Минимальная цена товара
define('OZON_AUTO_ACTION_ENABLED', 'UNKNOWN'); // Атрибут для включения и выключения автоприменения акций: ENABLED — включить автоприменение акций; DISABLED — выключить автоприменение акций; UNKNOWN — ничего не менять, передаётся по умолчанию.
define('OZON_CURRENCY_CODE', 'RUB'); // Валюта ваших цен: RUB — российский рубль, BYN — белорусский рубль, KZT — тенге, EUR — евро, USD — доллар США, CNY — юань.

// Крон задача: wget -O /dev/null -t 1 -q 'https://market.russam.ru/autoupdate/start.php?auth=123554653463888232' 

define('WB_STATUS', true); // Включить автообновление - true, выключить - false
define('WB_AUTH', '');
define('WB_WARHOUSES', 203422);
define('WB_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjYxZGJkYTg0LTg0NTQtNDM5Ny1hYzA1LWY5OTZhOTlmNTBhZSJ9.QrJ7tt-EUDCzk96Zyzg9_joJ69aKUVeKbURFyDQNnpw'); // Ключ API