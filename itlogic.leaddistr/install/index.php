<?
IncludeModuleLangFile(__FILE__);
Class itlogic_leaddistr extends CModule
{
	const MODULE_ID = 'itlogic.leaddistr';
	var $MODULE_ID = 'itlogic.leaddistr';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("LEADDISTR_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("LEADDISTR_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = GetMessage("LEADDISTR_PARTNER_NAME");
        $this->PARTNER_URI = GetMessage("LEADDISTR_PARTNER_URI");
	}

	function UnInstallEvents()
	{
            return true;
	}

	function InstallFiles($arParams = array())
	{
		        /* что и куда копировать:
		        * - создаем папку в локале и каидаем туда компонент
		         * - нужно закинуть код вызова компонента на основную страницу, чтобы кнопка и окно были доступны всегда*/


                $dir = $_SERVER["DOCUMENT_ROOT"]."/local/components";
               // $dir1 = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_delivery";
                if ( !file_exists ( $dir ) ) {
                    mkdir ( $dir );
                }


                CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/components",  $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/", true, true);

                //страница отображения и меню будет в корневой папке/leaddistr
				//поэтому ее не инсталим никуда

                CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/leaddistr",  $_SERVER["DOCUMENT_ROOT"]."/leaddistr/", true, true);

                return true;
	}

	function UnInstallFiles()
	{
                DeleteDirFilesEx('/bitrix/components/leaddistr');
                DeleteDirFilesEx('/leaddistr');
             //   DeleteDirFilesEx('/leaddistr/.top.menu.php');

		        return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		RegisterModule(self::MODULE_ID);


        //или старый способ - запускаем функцию-для вставки кнокпи и модалки куда-то вверх
       // RegisterModuleDependences("main", "OnUserLogin", $this->MODULE_ID, "Leaddistr", "injectButton");
        RegisterModuleDependences("main", "OnBeforeProlog", $this->MODULE_ID, "Leaddistr", "injectButton");

        //перенаправляем на страницу настроек автоматически
        LocalRedirect("/leaddistr/leaddistr.php");
	}

	function DoUninstall()
	{
		global $APPLICATION;
		$this->UnInstallFiles();


        // или стрый способ, удаляем обработчик
       // UnRegisterModuleDependences ("main", "OnUserLogin", $this->MODULE_ID, "Leaddistr", "injectButton");
        UnRegisterModuleDependences ("main", "OnBeforeProlog", $this->MODULE_ID, "Leaddistr", "injectButton");

		UnRegisterModule(self::MODULE_ID);

	}



}
?>
