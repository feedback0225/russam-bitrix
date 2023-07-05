<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
set_time_limit(2400);
ini_set('session.gc_maxlifetime', 2400);
?>
<div class="container">
<?php
AddMessage2Log('start update products name');
CModule::IncludeModule("iblock");
$arrFilter = Array('IBLOCK_ID'=>5,'ACTIVE' => 'Y');
$res = CIBlockElement::GetList(Array(), $arrFilter, false);
$c = 0;
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();
    $resultProductName = '';
    $vstStr = [];
//    if($arProps['VSTAVKA_FILTER']['VALUE']){
//        $vstStr .= ' c ';
//    }

    if($arProps['UPDATE_NAME']['VALUE_ENUM_ID'] == 26) continue;

    $vstavki = [];
    foreach($arProps['VSTAVKA_FILTER']['VALUE'] as $v11){
        if(!in_array(getHLBTByXML($v11,18),$vstavki)){
            $vstavki[] = getHLBTByXML($v11,18);
        }
    }
    $vsCount = count($vstavki);
    foreach($vstavki as $k=>$v11){
        $vstStr[] = mb_strtolower($v11);
    }
    $el = new CIBlockElement;
    $resultProductName .= getHLBTByXML($arProps['ITEM_TYPE']['VALUE'],4);
    if($arProps['SAMPLE_MATERIAL']['VALUE']){
        $resultProductName .= ' из ';
        $tempMaterial = '';
        $tempMaterial .= preg_replace('/\d/','',mb_strtolower($arProps['SAMPLE_MATERIAL']['VALUE']));
        $tempMaterial = preg_replace('/  +/', ' ', $tempMaterial);
        $tempMaterial = str_replace('пробы','',$tempMaterial);
        //debug($tempMaterial);
        $eachWord = explode(' ',$tempMaterial);
        //debug($eachWord);
        foreach ($eachWord as &$word){
            if($word == 'белое'){
                $word = 'белого';
            } elseif($word == 'желтое') {
                $word = 'желтого';
            } elseif($word == 'красное'){
                $word = 'красного';
            } elseif($word == 'нержавеющая'){
                $word = 'нержавеющей';
            } elseif($word == 'серебро'){
                $word = 'серебра';
            } elseif($word == 'золото'){
                $word = 'золота';
            } elseif($word == 'серебро'){
                $word = 'серебра';
            } elseif($word == 'сталь'){
                $word = 'стали';
            } elseif($word == 'латунь'){
                $word = 'латуни';
            } elseif($word == 'платина'){
                $word = 'платины';
            }  elseif($word == 'медь'){
                $word = 'меди';
            } elseif($word == '/латунь'){
                $word = 'и латуни';
            }  elseif($word == '/медь'){
                $word = 'и меди';
            }
        }
        $tempMaterial = implode(' ',$eachWord);
        $resultProductName .= $tempMaterial;
    }

    $tempNNameArray = [];
    foreach ($arProps['VSTAVKA']['VALUE'] as $nCount){
        $curNName = explode(' - ',explode(' ,',$nCount)[0]);
        AddMessage2Log($curNName);
        if(!empty($curNName)){
            $tempNNameArray[mb_strtolower($curNName[0])] = $curNName[1];
        }
    }

    $vstavkaStr = '';
    foreach ($vstStr as $vK=>&$vstavka){
        if($vK == 0){
            $vstavkaStr .= ' с ';
        } else {
            $vstavkaStr .= ' и ';
        }
        if($vstavka == 'агат'){
            $vstavka = $tempNNameArray['агат'] > 1 ? 'агатами' : 'агатом';
        } elseif($vstavka == 'аквамарин'){
            $vstavka = $tempNNameArray['аквамарин'] > 1 ? 'аквамаринами' : 'аквамарином';
        } elseif($vstavka == 'александрит'){
            $vstavka = $tempNNameArray['александрит'] > 1 ? 'александритами' : 'александритом';
        } elseif($vstavka == 'альмандин'){
            $vstavka = $tempNNameArray['альмандин'] > 1 ? 'альмандинами' : 'альмандином';
        } elseif($vstavka == 'аметист'){
            $vstavka = $tempNNameArray['аметист'] > 1 ? 'аметистами' : 'аметистом';
        } elseif($vstavka == 'аметрин'){
            $vstavka = $tempNNameArray['аметрин'] > 1 ? 'аметринами' : 'аметрином';
        } elseif($vstavka == 'аурит'){
            $vstavka = $tempNNameArray['аурит'] > 1 ? 'ауритами' : 'ауритом';
        } elseif($vstavka == 'белор. кварцит'){
            $vstavka = 'белор. кварцитом';
        } elseif($vstavka == 'бирюза'){
            $vstavka = $tempNNameArray['бирюза'] > 1 ? 'бирюзой' : 'бирюзой';
        } elseif($vstavka == 'бриллиант'){
            $vstavka = $tempNNameArray['бриллиант'] > 1 ? 'бриллиантами' : 'бриллиантом';
        } elseif($vstavka == 'горный хрусталь'){
            $vstavka = $tempNNameArray['горный хрусталь'] > 1 ? 'горным хрусталем' : 'горным хрусталем';
        } elseif($vstavka == 'гранат'){
            $vstavka = $tempNNameArray['гранат'] > 1 ? 'гранатами' : 'гранатом';
        } elseif($vstavka == 'деколь'){
            $vstavka = $tempNNameArray['деколь'] > 1 ? 'деколью' : 'деколью';
        } elseif($vstavka == 'демантоид'){
            $vstavka = $tempNNameArray['демантоид'] > 1 ? 'демантоидами' : 'демантоидом';
        } elseif($vstavka == 'дерево'){
            $vstavka = $tempNNameArray['дерево'] > 1 ? 'деревом' : 'деревом';
        } elseif($vstavka == 'дерево/палисандр/'){
            $vstavka = 'деревом/палисандром';
        } elseif($vstavka == 'жемчуг'){
            $vstavka = $tempNNameArray['жемчуг'] > 1 ? 'жемчугом' : 'жемчугом';
        } elseif($vstavka == 'живописное изображение'){
            $vstavka = 'живописным изображением';
        } elseif($vstavka == 'змеевик'){
            $vstavka = $tempNNameArray['змеевик'] > 1 ? 'змеевиками' : 'змеевиком';
        } elseif($vstavka == 'змеевик (серпентин)'){
            $vstavka = $tempNNameArray['змеевик (серпентин)'] > 1 ? 'змеевиками (серпентин)' : 'змеевиком (серпентин)';
        } elseif($vstavka == 'изумруд'){
            $vstavka = $tempNNameArray['изумруд'] > 1 ? 'изумрудами' : 'изумрудом';
        } elseif($vstavka == 'камнерезная пластика'){
            $vstavka = 'камнерезной пластикой';
        } elseif($vstavka == 'кахолонг'){
            $vstavka = $tempNNameArray['кахолонг'] > 1 ? 'кахолонгами' : 'кахолонгом';
        } elseif($vstavka == 'кварц'){
            $vstavka = $tempNNameArray['кварц'] > 1 ? 'кварцами' : 'кварцем';
        } elseif($vstavka == 'кварцит'){
            $vstavka = $tempNNameArray['кварцит'] > 1 ? 'кварцитами' : 'кварцитом';
        } elseif($vstavka == 'коралл'){
            $vstavka = $tempNNameArray['коралл'] > 1 ? 'кораллами' : 'кораллом';
        } elseif($vstavka == 'корунд'){
            $vstavka = $tempNNameArray['корунд'] > 1 ? 'корундами' : 'корундом';
        } elseif($vstavka == 'кремень'){
            $vstavka = 'кремнем';
        } elseif($vstavka == 'лазурит'){
            $vstavka = $tempNNameArray['лазурит'] > 1 ? 'лазуритами' : 'лазуритом';
        } elseif($vstavka == 'люверсы'){
            $vstavka = $tempNNameArray['люверсы'] > 1 ? 'люверсами' : 'люверсом';
        } elseif($vstavka == 'малахит'){
            $vstavka = $tempNNameArray['малахит'] > 1 ? 'малахитами' : 'малахитом';
        } elseif($vstavka == 'миниатюра'){
            $vstavka = $tempNNameArray['миниатюра'] > 1 ? 'миниатюрами' : 'миниатюрой';
        } elseif($vstavka == 'морганит'){
            $vstavka = $tempNNameArray['морганит'] > 1 ? 'морганитами' : 'морганитом';
        } elseif($vstavka == 'морион'){
            $vstavka = $tempNNameArray['морион'] > 1 ? 'морионами' : 'морионом';
        } elseif($vstavka == 'нефрит'){
            $vstavka = $tempNNameArray['нефрит'] > 1 ? 'нефритами' : 'нефритом';
        } elseif($vstavka == 'нуарит'){
            $vstavka = $tempNNameArray['нуарит'] > 1 ? 'нуаритами' : 'нуаритом';
        } elseif($vstavka == 'обсидиан'){
            $vstavka = $tempNNameArray['обсидиан'] > 1 ? 'обсидианами' : 'обсидианом';
        } elseif($vstavka == 'окаменелое дерево'){
            $vstavka = 'окаменелом деревом';
        } elseif($vstavka == 'оникс'){
            $vstavka = $tempNNameArray['оникс'] > 1 ? 'ониксами' : 'ониксом';
        } elseif($vstavka == 'опал'){
            $vstavka = $tempNNameArray['опал'] > 1 ? 'опалами' : 'опалом';
        } elseif($vstavka == 'опал синтетический'){
            $vstavka = $tempNNameArray['опал синтетический'] > 1 ? 'опалами синтетическими' : 'опалом синтетическим';
        } elseif($vstavka == 'офиокальцит'){
            $vstavka = $tempNNameArray['офиокальцит'] > 1 ? 'офиокальцитами' : 'офиокальцитом';
        } elseif($vstavka == 'перламутр'){
            $vstavka = 'перламутром';
        } elseif($vstavka == 'печать на холсте'){
            $vstavka = 'печатью на холсте';
        } elseif($vstavka == 'пластик'){
            $vstavka = 'пластиком';
        } elseif($vstavka == 'празиолит'){
            $vstavka = $tempNNameArray['празиолит'] > 1 ? 'празиолитами' : 'празиолитом';
        } elseif($vstavka == 'пренит'){
            $vstavka = $tempNNameArray['пренит'] > 1 ? 'пренитами' : 'пренитом';
        } elseif($vstavka == 'родолит'){
            $vstavka = $tempNNameArray['родолит'] > 1 ? 'родолитами' : 'родолит';
        } elseif($vstavka == 'родонит'){
            $vstavka = $tempNNameArray['родонит'] > 1 ? 'родонитами' : 'родонит';
        } elseif($vstavka == 'рубин'){
            $vstavka = $tempNNameArray['рубин'] > 1 ? 'рубинами' : 'рубином';
        } elseif($vstavka == 'сапфир'){
            $vstavka = $tempNNameArray['сапфир'] > 1 ? 'сапфирами' : 'сапфиром';
        } elseif($vstavka == 'сердолик'){
            $vstavka = $tempNNameArray['сердолик'] > 1 ? 'сердоликами' : 'сердоликом';
        } elseif($vstavka == 'ситалл'){
            $vstavka = $tempNNameArray['ситалл'] > 1 ? 'ситаллами' : 'ситаллом';
        } elseif($vstavka == 'сомбрилл'){
            $vstavka = $tempNNameArray['сомбрилл'] > 1 ? 'сомбриллами' : 'сомбриллом';
        } elseif($vstavka == 'танзанит'){
            $vstavka = $tempNNameArray['танзанит'] > 1 ? 'танзанитами' : 'танзанитом';
        } elseif($vstavka == 'тигровый глаз'){
            $vstavka = 'тигровым глазом';
        } elseif($vstavka == 'топаз'){
            $vstavka = $tempNNameArray['топаз'] > 1 ? 'топазами' : 'топазом';
        } elseif($vstavka == 'турмалин'){
            $vstavka = $tempNNameArray['турмалин'] > 1 ? 'турмалинами' : 'турмалином';
        } elseif($vstavka == 'фианит'){
            $vstavka = $tempNNameArray['фианит'] > 1 ? 'фианитами' : 'фианитом';
        } elseif($vstavka == 'флорентийская мозаика'){
            $vstavka = 'флорентийской мозаикой';
        } elseif($vstavka == 'халцедон'){
            $vstavka = $tempNNameArray['халцедон'] > 1 ? 'халцедонами' : 'халцедоном';
        } elseif($vstavka == 'хризолит'){
            $vstavka = $tempNNameArray['хризолит'] > 1 ? 'хризолитами' : 'хризолитом';
        } elseif($vstavka == 'хризопраз'){
            $vstavka = $tempNNameArray['хризопраз'] > 1 ? 'хризопразами' : 'хризопразом';
        } elseif($vstavka == 'циркон'){
            $vstavka = $tempNNameArray['циркон'] > 1 ? 'цирконами' : 'цирконом';
        } elseif($vstavka == 'цитрин'){
            $vstavka = $tempNNameArray['цитрин'] > 1 ? 'цитринами' : 'цитрином';
        } elseif($vstavka == 'шпинель'){
            $vstavka = $tempNNameArray['шпинель'] > 1 ? 'шпинелями' : 'шпинелью';
        } elseif($vstavka == 'эмаль'){
            $vstavka = 'эмалью';
        } elseif($vstavka == 'ювелирное стекло'){
            $vstavka = 'ювелирным стеклом';
        } elseif($vstavka == 'янтарь'){
            $vstavka = 'янтарем';
        } elseif($vstavka == 'яшма'){
            $vstavka = $tempNNameArray['яшма'] > 1 ? 'яшмами' : 'яшмой';
        } elseif($vstavka == 'яшма пестроцветная'){
            $vstavka = $tempNNameArray['яшма пестроцветная'] > 1 ? 'яшмами пестроцветными' : 'яшмой пестроцветной';
        } elseif($vstavka == 'яшма техническая'){
            $vstavka = $tempNNameArray['яшма техническая'] > 1 ? 'яшмами техническами' : 'яшмой технической';
        }
        $vstavkaStr .= $vstavka;
    }
    if($vstavkaStr){
        $resultProductName .= $vstavkaStr;
    }
    $resultProductName = preg_replace('/  +/', ' ', $resultProductName);
    $arLoadProductArray = Array("NAME" => $resultProductName);
    $res2 = $el->Update($arFields['ID'], $arLoadProductArray);
    debug('new NAME: ' . $resultProductName);
}
AddMessage2Log('end update products name');
?>
</div>
