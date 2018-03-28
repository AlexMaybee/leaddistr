<?php

/*Мои методы!*/

/*Метод для получения списка пользователей и передачи его в выпадающий список при выборе ответственного
*Предназначен для страниц:
 * натройки при установке,
 * страницы настроек ответственного сотрудника.
 * */

class Leaddistr {

    public function getAllUsers()
    {
        $order = array('ID' => 'asc');
        $tmp = 'sort'; // параметр проигнорируется методом, но обязан быть

        $result = CUser::GetList($order, $tmp);

        $person = array();
        while ($allUsers = $result->GetNext()) {
            $person[] = array('ID'=>$allUsers['ID'], 'NAME'=>$allUsers['NAME'], 'LAST_NAME'=> $allUsers['LAST_NAME']);

        }
        return $person;
        //передавать эту переменную
    }

    /*
     * Метод получает id текущего пользователя
     *
     * будет применяться для нескольких страниц
     * */
    public function getCurrentUserId()
    {
        return CUser::GetID();
    }

    /*
     * Метод для запоминания ID ответственного по умолчанию
     * после нажатия кнопки в форме
     *
     * применяется вместо Лешиной БД и запросов в нее
     *
     * будет применяться на 2-х страницах - настройка при установке и настройка в панели слева*/
    public function updateLeadAssign($a)
    {
        COption::SetOptionString("itlogic.leaddistr", "defaultAssign", $a);
        //return true;
    }

    /*Метод для получения ID ответственного и возвращает его по запросу*/
    public function getLeadAssign()
    {
        return COption::GetOptionString("itlogic.leaddistr", "defaultAssign");
    }

    /*метод для получения данных конкретного пользователя (для вывода имен на странице настроек под полем)*/
    public function getNewAssignData($a)
    {
        $rsUser = CUser::GetByID($a);
        $arUser = $rsUser->Fetch();
        return $arUser;
       // echo "<pre>"; print_r($arUser); echo "</pre>";
    }

    /*метод для получения лидов*
    *используется на странице с таблицами
     */
    public function getAllLeadsByFilter($a)
    {
        $arFilter = Array('ASSIGNED_BY_ID' => $a, 'STATUS_ID' => 'NEW');
        $arSelect = Array();
        $db_list = CCrmLead::GetListEx(Array("ID" => "DESC"), $arFilter, false, false, $arSelect, array());
        return $db_list;
    }


    /*Считаем кол-во лидов в переданной переменной*/
    public function countLeads($a)
    {
        return $a->SelectedRowsCount();
    }

//Функция подключения js-скриптов - пока не работает

    function injectButton()
    {
        global $APPLICATION;
        $APPLICATION->SetAdditionalCSS("/bitrix/modules/itlogic.leaddistr/install/components/leaddistr/templates/.default/css/bootstrap.min.css");
        $APPLICATION->SetAdditionalCSS("/bitrix/modules/itlogic.leaddistr/install/components/leaddistr/templates/.default/css/leadsStyle.css");
       // $APPLICATION->AddHeadScript("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");
        CJSCore::Init(array("jquery2")); //Штатная библиотека
        $APPLICATION->AddHeadScript("/bitrix/modules/itlogic.leaddistr/install/components/leaddistr/templates/.default/js/bootstrap.min.js");
        $APPLICATION->AddHeadScript("/bitrix/modules/itlogic.leaddistr/install/components/leaddistr/templates/.default/js/modalScript.js");
    }

}



?>