<?
/*Мой код для получения данных по:
 * 1) текущему пользователю ID
 * 2) получению списка лидов по ID ответственного
 * 3) получение писка лидов по текущему пользователю
 * 4) отображение в стаблице лидов по отсетственному и текущему пользователям
 * 5) считаем кол-во лидов для кнопки на панеле
 *
 * Восстанавливаем страницу настроек
 * 6) получаем всех пользователей для выпадающего списка


ДЛЯ РАБОТОСПОСОБНОСТИ НУЖНО БУДЕТ ПОДКЛЮЧИТЬ СИСТЕМНЫЕ ФАЙЛЫ!!!

require_once "classes/general/Leaddistr_Main.php"; //после отладки удалить
//1)
$curUser = Leaddistr_Main::getCurrentUserId();

//2) Получаем сохраненное значение ID ответственого за все
// и передаем в функцию для получения лидов
$assignedId = Leaddistr_Main::getLeadAssign();
$assignedLeads = Leaddistr_Main::getAllLeadsByFilter($assignedId);

//3) Получаем Id текущего пользователя
// и получаем его лиды со статусом "новый"
$curLeads =  Leaddistr_Main::getAllLeadsByFilter($curUser);

//4) ниже

//5)
$numAssignedLeads = Leaddistr_Main::countLeads($assignedLeads);
*/
?>

<?php //Для вывода лэнговых констант
use Bitrix\Main\Localization\Loc;
IncludeTemplateLangFile(__FILE__);
?>


<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetAdditionalCSS("/bitrix/components/leaddistr/templates/.default/css/bootstrap.min.css");
$APPLICATION->SetAdditionalCSS("/bitrix/components/leaddistr/templates/.default/css/leadsStyle.css");

//$APPLICATION->AddHeadScript("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");
//$APPLICATION->AddHeadScript("/bitrix/components/leaddistr/templates/.default/js/bootstrap.min.js");
//$APPLICATION->AddHeadScript("/bitrix/components/leaddistr/templates/.default/js/modalScript.js");


/*это страница с настройками для руководителя отдела*/
?>

<div class="techLeads col-md-12 ">


    <div class="forBtn"></div>


    <div class="moduleLogo col-md-4">
        <div class="col-md-12">
            <img  class ="title" class="animated bounceInDown" src="/bitrix/modules/itlogic.leaddistr/install/images/itlogic1.jpg">
        </div>

        <div class="col-md-12 pt">
            <?php

            echo "By <a href='".Loc::getMessage("LEADDISTR_PARTNER_URI")."'>".Loc::getMessage("LEADDISTR_PARTNER_NAME")."</a>";

            /*Скрываем настройки от всех, кроме админа*/
            global $USER;
            if ($USER->IsAdmin()) {
                ?>

                <!-- <h1> <?php echo(Loc::getMessage("LEADDISTR_MODULE_INSTALL_SETTING")); ?> </h1> -->
                <h4><?php echo(Loc::getMessage("LEADDISTR_MODULE_INSTALL_SETTING_Sub")); ?>  </h4>


                <form method="post" class="mtb">
                    <select required name="id_user">
                        <option value=""><?php echo Loc::getMessage("LEADDISTR_MODULE_INSTALL_SETTING_USER_LIST"); ?></option>

                        <?php
                        /*
                         *страница \fix.itlogic.biz\local\modules\itlogic.leaddistr\install\include\settings_block.php
                        */
                        foreach ($arResult['persons'] as $person) {

                            if (!$person['NAME'] && !$person['LAST_NAME']) {
                                echo '<option value="' . $person['ID'] . '" >' . $person['ID'] . '</option>';
                            } else {
                                echo '<option value="' . $person['ID'] . '" >' . $person['NAME'] . '  ' . $person['LAST_NAME'] . '</option>';
                            }

                        }
                        ?>

                    </select>

                    <input name="Assigned_User_Select" onclick="change();"
                           value="<?php echo Loc::getMessage("LEADDISTR_MODULE_INSTALL_SETTING_USER_LIST_BUTTON"); ?>"
                           type="submit">
                </form>

                <p>	<?php  echo(Loc::getMessage("LEADDISTR_MODULE_ADMIN_DESCRIPTION")); ?></p>
                <!-- Rendering lead list with status NEW -->

                <?php
            }
            ?>

            <?php
            if($arResult['newAssighData'])
            {
                if(!$arResult['newAssighData']['NAME'] && !$arResult['newAssighData']['LAST_NAME'])
                {
                    echo "<h4>".Loc::getMessage('Assigned_Full_Name_Title')." №: ".$arResult['newAssighData']['ID'] ."</h4>";
                }
                else
                {
                    echo "<h4>".Loc::getMessage('Assigned_Full_Name_Title') . ": ".$arResult['newAssighData']['NAME'] . " " . $arResult['newAssighData']['SECOND_NAME'] . " " . $arResult['newAssighData']['LAST_NAME']."</h4>";
                }
            }
            ?>

            <?php
            /* Если нажата кнопка выбора сотрудника, сохраняем id нового ответственного в переменную внутри метода битрикса*/
            if(isset($_POST['Assigned_User_Select']) ){

                $obj = new Leaddistr();

                $obj -> updateLeadAssign($_POST['id_user']);
                // echo $obj->getLeadAssign(); работает
                header("Location: /leaddistr/leaddistr.php");
            }
            ?>

        </div>

    </div>
    <!--Module information block  -->
    <div class="col-md-8">

        <h3 class="text-center"><?php echo(Loc::getMessage("LEADDISTR_MODULE_DESC_TITLE")); ?></h3>
        <p  class = "animated slideInUp" >	<?php  echo(Loc::getMessage("LEADDISTR_MODULE_DESCRIPTION")); ?></p>


        <h3 class="text-center"><?php echo(Loc::getMessage("LEADDISTR_MODULE_INSTRUCTION_TITLE")); ?></h3>


        <p>	<?php  echo(Loc::getMessage("LEADDISTR_MODULE_INSTRUCTION")); ?></p>

        <div class="text-center mtb">
            <img class="animated bounceInDown" src="/bitrix/modules/itlogic.leaddistr/install/images/lead.jpg">
        </div>

        <p><?php  echo(Loc::getMessage("LEADDISTR_MODULE_INSTRUCTION_USER")); ?></p>



    </div>

</div>
