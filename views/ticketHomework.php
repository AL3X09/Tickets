<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <script type="text/javascript" src="../libs/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="../libs/easyui/jquery.easyui.min.js"></script>
        <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script id="script-lang" src="../libs/easyui/locale/easyui-lang-es.js"></script> 
    </head>
    <body>
        <h2>Tareas</h2>    

        <table id="dg" title="Tareas" class="easyui-datagrid" style="width:100%;height:250px"
               url="../php/getHomework.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdTarea" width="50">#</th>
                    <th field="Nombre" width="50">Nombre</th>
                    <th field="IdResponsableTarea" width="50">Responsable Tarea</th>
                    <th field="FechaInicioTarea" width="50">Fecha Inicio de tarea</th>
                    <th field="FechaFinEstimadoTarea" width="50">Fecha fin estimado de tarea</th>
                    <th field="FechaFinTarea" width="50">Fecha fin de tarea</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nueva Tarea</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Tarea</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="" plain="true" onclick="startHomework()">IniciarTarea</a>
        </div>

        <div id="dlg" class="easyui-dialog" style="width:600px;height:300px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Tarea</div>
            <form id="fm" method="post" novalidate>                
                <div class="col-md-4 col-lg-4">
                    <label class="label-top" for="Nombre">Nombre</label>
                    <input name="Nombre" class="easyui-textbox" style="width:100%;height:32px" required="true">
                </div>
                <div class="col-md-4 col-lg-4">
                    <label class="label-top" for="IdResponsableTarea">Responsable</label>
                    <select class="easyui-combobox" name="IdResponsableTarea" style="width:100%;height:32px" data-options="
                            url: '../php/getUser.php',
                            method: 'get',
                            valueField:'IdUsuario',
                            textField:'Nombre'">
                    </select>
                </div>
                <div class="col-md-4 col-lg-4">
                    <label class="label-top" for="FechaFinEstimadoTarea">Fecha estimado fin</label>
                    <input id="dd" name="FechaFinEstimadoTarea" type="text" style="width:100%;height:32px"class="easyui-datebox" required="required">
                </div>                
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <script type="text/javascript">
            var url;
            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nueva Tarea');
                $('#fm').form('clear');
                url = '../php/saveHomework.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar tarea');
                    $('#fm').form('load', row);
                    url = '../php/updateHomework.php?id=' + row.IdTarea;
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
                            $.messager.show({
                                title: 'Notificacion',
                                msg: result,
                                showType: 'show'
                            });
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload the user data
                        }
                    }
                });
            }
            function startHomework() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $.messager.confirm('Confirm', 'Desea iniciar esta tarea?', function (r) {
                        if (r) {
                            $('#fm').form('load', row);
                            $.post('../php/startHomework.php', {id: row.id}, function (result) {
                                if (result.success) {
                                    $('#dg').datagrid('reload');    // reload the user data
                                } else {
                                    $.messager.show({// show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                        }
                    });
                }
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
        </script>
        <style type="text/css">
            #fm{
                margin:0;
                padding:10px 30px;
            }
            .ftitle{
                font-size:14px;
                font-weight:bold;
                padding:5px 0;
                margin-bottom:10px;
                border-bottom:1px solid #ccc;
            }
            .fitem{
                margin-bottom:5px;
            }
            .fitem label{
                display:inline-block;
                width:80px;
            }
            .fitem input{
                width:160px;
            }
        </style>
    </body>
</html>