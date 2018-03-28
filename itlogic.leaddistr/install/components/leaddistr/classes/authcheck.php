<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
    $APPLICATION->RestartBuffer();
}

//Проверка авторизации пользователя
global $USER;
if ($USER->IsAuthorized()) {
    $userCheckAuthorization = 'OK';
}
else {
    $userCheckAuthorization = 'Bad News!';
}


echo json_encode(array(
    "result" => $userCheckAuthorization
));








if(isset($_REQUEST["ajax_call"]) AND $_REQUEST["ajax_call"]=="Y"){
    die();
}