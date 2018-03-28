<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
    $APPLICATION->RestartBuffer();
}

if (\Bitrix\Main\Loader::includeModule('crm')) {
//Получаем id ответственного
    $assigned = COption::GetOptionString("itlogic.leaddistr", "defaultAssign");

//получаем id текущего пользователя - не выходит почему-то
    global $USER;
    $curUserId = $USER->GetID();

//Запускаем ajax-запрос
    $arFilter = Array('ASSIGNED_BY_ID' => $assigned, 'STATUS_ID' => 'NEW');
    $arSelect = Array();
    $db_list = CCrmLead::GetListEx(Array("ID" => "DESC"), $arFilter, false, false, $arSelect, array());
    
    //В этой переменной будет в виде строки весь код для таблицы
    $leads = '<table class=\'table\'><thead><tr>'.
            '<th>№</th><th>ЛИД</th><th>ПОЛНОЕ ИМЯ</th><th></th></tr></thead><tbody class=\'foregnLeads\'>';

    if($db_list->SelectedRowsCount() == 0)
    {
        $leads.='<tr><td colspan=\'4\' style=\' text-align: center\'>Свободных лидов больше нет</td></tr>';
    }
    else
    {
       // $leads = array();
        //Загоняем в переменную кол-во лидов в тегах
        while($allLeads = $db_list->GetNext()) {


            $leads.= '<tr id =\'user_'. $allLeads['ID'] . '\'>'
                .'<td>'  .  $allLeads['ID'] . '</td>'
                .'<td>'  .  $allLeads['TITLE'] . '</td>'
                .'<td>'  .  $allLeads['FULL_NAME']. '</td>'
                .'<td><button type=\'button\' ' . 'id=' . $allLeads['ID'] . ' class=\'btn-danger button btn-md\'' . ' onclick=\'ChangeAssignedGet(this.id)\'>' . '<span id=\'leads\'>Забрать</span></button></td>'
                .'</tr>';


        }
        $leads .= '</tbody></table>'.'<span id=\'hiddId\'>'.$curUserId.'</span>';
    }
//считаем кол-во лидов ответственного сотрудника
    $count = $db_list->SelectedRowsCount();
    
   /* echo '<pre>';
    print_r($leads);
    echo '</pre>';*/
/*
    echo COption::GetOptionString("itlogic.leaddistr", "defaultAssign");*/
  // $data = array("number" => $count, "leads" => $leads);

    echo json_encode(array(
        "number" => $count, "leads" => $leads
    ));
//Отправляем в виде json ответ аяксу

}


if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
die();
}
