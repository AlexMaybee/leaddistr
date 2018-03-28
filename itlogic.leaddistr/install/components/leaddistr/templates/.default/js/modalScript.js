
$(document).ready(function() {

    checkAutorizationOfUser();

});


/*1. Функции для кнопки открытия модалки*/
function had() {
    document.getElementById('leadsButton').innerHTML = "<br> To GET!"; //<?php echo $CountLeadRows ?>
    getNumLeads();
    }
function had1() {
    document.getElementById('leadsButton').innerHTML = "<br> LEADS"; //<?php echo $CountLeadRows ?>
}


/*2. Меняем цвет и надпись в кнопке "забрать лид" после нажатия*/
function  ChangeAssignedGet(id) {

    //здесь аякс-запрос для смены поля(отданный лид должен перейти в таблицу ниже с кнопкой "вернуть лид")
    var leadId = id; //ид текущего лида
    var curUserId = document.getElementById('hiddId').innerHTML; //ид текущего пользователя

    var y = $('#user_'+id);

    $(".curLeads").append(y);

    var server1 = '/bitrix/components/leaddistr/classes/ajaxTable.php';
   
    $.ajax({
        url: server1+'?ID='+leadId+'&ID_US='+curUserId,
        dataType: "html",
        success: function (result) {
            var html = $.parseHTML(result);
            $(".foregnLeads").empty().append(result);
            
            getNumLeads();
        },
        complete: function () {BX.closeWait();},
        error: function () {BX.closeWait();}
    });

   /*смена цвета и текста*/
    document.getElementById(id).removeAttribute("class");
    document.getElementById(id).setAttribute("class", "button btn-success btn-md");
    document.getElementById(id).innerHTML = "Готово!";
}

//3. Запрос для кнопки открытия модалки - считаем кол-во лидов.

//Обновляется через при наведении на кнопку и при нажатии кнопки "забрать"
function getNumLeads() {

    var server = '/bitrix/components/leaddistr/classes/ajaxButton.php';

    $.ajax({
        url: server,
        type: "POST",

        data: {},//{"number":"", "leads":""},
        dataType: "json",
        success: function(data){
            //alert("Сообщение успешно отправлено!") // выводим ответ сервера
            $('#countLeads').empty().append(data.number);
            $('#modalLead').empty().append(JSON.stringify(data.leads)); // выводим ответ сервера
        }
    });
}


//4.Аякс-запрос для проверки авторизации пользователя.
function checkAutorizationOfUser() {
    var server = '/bitrix/components/leaddistr/classes/authcheck.php';
    $.ajax({
        url: server,
        type: "POST",

        data: {},
        dataType: "json",
        success: function(data){
            
            if(data.result == 'OK') {

                //1.Добавляем кнопку с уже готовым классом на страницу
                $('<button type="button" data-toggle="modal" data-target="#myLeadsModal" class="button btn-danger btn-xs modalLeads" onmouseover="had()" onmouseout="had1()"><span id="countLeads"></span><span id="leadsButton"> <br> LEADS</span></button>').appendTo("body");

                //2.Добавление костяка модального окна в body
                $('<div class="modal fade" id="myLeadsModal" role="dialog">' +
                    '<div class="modal-dialog modal-lg">' +
                    '<div class="modal-content leadsBg">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                    '<h4 class="modal-title">ITLOGIC LEADS MODULE</h4>' +
                    '</div>' +
                    '<div class="modal-body" id="modalLead">'+
                    '</div></div></div></div>').appendTo("body");

                //3.При загрузке страницы делается запрос для обновления счетчика и лидов
                getNumLeads();

              //  console.log('Авторизация проверяется и все ОК');
            }
            else {
                console.log('Проблемы с авторизацией!');
            }
        }
    });
}
