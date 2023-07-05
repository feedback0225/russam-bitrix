<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require __DIR__.'/../../vendor/autoload.php';
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
CModule::IncludeModule('catalog');
?>

<?
function updateElementSections($id,$sectionID){
    $ElementId = $id;
    $db_groups = CIBlockElement::GetElementGroups($ElementId,false,['ID','NAME','IBLOCK_ID','IBLOCK_SECTION_ID']);
    $sectionList = [];
    while($ar_group = $db_groups->Fetch()) {
        $sectionList[] = $ar_group['ID'];
    }
    $sectionList[] = $sectionID;
    $el = new CIBlockElement;
    $arLoadProductArray = Array(
        "IBLOCK_SECTION" => $sectionList,          // элемент лежит в корне раздела
    );
    $res1 = $el->Update($ElementId, $arLoadProductArray);
}
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby kolca.xlsx"); #DONE
//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby kole, broshi, braslety1.xlsx"); #DONE
//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby podveski_kresty,cepi.xlsx"); #DONE
//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby sergi.xlsx"); #DONE
//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby stolovoe serebro.xlsx"); #DONE
//$workbook = $reader->load($_SERVER["DOCUMENT_ROOT"]."/custom_import/import_tabs/Taby stolovoe serebro2.xlsx"); #DONE
die();
$d = $workbook->getSheet(0)->toArray();
$workBook = $workbook->getActiveSheet()->toArray();

foreach ($workBook as $key=>$dt):?>
    <?$sectionStringArray = explode(';',$dt[0])?>
    <?if(count($sectionStringArray) >= 2):?>
        <?
            $lastFoundSection = 0;
            $canContinue = true;
            debug($sectionStringArray);
            foreach ($sectionStringArray as $key=>$section){
                $rsParentSection = CIBlockSection::GetList(
                    Array('sort' => 'asc'),
                    Array('IBLOCK_ID' => 5, 'ACTIVE' => 'Y','NAME' => $section,'SECTION_ID' => $lastFoundSection)
                );
                $found = false;
                while ($arParentSection = $rsParentSection->GetNext())
                {
                    $found = true;
                    if($arParentSection['DEPTH_LEVEL'] != $key+1)
                    {
                        $canContinue = false;
                        break;
                    }
                    $lastFoundSection = $arParentSection['ID'];
                }
                if(!$found){
                    $bs = new CIBlockSection;
                    $arFields = Array(
                        "ACTIVE" => 'Y',
                        "IBLOCK_SECTION_ID" => $lastFoundSection,
                        "IBLOCK_ID" => 5,
                        "NAME" => $section,
                        "SORT" => 500,
                        "CODE" => Cutil::translit($section,"ru",array("replace_space"=>"-","replace_other"=>"-"))
                    );
                    $ID = $bs->Add($arFields);
                    $res = ($ID>0);
                    debug('added section' . $ID);
                    if(!$res) {
                        echo $bs->LAST_ERROR;
                        $canContinue = false;
                        break;
                    }
                    else {
                        $lastFoundSection = $ID;
                    }
                }
            }
            if(!$canContinue){
                debug('not found!');
                debug($sectionStringArray);
                continue;
            } else {
//                debug('NEEDLE SECTION = ' . $lastFoundSection);
                $sectionPropsRows = explode(';',$dt[1]);
                $arFilter = ["IBLOCK_ID" => 5,"ACTIVE"=>"Y"];
                foreach ($sectionPropsRows as $sectionPropsRow){
                    $sectionCurProp = explode(':',$sectionPropsRow);
                    if($sectionCurProp[0] == 102 && $sectionCurProp[1] == 'N'){
                        $arFilter['!=PROPERTY_'.$sectionCurProp[0]] = [
                            'id-agat',
                            'id-akvamarin',
                            'id-aleksandrit',
                            'id-almandin',
                            'id-ametist',
                            'id-ametrin',
                            'id-aurit',
                            'id-belor-kvartsit',
                            'id-biryuza',
                            'id-brilliant',
                            'id-gornyy-khrustal',
                            'id-granat',
                            'id-dekol',
                            'id-demantoid',
                            'id-derevo',
                            'id-derevo-palisandr',
                            'id-zhemchug',
                            'id-zhivopisnoe-izobrazhenie',
                            'id-zmeevik',
                            'id-zmeevik-serpentin',
                            'id-izumrud',
                            'id-kamnereznaya-plastika',
                            'id-kakholong',
                            'id-kvarts',
                            'id-kvartsit',
                            'id-korall',
                            'id-korund',
                            'id-kremen',
                            'id-lazurit',
                            'id-lyuversy',
                            'id-magnit',
                            'id-malakhit',
                            'id-miniatyura',
                            'id-morganit',
                            'id-morion',
                            'id-nefrit',
                            'id-nuarit',
                            'id-obsidian',
                            'id-okameneloe-derevo',
                            'id-oniks',
                            'id-opal',
                            'id-opal-sinteticheskiy',
                            'id-orgsteklo-tosp',
                            'id-ofiokaltsit',
                            'id-perlamutr',
                            'id-pechat-na-kholste',
                            'id-pimsa',
                            'id-plastik',
                            'id-praziolit',
                            'id-prenit',
                            'id-rodolit',
                            'id-rodonit',
                            'id-rubin',
                            'id-sapfir',
                            'id-serdolik',
                            'id-sitall',
                            'id-sombrill',
                            'id-tanzanit',
                            'id-tigrovyy-glaz',
                            'id-topaz',
                            'id-turmalin',
                            'id-fenakit',
                            'id-fianit',
                            'id-florentiyskaya-mozaika',
                            'id-khaltsedon',
                            'id-khrizolit',
                            'id-khrizopraz',
                            'id-tsirkon',
                            'id-tsitrin',
                            'id-shpinel',
                            'id-emal',
                            'id-yuvelirnoe-steklo',
                            'id-yantar',
                            'id-yashma',
                            'id-yashma-pestrotsvetnaya',
                            'id-yashma-tekhnicheskaya'
                        ];
                    } else {
                        $arFilter['PROPERTY_'.$sectionCurProp[0]] = explode(',',$sectionCurProp[1]);
                    }
                }
                AddMessage2Log($arFilter);
                $c = 0;
                $res = CIBlockElement::GetList(Array(), $arFilter, false);
                while($ob = $res->GetNextElement())
                {
                    $arFields = $ob->GetFields();
//                    debug($arFields['NAME'] . ' count: '.$c++);
                    updateElementSections($arFields['ID'],$lastFoundSection);
                }
            }
        ?>
    <?endif;?>
<?endforeach?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>