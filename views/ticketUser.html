<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.min.css">
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
                    <th field="nEmpresa" width="50">Empresa</th>
                    <th field="IdCiudad" width="50"  hidden="true">idCuidad</th>
                    <th field="nCiudad" width="50">Cuidad</th>
                    <th field="IdRol" width="50" hidden="true">idRol</th>
                    <th field="nRol" width="50">Rol</th>
                    <th field="IdEspecialidad" width="50" hidden="true">IdEspecialidad</th>
                    <th field="nEspecialidad" width="50">Especialidad</th>
                    <th field="Activo" width="50" hidden="true">Activo</th>
                    <th field="Email" width="50">Correo</th>
                    <th field="Celular" width="50">Celular</th>
                    <th field="DirIp" width="50">Direccion IP</th>
                    <th field="Fotografia" width="14" formatter="formatPrice" >Foto</th>
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

        <div id="dlg" class="easyui-dialog" style="width:1000px;height:450px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Informaci&oacute;n de usuario</div>
            <form id="fm" method="post" enctype="multipart/form-data" novalidate>   
           <div class="row">
                    <div class="col-md-3">
                    <lable>Nombre</lable>
                    <input class="easyui-textbox" type="text" name="Nombre" style="width:100%;height:30px;"  data-options="required:true" ></input>
                    </div>                
                    <div class="col-md-3">
                    <label>Cedula</label>
                    <input class="easyui-textbox" type="text" name="IdUsuario" style="width:100%;height:30px;" data-options="required:true"></input>
                    </div>
                    <div class="col-md-3">
                    <label>Contrase&ntilde;a</label>
                    <input class="easyui-textbox" type="password" value="" name="Pass" style="width:100%;height:30px;" data-options="required:true"></input>
                    </div>
                    <div class="col-md-3">
                    <label>Confirmar Contrase&ntilde;a</label>
                    <input class="easyui-textbox" type="password" name="confirm" style="width:100%;height:30px;" data-options="required:true"></input>
                    </div>
               </div>
               <div class="row">
                   <div class="col-md-3">
                        <label>Empresa</label>
                            <select class="easyui-combobox" name="IdEmpresa" style="width:100%;height:30px;" data-options="
                                    url: '../php/getCompany.php',
                                    method: 'get',
                                    valueField:'IdEmpresa',
                                    textField:'Nombre'">
                            </select>
                    </div>                        
                    <div class="col-md-3">
                        <label>Cuidad</label>
                            <select class="easyui-combobox" name="IdCiudad" style="width:100%;height:30px;" data-options="
                                    url: '../php/getCity.php',
                                    method: 'get',
                                    valueField:'IdCiudad',
                                    textField:'Nombre'">                                
                            </select>
                    </div>
                    <div class="col-md-3">
                        <label>Rol</label>
                            <select class="easyui-combobox" name="IdRol" style="width:100%;height:30px;" data-options="
                                    url: '../php/getRol.php',
                                    method: 'get',
                                    valueField:'IdRol',
                                    textField:'Nombre'">                                
                            </select>
                         </div>
                   <div class="col-md-3">
                        <label>Especialidad</label>
                            <select class="easyui-combobox" name="IdEspecialidad" style="width:100%;height:30px;" data-options="
                                    url: '../php/getAllEspecialitys.php',
                                    method: 'get',
                                    valueField:'IdEspecialidad',
                                    textField:'Nombre',
                                    required:true">
                            </select>
                                </div>
               </div>
              <div class="row">
                <div class="col-md-3">
                        <label>Estado</label>
                            <select class="easyui-combobox" name="Estado" style="width:100%;height:30px;">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                    </div>
                   <div class="col-md-3">
                        <label>Correo</label>
                        <input class="easyui-textbox" type="text" name="Email" style="width:100%;height:30px;" data-options="required:true"></input>
                   </div>
                    <div class="col-md-3">
                        <label>Celular</label>
                        <input class="easyui-textbox" type="text" name="Celular" style="width:100%;height:30px;" data-options="required:true"></input>
                   </div>
                   <div class="col-md-3">
                        <label>Direcci&oacute;n IP</label>
                        <input class="easyui-textbox" type="text" name="DirIp" style="width:100%;height:30px;" data-options="required:true"></input>
                    </div>
                   <div class="col-md-4">                   
                       <label>Foto</label>
                       <input class="f1 easyui-filebox"  name="foto" id="foto" data-options="prompt:'Escojer una foto...'" style="width:100%;height:30px;">
                    </div>
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

            function formatPrice(val,row){
                     return '<img src="'+val+'" height="42" width="42">';
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