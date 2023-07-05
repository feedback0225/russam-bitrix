<?php
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;


CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

function updateDiscounts()
{
    $discounts_list = [];
    global $DB;

    $arDiscountElementID = array();
    $dbProductDiscounts = CCatalogDiscount::GetList(
        array("SORT" => "ASC"),
        array(
            "ACTIVE" => "Y",
            "!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"),
                "YYYY-MM-DD HH:MI:SS",
                CSite::GetDateFormat("FULL")),
            "!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"),
                "YYYY-MM-DD HH:MI:SS",
                CSite::GetDateFormat("FULL")),
        ),
        false,
        false,
        array(
            "ID", "SITE_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO",
            "RENEWAL", "NAME", "SORT", "MAX_DISCOUNT", "VALUE_TYPE",
            "VALUE", "CURRENCY", "PRODUCT_ID", "PRIORITY"
        )
    );
    while ($arProductDiscounts = $dbProductDiscounts->Fetch()) {
        $discounts_list[$arProductDiscounts['ID']] = intval($arProductDiscounts['PRIORITY']);
    }


// меняем под себя эти значения
    $iblock_id = 5; // основной инфоблок

    $oldPropsSale = $arNewSale = array();

// перебираем все активные элементы нашего инфоблока
    $resItem = CIBlockElement::GetList(
        array("ID" => "asc"),
        array("ACTIVE" => "Y", "IBLOCK_ID" => $iblock_id),
        false,
        false,
        array("ID", "IBLOCK_ID", "PROPERTY_TOTAL_SALE")
    );
    while ($arItem = $resItem->Fetch()) {

        //обнуление всех и вся
        CIBlockElement::SetPropertyValuesEx($arItem["ID"], 5, ["TOTAL_SALE" => 0]);

        $offersExist = CCatalogSKU::getExistOffers($arItem["ID"], $arItem["IBLOCK_ID"]);

        // для товаров с SKU
        if ($offersExist[$arItem["ID"]] == 1) {
            // получим все SKU
            $resSku = CCatalogSKU::getOffersList(
                $arItem["ID"],
                $arItem["IBLOCK_ID"],
                array("ACTIVE" => "Y") // дополнительный фильтр предложений. по умолчанию пуст.
            );

            // Если нашли SKU
            if (!empty($resSku[$arItem["ID"]])) {
                // Перебираем их
                foreach ($resSku[$arItem["ID"]] as $sku) {
                    // смотрим есть ли для текущего предложения скидка
                    $arDiscounts = CCatalogDiscount::GetDiscountByProduct($sku["ID"], array(2), "N", 1, SITE_ID);// ID, группа пользователей, пр.подписки, Группа цены, сайт

                    // если нашлась скидка
                    if (!empty($arDiscounts)) {
                        foreach ($arDiscounts as $disc) {
                            if (array_key_exists($disc['ID'], $discounts_list)) {
                                if ($discounts_list[$disc['ID']] > $arNewSale[$arItem["ID"]]['PRIORITY']) {
                                    $arNewSale[$arItem["ID"]]['VALUE'] = intval($disc['VALUE']);
                                    $arNewSale[$arItem["ID"]]['PRIORITY'] = $discounts_list[$disc['ID']];
                                } else {
                                    continue;
                                }
                            }
                        }
                        break;
                    }
                }
            }
        } else {

            // смотрим есть ли для текущего предложения скидка
            $arDiscounts = CCatalogDiscount::GetDiscountByProduct($arItem["ID"], array(2), "N", 1, SITE_ID);// ID, группа пользователей, пр.подписки, Группа цены, сайт

            // если нашлась скидка
            if (!empty($arDiscounts)) {
                foreach ($arDiscounts as $disc) {
                    if (array_key_exists($disc['ID'], $discounts_list)) {
                        if ($discounts_list[$disc['ID']] > $arNewSale[$arItem["ID"]]['PRIORITY']) {
                            $arNewSale[$arItem["ID"]]['VALUE'] = intval($disc['VALUE']);
                            $arNewSale[$arItem["ID"]]['PRIORITY'] = $discounts_list[$disc['ID']];
                        } else {
                            continue;
                        }
                    }
                }
            }

        }

    }


// теперь проставляем свойство где нужно
    foreach ($arNewSale as $prodId => $propVal) {
        echo '<pre>';
        print_r([$prodId => $propVal['VALUE']]);
        echo '</pre>';
        CIBlockElement::SetPropertyValuesEx($prodId, 5, ["TOTAL_SALE" => $propVal['VALUE']]);
    }
}