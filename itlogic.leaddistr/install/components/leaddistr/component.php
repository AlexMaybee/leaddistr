<?php
/*Мой код для получения данных по:
* 1) текущему пользователю ID
* 2) получению списка лидов по ID ответственного
* - 3) получение писка лидов по текущему пользователю (пока отмена)
* - 4) отображение в стаблице лидов по ответственному (по текущему пользователю пока нет)
* 5) считаем кол-во лидов для кнопки на панеле
*
* Восстанавливаем страницу настроек
* 6) получаем всех пользователей для выпадающего списка и выводим в шаблоне
* 7) сохраняем ответственного пользователя в БД из шаблона
* 8) получаем данные пользователя по ид для вывода под <select>
*/?>


<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//$arResult['DATE'] = date($arParams["TEMPLATE_FOR_DATE"]);



$lead = new Leaddistr();

//1)
$arResult['userId'] = $lead->getCurrentUserId();

//2)

$arResult['getAllLeads'] = $lead->getAllLeadsByFilter($lead->getLeadAssign());


//3)
//$arResult['getUsersLeads'] = $lead->getAllLeadsByFilter($arResult['userId']);

//4) Ниже в стаблице

//5)
$arResult['numAssignedLeads'] = $lead->countLeads($arResult['getAllLeads']);
//$arResult['numCurUserLeads'] = $lead->countLeads($arResult['getUsersLeads']);

//6)
$arResult['persons'] = $lead->getAllUsers();
/*
echo '<pre>';
print_r($arResult['persons']);
echo '</pre>';
*/

//7) работает, выводит ид
//echo $lead->getLeadAssign();

//8)
$arResult['newAssighData'] = $lead->getNewAssignData($lead->getLeadAssign());



//echo "<pre>"; print_r($arResult['newAssighData']); echo "</pre>";









$this->IncludeComponentTemplate();
?>