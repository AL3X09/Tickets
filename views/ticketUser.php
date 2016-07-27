<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <script type="text/javascript" src="../libs/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="../libs/easyui/jquery.easyui.min.js"></script>
        <script src="../js/functions.js" type="text/javascript"></script>
        <script id="script-lang" src="../libs/easyui/locale/easyui-lang-es.js"></script> 
    </head>
    <body>

        <table id="dg" title="Usuarios" class="easyui-datagrid" style="width:100%;height:450px"
               url="../php/getUser.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdUsuario" width="50">Cedula</th>
                    <th field="Nombre" width="50">Nombre</th>
                    <th field="IdEmpresa" width="50" hidden="true">id empresa</th>
                    <th field="NombreEmpresa" width="50">Empresa</th>
                    <th field="IdCiudad" width="50"  hidden="true">idCuidad</th>
                    <th field="NombreCiudad" width="50">Cuidad</th>
                    <th field="IdRol" width="50" hidden="true">idRol</th>
                    <th field="NombreRol" width="50">Rol</th>
                    <th field="IdEspecialidad" width="50">Especialidad</th>
                    <th field="Activo" width="50">Activo</th>
                    <th field="Email" width="50">Correo</th>
                    <th field="Celular" width="50">Celular</th>
                    <th field="DirIp" width="50">Direccion IP</th>
                    <th field="Fotografia" width="50">Foto</th>
                    <!--se quita no se se permite mostrar en vista
                    <th field="FechaCambio" width="50">Fecha de cambio</th>
                    <th field="FechaUltimoIngreso" width="50">Fecha Ultimo Ingreso</th>
                    <th field="PasswordReset" width="50">Password Reset</th>-->                                        
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Usuario</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>

        </div>

        <div id="dlg" class="easyui-dialog" style="width:500px;height:650px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Informaci&oacute;n de usuario</div>
            <form id="fm" method="post" novalidate>
                <table cellpadding="5">
                    <tr>
                        <td>Nombre</td>
                        <td><input class="easyui-textbox" type="text" name="Nombre" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Cedula</td>
                        <td><input class="easyui-textbox" type="text" name="IdUsuario" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Contrase&ntilde;a</td>
                        <td><input class="easyui-textbox" type="password" value="" name="Pass" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Confirmar Contrase&ntilde;a</td>
                        <td><input class="easyui-textbox" type="password" name="confirm" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Empresa</td>
                        <td>
                            <select class="easyui-combobox" name="IdEmpresa" style="width:100%;height:26px" data-options="
                                    url: '../php/getCompany.php',
                                    method: 'get',
                                    valueField:'IdEmpresa',
                                    textField:'Nombre'">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Cuidad</td>
                        <td>
                            <select class="easyui-combobox" name="IdCiudad"
                                    style="width:100%;height:26px" data-options="
                                    url: '../php/getCity.php',
                                    method: 'get',
                                    valueField:'IdCiudad',
                                    textField:'Nombre'">                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Rol</td>
                        <td>
                            <select class="easyui-combobox" name="IdRol" style="width:100%;height:26px" data-options="
                                    url: '../php/getRol.php',
                                    method: 'get',
                                    valueField:'IdRol',
                                    textField:'Nombre'">                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Especialidad</td>
                        <td>
                            <select class="easyui-combobox" name="IdEspecialidad" style="width:100%;height:26px" data-options="
                                    url: '../php/getAllEspecialitys.php',
                                    method: 'get',
                                    valueField:'IdEspecialidad',
                                    textField:'Nombre',
                                    required:true">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Estado</td>
                        <td>
                            <select class="easyui-combobox" name="Estado" style="width:100%;height:26px">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Correo</td>
                        <td><input class="easyui-textbox" type="text" name="Email" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Celular</td>
                        <td><input class="easyui-textbox" type="text" name="Celular" data-options="required:true"></input></td>
                    </tr>
                    <tr>
                        <td>Direcci&oacute;n IP</td>
                        <td><input class="easyui-textbox" type="text" name="DirIp" data-options="required:true"></input></td>
                    </tr>                
                </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <script type="text/javascript">
            var url;
            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Usuario');
                $('#fm').form('clear');
                url = '../php/saveUser.php';

            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Usuario');
                    $('#fm').form('load', row);
                    url = '../php/updateUser.php?id=' + row.IdUsuario;

                }

            }
            function saveUser() {
                //clave1 = document.Password.clave1.value 
                if ($("input[name=Pass]").val() === $("input[name=confirm]").val()) {
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
                } else {
                    alert("Las contraseñas no coinciden por favor intente otra vez");
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