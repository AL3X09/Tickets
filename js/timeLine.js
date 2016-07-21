requirement = getParameterFromUrl("id");
var url;
var idLineaTiempo;
$(document).ready(function () {


    $.ajax({url: 'php/getLineTimeExcel.php?',
        type: 'POST',
        data: {"requirement": requirement},
        dataType: 'json',
        success: function (response) {
            $.each(response, function (index) {
                $("#cd-timeline").append('<div class="cd-timeline-block">' +
                        '<div class="cd-timeline-img cd-picture">' +
                        '<img src="img/cd-icon-picture.svg" alt="Picture">' +
                        '</div> ' +
                        '<div class="cd-timeline-content">' +
                        '<h2>' + response[index]["Descripcion"] + '</h2>' +
                        '<p>' + response[index]["UsuarioCreacion"] + '</p>' +
                        //'<a href="#0" data-line="' + response[index]["IDLineaTiempo"] + '" onclick="newUser(this)" class="cd-read-more">Tarea</a>' +
                        '<span class="cd-date">' + response[index]["FechaCreacion"] + '</span>' +
                        '</div>' +
                        '</div>');
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
});


function newUser(button) {

    idLineaTiempo = $(button).data("line");
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nueva Tarea');
    $('#fm').form('clear');
    url = 'php/saveTimeLine.php';
}
function editUser() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit User');
        $('#fm').form('load', row);
        url = 'php/updateHomework.php?id=' + row.IdTarea;
    }
}

function saveUser() {
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.errorMsg) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg').dialog('close');        // close the dialog
                $('#dg').datagrid('reload');    // reload the user data
            }
        }
    });
}
$(function () {
    $('#dd').datebox().datebox('calendar').calendar({
        validator: function (date) {
            var now = new Date();
            var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            var d2 = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 10);
            return d1 <= date && date <= d2;
        }
    });
});
function newTimeLine() {

    $('#dlg-line').dialog('open').dialog('center').dialog('setTitle', 'Nueva anotaciòn');
    $('#fm-line').form('clear');
    url = 'php/saveTimeLine.php?requirement='+requirement;

}
function saveTimeLine() {
    //$('#fm-line').form().append(requirement);
    $('#fm-line').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.errorMsg) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg').dialog('close');        // close the dialog
                $('#cd-timeline').datagrid('reload');    // reload the user data
            }
        }
    });
}