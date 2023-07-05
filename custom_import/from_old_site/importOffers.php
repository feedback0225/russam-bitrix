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
AddMessage2Log('Start import products');
?>
    <div class="container">
        <?
        use PhpOffice\PhpSpreadsheet\Spreadsheet;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


        $workbook = $reader->load("exportOffers.xlsx");

        $d = $workbook->getSheet(0)->toArray();

        //echo count($d);
        $workBook = $workbook->getActiveSheet()->toArray();
        $file_clmn = 1;
        //unset($workBook[0]);

        debug($workBook[0]);
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
                $workBook[0][7] => $dt[7],
                $workBook[0][8] => $dt[8],
                $workBook[0][9] => $dt[9],
                $workBook[0][10] => $dt[10],
                $workBook[0][11] => $dt[11],
                $workBook[0][12] => $dt[12],
                $workBook[0][13] => $dt[13],
                $workBook[0][14] => json_decode($dt[14]),
                $workBook[0][15] => $dt[15] ? $dt[15] : $dt[1],
                $workBook[0][16] => $dt[16],
                $workBook[0][17] => $dt[17],
                $workBook[0][18] => $dt[18],
                $workBook[0][19] => $dt[19],
                $workBook[0][20] => $dt[20],
                $workBook[0][21] => $dt[21],
                $workBook[0][22] => $dt[22],
                $workBook[0][23] => $dt[23],
                $workBook[0][24] => $dt[24],
                $workBook[0][25] => $dt[25],
            ];
            debug($productArrayInitial);
            $file_clmn++;
            if($key>1) break;
        }

        debug('OPENED FILE!!!');
        AddMessage2Log('Executed all!!!!');
        ?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>