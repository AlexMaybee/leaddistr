<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
use Bitrix\Main\Localization\Loc;
IncludeTemplateLangFile(__FILE__);
//CJSCore::Init(array("jquery"));
$moduleID="itlogic.leaddistr";
$POST_RIGHT = $APPLICATION->GetGroupRight($moduleID);
if ($POST_RIGHT == "D")
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));


//Файл с классами все равно здесь не видит, пришлось вставлять и дорабатывать код из /classes/Leaddistr.php
CModule::IncludeModule("itlogic.leaddistr");


/* Если нажата кнопка выбора сотрудника, сохраняем id нового ответственного в переменную внутри метода битрикса*/
if(isset($_POST['Assigned_User_Select']) ){

    //Сохраняем нового ответственного
    COption::SetOptionString("itlogic.leaddistr", "defaultAssign", $_POST['id_user']);
   // echo COption::GetOptionString("itlogic.leaddistr", "defaultAssign");
}

//получаем id текущего ответственного
$assigned = COption::GetOptionString("itlogic.leaddistr", "defaultAssign");
//echo $assigned; //Пашетъ!


//Получаем ФИО текущего пользователя по id
$rsUser = CUser::GetByID($assigned);
$arUser = $rsUser->Fetch();


//запрос для получения списка пользователей в select
$order = array('ID' => 'asc');
$tmp = 'sort'; // параметр проигнорируется методом, но обязан быть
$result = CUser::GetList($order, $tmp);
$persons = array();
while ($allUsers = $result->GetNext()) {
    $persons[] = array('ID'=>$allUsers['ID'], 'NAME'=>$allUsers['NAME'], 'LAST_NAME'=> $allUsers['LAST_NAME']);
}

?>

<!--Module information block  -->


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
                         * Этот запрос и вывод заменить на переменную $person метода Leaddistr_Db::getAllUsers()
                        *Заменить селект внизу включительно
                         *
                         *страница \fix.itlogic.biz\local\modules\itlogic.leaddistr\install\include\settings_block.php
                         *
                        */
                        foreach ($persons as $person) {

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

                if($arUser)
                {
                    if(!$arUser['NAME'] && !$arUser['LAST_NAME'])
                    {
                        echo "<p><b>". Loc::getMessage('Assigned_Full_Name_Title').": ".$arUser['ID'] ."</b></p>";
                    }
                    else
                    {
                        echo "<p><b>". Loc::getMessage('Assigned_Full_Name_Title').": ".$arUser['NAME'] . " " . $arUser['SECOND_NAME'] . " " . $arUser['LAST_NAME']."</b></p>";
                    }

                }
                ?>
            </div>

    </div>
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