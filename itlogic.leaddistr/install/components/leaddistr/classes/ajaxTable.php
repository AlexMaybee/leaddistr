<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
    $APPLICATION->RestartBuffer();
}?>

<?php
/*Файл предназначен для работы с запросами ajax из таблицы модального окна с лидами*/


/*Получаем данные из при помощи ajax при нажатии кнопки*/
$leadId = $_REQUEST['ID'];
$curUserId = $_REQUEST['ID_US'];

if($leadId && $curUserId)
{
    /*отправляем данные в БД*/
    if (\Bitrix\Main\Loader::includeModule('crm')) {
        $entity = new CCrmLead(true);//true - проверять права на доступ
        $fields = array(
            'ASSIGNED_BY_ID' => $curUserId //название поля в БД => значение
        );
        $entity->update($leadId, $fields); //насколько я понял, число - это id лида
    }

    /*получаем в ответ данные из БД*/
    $arFilter = Array('STATUS_ID' => 'NEW', '!ASSIGNED_BY_ID' => $curUserId);
    $arSelect = Array();
    $db_list = CCrmLead::GetListEx(Array("ID" => "DESC"), $arFilter, false, false, $arSelect, array());

    while($row = $db_list->GetNext()) {

        ?>
        <tr>
            <td><?php echo $row['ID'] ?></td>
            <td><?php echo $row['TITLE'] ?></td>
            <td><?php echo $row['FULL_NAME'] ?></td>
     <?/*       <td><?php echo $row['ASSIGNED_BY_ID'] ?></td>
            <td><?php echo $row['STATUS_ID'] ?></td> */?>
            <td><button type="button" id="<?php echo $row['ID']?>" class="btn-danger button btn-md" onclick="ChangeAssignedGet(this.id)"><span id="leads">Забрать</span></button></td>
        </tr>
<?php
    }
}

if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
    die();
}?>