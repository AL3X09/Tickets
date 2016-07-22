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
    <title>modulo tareas desarrollador</title>
    <body>
        <h2>Tareas</h2>
        <table id="dg" title="Tareas" class="easyui-datagrid" style="width:100%;height:450px"
               url="../php/getHomeworkDevelopment.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdTarea" width="50">#</th>
                    <th field="Nombre" width="50">Nombre</th>
                    <th field="IdResponsableTarea" width="50">Responsable Tarea</th>
                    <th field="FechaFinEstimadoTarea" width="50">Fecha fin estimado de tarea</th>
                    <th field="FechaInicioTarea" width="50">Fecha Inicio de tarea</th>                    
                    <th field="FechaFinTarea" width="50">Fecha fin de tarea</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <!-- se inavilitan ya que solo lo puede hacer un rol especifico
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nueva Tarea</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Tarea</a>
            -->
            <a href="javascript:void(0)" class="easyui-linkbutton c1" iconCls="" plain="true" onclick="startHomework()">Iniciar Tarea</a>
            <a href="javascript:void(0)" class="easyui-linkbutton c5" iconCls="" plain="true" onclick="endHomework()">Finalizar Tarea</a>
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
                //proceso de envio valor correcto de fecha a datebox
                var fecha = row.FechaFinEstimadoTarea;          //capturo la fecha
                var res = fecha.split("-");                     //elimino el gion de la fecha
                //alert(res);
                //recorro el arreglo y le asiggono el separador
                for (var i=0; i < res.length; i++) {
                          var year=(res[0]);
                          var month=(res[1] + "/");                        
                          var day=(res[2] + "/");
                                                    
                       }
                var date=month+day+year;                        //capturo y asigno los valores en nuevo array
                date.toString();                                //convierto a string
                //fin envio fecha a datebox
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar tarea');
                    $('#fm').form('load', row);
                    $('#dd').datebox('setValue', date);	         // envio al datebox el valor
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
                            $.post('../php/startHomework.php', {id: row.IdTarea,nombre: row.Nombre,fechaestimado: row.FechaFinEstimadoTarea,idresponsable: row.IdResponsableTarea}, function (result) {
                                result.toString();
                                if (result === "Tarea iniciada") {
                                    $('#dg').datagrid('reload');    // reload the user data
                                    $.messager.show({
                                    title: 'Notificacion',
                                    msg: result,
                                    showType: 'show'
                                    });
                                } else {
                                    $.messager.show({       // show error message
                                        title: 'Error',
                                        msg: result
                                    });
                                }
                            }, 'json');
                        }
                    });
                }
            }
            
            function endHomework() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $.messager.confirm('Confirm', 'Desea terminar esta tarea?', function (r) {
                        if (r) {
                            $('#fm').form('load', row);
                            $.post('../php/endHomework.php', {
                                id: row.IdTarea,
                                nombre: row.Nombre,
                                fechaestimado: row.FechaFinEstimadoTarea,
                                idresponsable: row.IdResponsableTarea,
                                FechaInicioTarea: row.FechaInicioTarea
                                }, function (result) {
                             result.toString();
                               if (result === "Tarea finalizada") {
                                    $('#dg').datagrid('reload');    // reload the user data
                                    $.messager.show({
                                    title: 'Notificacion',
                                    msg: result,
                                    showType: 'show'
                                    });
                                } else {
                                    $.messager.show({       // show error message
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