<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use \Bitrix\Main;
use \Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
//use \Leaddistr_Main;




$APPLICATION->SetTitle("LEADS module");
CJSCore::Init();



/*
if(IsModuleInstalled('itlogic.leaddistr'))
{
    Loader::includeModule('itlogic.leaddistr');

    $APPLICATION->IncludeComponent('itlogic.leaddistr:main','.default');


}*/

CModule::IncludeModule("itlogic.leaddistr");

$APPLICATION->IncludeComponent(
    "leaddistr",
    ".default",
    Array(
    ),
    false
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>