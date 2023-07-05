<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вопросы и ответы");

global $USER;
//if(!($USER->IsAdmin() || in_array(8,$USER->GetUserGroupArray()))){
//    LocalRedirect('/');
//}
?>

    <section class="faq">
        <div class="container faq__container">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb",
                Array(
                    "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                    "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                    "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                ),
                false
            );?>
            <h1 class="g-title g-title--center faq__title">Вопросы и ответы</h1>
            <div class="faq__content">
                <div class="g-filters faq__filters">
                    <?
                    $faqObCache = new CPageCache;
                    $headerLifeTime = 30*60;
                    $cache_id = 20*21*23*31;

                    if($faqObCache->StartDataCache($headerLifeTime, $cache_id, "/")):
                        CModule::IncludeModule("iblock");?>
                        <ul class="g-filters__list contacts-filters list-reset faq__filters-list">
                            <?
                            $rsParentSection = CIBlockSection::GetList(
                                Array('sort' => 'asc'),
                                Array('IBLOCK_ID' => 14, 'ACTIVE' => 'Y','DEPTH_LEVEL' => 1)
                            );

                            $sC = 0;
                            while ($arParentSection = $rsParentSection->GetNext())
                            {?>
                                <li class="g-filters__item">
                                    <button class="btn-reset g-filters__btn <?=$sC == 0 ? 'g-filters__btn--active': ''?>" data-filters-path="faq-<?=($sC+1)?>"><?=$arParentSection['NAME']?></button>
                                </li>
                                <?$sC++?>
                            <?}?>
                        </ul>
                        <div class="ordering-filters">
                            <?
                            $rsParentSection = CIBlockSection::GetList(
                                Array('sort' => 'asc'),
                                Array('IBLOCK_ID' => 14, 'ACTIVE' => 'Y','DEPTH_LEVEL' => 1)
                            );

                            $sC = 0;
                            while ($arParentSection = $rsParentSection->GetNext())
                            {?>
                                <div class="g-filters__content <?=$sC == 0 ? 'g-filters__content--active': ''?>" data-filters-target="faq-<?=($sC+1)?>">
                                    <?
                                    $rsParentSubSection = CIBlockSection::GetList(
                                        Array('sort' => 'asc'),
                                        Array('IBLOCK_ID' => 14, 'ACTIVE' => 'Y','DEPTH_LEVEL' => 2,'SECTION_ID' => $arParentSection['ID'])
                                    );
                                    while ($arParentSubSection = $rsParentSubSection->GetNext()):
                                        ?>
                                        <h2 class="g-title faq__subtitle"><?=$arParentSubSection['NAME']?></h2>
                                        <div class="faq__items">
                                            <?
                                            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                                            $arFilter = Array("IBLOCK_ID"=>14, "ACTIVE"=>"Y",'SECTION_ID' => $arParentSubSection['ID']);
                                            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                                            while($ob = $res->GetNextElement()){
                                                $arFields = $ob->GetFields();?>
                                                <div class="faq-item g-accordion">
                                                    <button class="btn-reset g-accordion__control faq-item__button" aria-expanded="true" type="button">
                                                        <span><?=$arFields['NAME']?></span>
                                                        <i class="g-accordion__icon">
                                                            <svg class="svg-icon arrow">
                                                                <use xlink:href="/local/templates/.default/img/sprites/sprite.svg#arrow"></use>
                                                            </svg>
                                                        </i>
                                                    </button>
                                                    <div class="g-accordion__content faq-item__content" aria-hidden="false">
                                                        <div class="faq-item__text">
                                                            <p>
                                                                <?=$arFields['PREVIEW_TEXT']?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?}?>
                                        </div>
                                    <?endwhile;?>
                                </div>
                                <?$sC++?>
                            <?}?>
                        </div>
                        <?$faqObCache->EndDataCache();?>
                    <?endif;?>
                </div>
            </div>
        </div>
    </section>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => '/include/questions.php',
            "EDIT_TEMPLATE" => ""
        )
    );?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>