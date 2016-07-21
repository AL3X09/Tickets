<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="themes/icon.css">
        <link rel="stylesheet" type="text/css" href="themes/color.css">
        <link rel="stylesheet" type="text/css" href="demo/demo.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
        <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script id="script-lang" src="locale/easyui-lang-es.js"></script> 
    </head>
    <body>
        <h2>Administraci&oacute;n de Empresas</h2>       

        <table id="dg" title="Empresas" class="easyui-datagrid" style="width:700px;height:250px"
               url="php/getCompany.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="false" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdEmpresa" width="10">#</th>
                    <th field="Nombre" width="50">Nombre</th>                    
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nueva empresa</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar empresa</a>            
        </div>

        <div id="dlg" class="easyui-dialog" style="width:600px;height:280px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Empresa</div>
            <form id="fm" method="post" novalidate>
                <div class="col-md-12 col-lg-12">
                    <label class="label-top" for="Nombre">Nombre</label>
                    <input name="Nombre" class="easyui-textbox" style="width:100%;height:32px" required="true">
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
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nueva Empresa');
                $('#fm').form('clear');
                url = 'php/saveCompany.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Empresa');
                    $('#fm').form('load', row);
                    url = 'php/updateCompany.php?id=' + row.IdEmpresa;
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
            function destroyUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function (r) {
                        if (r) {
                            $.post('destroy_user.php', {id: row.id}, function (result) {
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