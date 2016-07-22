<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MODULO FAQ</title>
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="../libs/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="../libs/easyui/jquery.easyui.min.js"></script>
        <script id="script-lang" src="../libs/easyui/locale/easyui-lang-es.js"></script> 
    </head>
    <body>
        
        <table id="dg" title="FAQ" class="easyui-datagrid" style="width:100%;height:350px"
               url="../php/getAllFAQ.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="Requerimiento" width="50">Requerimiento</th>
                    <th field="Respuesta" width="50">Respuesta</th>                    
                    <th field="Aplicativo" width="50">Aplicativo</th>                    
                    <th field="Modulo" width="50">Modulo</th>                    
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Requqerimiento</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
        </div>

        <div id="dlg" class="easyui-dialog" style="width:700px;height:500px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Gestion de Requerimiento</div>
            <form id="fm" method="post" novalidate>
            <!--agrego bostrap para el contenidodel -->
            <!--combobox selecion ID aplicativo -->
                <div class="row">
                  <label>Aplicativo</label>
                  <select id="ap" class="easyui-combobox" name="idAplicativo" style="width:100%" data-options="
                                    valueField: 'IdAplicativo',
                                    textField: 'Nombre',
                                    url: '../php/getApp.php',
                                   "></select>
                </div> 
                <!--combobox selecion ID modulo -->
                <div class="row">
                  <label>Modulo</label>
                  <select id="md" class="easyui-combobox" name="idModulo" style="width:100%" data-options="
                                    valueField: 'IdModulo',
                                    textField: 'Nombre',
                                    url: '../php/getModules.php',
                                    "></select>
                </div>       
                <!--input requerimiento (pregunta) -->
                <div class="row">
                    <label>Requerimiento</label>
                    <input name="Requerimiento" class="easyui-textbox" required="true" style="width:100%">
                </div>
                <!--input respuesta -->
                <div class="row">
                    <label>Respuesta</label>
                    <!--<input name="Respuesta" class="easyui-textbox" required="true">-->
                    <textarea class="form-control" name="Respuesta" required="true"></textarea>
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
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Requerimiento');
                $('#fm').form('clear');
                url = '../php/saveFAQ.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar');
                    $('#fm').form('load', row);
                    url = '../php/updateFAQ.php?id=' + row.IdFAQ;
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
                                msg: "accion satisfactoria",
                                showType: 'show'
                            });
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload the user data
                     }                    
                    }
                });
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