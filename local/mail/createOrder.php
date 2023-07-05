<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$el = new CIBlockElement;
$PROP = array();
$arEventFields = [];
$elementName = 'Заявка с сайта';
$title = 'Ошибка!';
if ($_POST['mailTemplate'] == 'SUBSCRIPTION') {
	$elementName = 'Подписка';
	$title = 'Подписка на новости / блог';
} elseif ($_POST['mailTemplate'] == 'GET_PRODUCT_PRICE') {
	$elementName = 'Запрос цены';
	$title = 'Запрос цены';
} elseif ($_POST['mailTemplate'] == 'ORDER_PRODUCT_SIZE') {
	$elementName = 'Заказать изделие по моему размеру';
	$title = 'Нет нужного размера';
} elseif ($_POST['mailTemplate'] == 'SITE_SEND_ORDER') {
	$elementName = 'Быстрый заказ/Оформление заказа';
	$title = 'Быстрый заказ';
} elseif ($_POST['mailTemplate'] == 'ORDER_PRODUCT_FROM_TIME') {
	$elementName = 'Изделие под заказ';
	$title = 'Изделие под заказ';
}

foreach ($_POST as $pKey => $pValue) {
	$arEventFields[mb_strtoupper($pKey)] = $pValue;
	$PROP[mb_strtoupper($pKey)] = $pValue;
}
function createOrderFromForm($productString, $elName)
{
	$productID = str_replace(' ', '', (explode("]", $productString)[0]));
	$productID = explode(':', $productID)[1];

	$products = array(
		array('PRICE' => $_POST['productPrice'], 'PRODUCT_ID' => $productID, 'NAME' => explode('[', $productString)[0] . ' (' . $elName . ')', 'CURRENCY' => 'RUB', 'QUANTITY' => 1)
	);
	$basket = Bitrix\Sale\Basket::create(SITE_ID);
	foreach ($products as $product) {
		$item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
		unset($product["PRODUCT_ID"]);
		$item->setFields($product);
	}

	$order = Bitrix\Sale\Order::create(SITE_ID, 1);
	$order->setPersonTypeId(1);
	$order->setBasket($basket);

	$shipmentCollection = $order->getShipmentCollection();
	$shipment = $shipmentCollection->createItem(
		Bitrix\Sale\Delivery\Services\Manager::getObjectById(3)
	);

	$shipmentItemCollection = $shipment->getShipmentItemCollection();

	foreach ($basket as $basketItem) {
		$item = $shipmentItemCollection->createItem($basketItem);
		$item->setQuantity($basketItem->getQuantity());
	}

	$paymentCollection = $order->getPaymentCollection();
	$payment = $paymentCollection->createItem(
		Bitrix\Sale\PaySystem\Manager::getObjectById(4)
	);

	$payment->setField("SUM", $order->getPrice());
	$payment->setField("CURRENCY", $order->getCurrency());

	$result = $order->save();
	if (!$result->isSuccess()) {
		AddMessage2Log($result->getErrors());
		return false;
	}
	return $result->getId();
}

foreach (\Bitrix\Main\Config\Option::get("askaron.settings", "UF_SEND_EMAIL_TO") as $email) {
	$arEventFields['EMAIL'] = $email;
	CEvent::Send($_POST['mailTemplate'], "s1", $arEventFields, "N", "", "", "");
	CEvent::CheckEvents();
}
if ($_POST['product']) {
	$productID = str_replace(' ', '', (explode("]", $_POST['product'])[0]));
	$productID = explode(':', $productID)[1];
	$article = 0;
	$res = CIBlockElement::GetByID($productID);
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$article = explode('_', $arProps['SERIES_ID_PROPERTY']['VALUE'])[0] ? explode('_', $arProps['SERIES_ID_PROPERTY']['VALUE'])[0] : $arProps['ARTICLE']['VALUE'];
	}

	echo createLead(['ARTICLE' => $article, 'TITLE' => $title, 'PHONE' => $_POST['phoneNumber'], 'PRODUCTS_ID' => [$productID]]);
}
