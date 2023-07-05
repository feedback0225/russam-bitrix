<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О магазине");
?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => '/include/about.php',
            "EDIT_TEMPLATE" => ""
        )
    );?>
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