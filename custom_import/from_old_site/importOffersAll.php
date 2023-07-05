<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require __DIR__.'/../../vendor/autoload.php';
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
CModule::IncludeModule('catalog');
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {return false;}
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class;
}
$storeNAME2ID = [
    '1530' => 7,
];
AddMessage2Log('Start import products OFFERS');
?>
    <div class="container">
        <?
        use PhpOffice\PhpSpreadsheet\Spreadsheet;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


        $workbook = $reader->load("exportOffersNew.xlsx");

        $d = $workbook->getSheet(0)->toArray();

        //echo count($d);
        $workBook = $workbook->getActiveSheet()->toArray();
        $file_clmn = 1;
        //unset($workBook[0]);

        AddMessage2Log($workBook[0]);
        foreach ($workBook as $key=>$dt) {
            if($key == 0) continue;
            // process element here;
            //debug($workBook[0][0]);
            $productArrayInitial = [
                $workBook[0][0] => $dt[0],
                $workBook[0][1] => $dt[1],
                $workBook[0][2] => $dt[2],
                $workBook[0][3] => $dt[3],
                $workBook[0][4] => $dt[4],
                $workBook[0][5] => $dt[5],
                $workBook[0][6] => $dt[6],
                $workBook[0][7] => $dt[7]
            ];

            $curProductId = existProductWithProp('MAIN_PRODUCT_ID',str_replace('_'.$productArrayInitial['Штрих-код'],'',$productArrayInitial['Код варианта 1С']),5);
            debug($curProductId);
            if($curProductId){
                $obElement = new CIBlockElement();
                // свойства торгвоого предложения
                $arOfferProps[31] = $curProductId;
                $arOfferProps[39] = $productArrayInitial['Код варианта 1С'];
                $arOfferFields = array(
                    'NAME' => $productArrayInitial['Код варианта 1С'],
                    'IBLOCK_ID' => 6,
                    'ACTIVE' => 'Y',
                    'PROPERTY_VALUES' => $arOfferProps
                );

                $offerId = existProductWithProp('SERIES_ID_PROPERTY',$productArrayInitial['Код варианта 1С'],6);
                if($offerId){
                    $obElement->Update($offerId,$arOfferFields);//Обновление торгового предложения
                    //debug("Обновление торгового предложения \"{$offerId}\" в каталог товаров");
                    $catalogProductAddResult =	CCatalogProduct::Update($offerId,array(
                        'QUANTITY' => 1,
                        'WEIGHT' => 0,
                        'WIDTH' => 0,
                        'LENGTH' => 0,
                        'HEIGHT' => 0,
                    ));
                } else {
                    $offerId = $obElement->Add($arOfferFields);//Добавление торгового предложения
                    //debug("Добавление торгового предложения \"{$offerId}\" в каталог товаров");
                    $catalogProductAddResult =	CCatalogProduct::Add(array(
                        'ID' => $offerId,
                        'QUANTITY' => 1,
                        'WEIGHT' => 0,
                        'WIDTH' => 0,
                        'LENGTH' => 0,
                        'HEIGHT' => 0,
                    ));
                }
                debug('offerID: ' . $offerId);
                if(!$offerId) continue;
                if ($catalogProductAddResult && !CPrice::SetBasePrice($offerId, $productArrayInitial['Цена'], "RUB"))
                    throw new Exception("Ошибка установки цены торгового предложения \"{$offerId}\"");
                $rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $offerId, 'STORE_ID' => $storeNAME2ID[$productArrayInitial['ID Склада']]));
                $arFields = Array(
                    "PRODUCT_ID" => $offerId,
                    "STORE_ID" => $storeNAME2ID[$productArrayInitial['ID Склада']],
                    "AMOUNT" => 1,
                );
                $existOfferStore = false;
                while($ar_fields = $rs->GetNext())
                {
                    $existOfferStore = true;
                    CCatalogStoreProduct::Update($ar_fields['ID'], $arFields);
                    continue;
                }
                if(!$existOfferStore) CCatalogStoreProduct::Add($arFields);
            }
        }
        AddMessage2Log('Executed all!!!!');
        ?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>