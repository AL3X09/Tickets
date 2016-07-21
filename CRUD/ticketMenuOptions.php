<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
        <link rel="stylesheet" type="text/css" href="themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="themes/icon.css">
        <link rel="stylesheet" type="text/css" href="themes/color.css">
        <link rel="stylesheet" type="text/css" href="demo/demo.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
        <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
        <script id="script-lang" src="locale/easyui-lang-es.js"></script> 
        <script>
            $(document).ready(function () {

                $('th:nth-child(3)').hide();
                // if your table has header(th), use this
                //$('td:nth-child(2),th:nth-child(2)').hide();

            });
        </script>
    </head>
    <body>
        <h2>Menu Opciones</h2>

        <table id="dg" title="Menu opciones" class="easyui-datagrid" style="width:700px;height:250px"
               url="php/getMenuOptions.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="false" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdMenuOpcion" width="10">#</th>
                    <th field="Nombre" width="50">Nombre</th>
                    <th field="NombrePadre" width="50">Padre</th>
                    <th field="IdPadre" hidden="true" width="50">idpadre</th>
                    <th field="Formulario" width="50">Formulario</th>
                    <th field="Icono" width="50">Icono</th>
                    <th field="Activo" width="50">Estado</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nueva Opcion</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
        </div>

        <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Ingresar Menu Opciones</div>
            <form id="fm" method="post" novalidate>
                <div class="fitem">
                    <label>Nombre</label>
                    <input name="Nombre" class="easyui-textbox" required="true">
                </div>
                <div class="fitem">
                    <label>Formulario</label>
                    <input name="Formulario" class="easyui-textbox" required="true">
                </div>
                <div class="fitem">
                    <label>Icono</label>
                    <input name="Icono" class="easyui-textbox" required="true">
                </div>
                <div class="fitem">
                    <label>Padre</label>
                    <select class="easyui-combobox" name="IdPadre"
                            style="width:60%;height:26px"
                            data-options="
                            url: 'php/getModules.php',
                            method: 'get',
                            valueField:'IdModulo',
                            textField:'Nombre'">                                
                    </select>
                </div>
                <!--                <div>
                                    <label>Archivo</label>
                                    <input name="incono" class="f1 easyui-filebox"></input>
                                </div>-->
                <div class="fitem">
                    <label>Estado</label>
                    <input name="Estado" class="easyui-textbox" required="true" validType="email">
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
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nueva Opcion');
                $('#fm').form('clear');
                url = 'php/saveMenuOptions.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Opcion');
                    $('#fm').form('load', row);
                    url = 'php/updateMenuOptions.php?id=' + row.id;
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