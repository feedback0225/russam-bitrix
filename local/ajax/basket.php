<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
GLOBAL $APPLICATION;
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

// Получаем корзину пользователя
$basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
    \Bitrix\Sale\Fuser::getId(),
    SITE_ID
);

$basketCount = 0;

if($_POST['action'] == 'add') {
    if ($item = $basket->getExistsItem('catalog', $_POST['id'])) {
        $item->setField('QUANTITY', $item->getQuantity() + 1);
    }
    else {
        $item = $basket->createItem('catalog', $_POST['id']);
        $item->setFields(array(
            'QUANTITY' => 1,
            'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
            'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ));
    }
    $basket->save();
    echo json_encode(count($basket->getQuantityList()));
} elseif($_POST['action'] == 'remove') {
    $basketItems = $basket->getBasketItems();
    foreach ($basketItems as $basketItem) {
        if($basketItem->getProductId() == $_POST['id']){
            $basket->getItemById($basketItem->getId())->delete();
        }
    }
    $basket->save();
    echo json_encode(count($basket->getQuantityList()));
} elseif($_POST['action'] == 'check') {
    echo json_encode(productInBasket($_POST['id']));
}