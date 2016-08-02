<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MODULO ACLARACIONES</title>
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="../libs/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="../libs/easyui/jquery.easyui.min.js"></script>
        <script id="script-lang" src="../libs/easyui/locale/easyui-lang-es.js"></script> 
        <script type="text/javascript" src="../libs/easyui/datagrid-detailview.js"></script>
    </head>
    <body>
        <table id="dg" title="Aclaraciones" class="easyui-datagrid" style="width:100%;height:550px"
               url="../php/getAllClarifications.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdAclaraciones" width="5">#</th>
                    <!-- <th field="nRequerimientoAclara" width="30">Requerimiento</th>-->
                    <th field="idRequerimiento" width="80" hidden="true">IdRequerimiento</th>
                    <th field="Aclaracion" width="80">Aclaracion</th>
                    <th field="FechaCreacion" width="30">Fecha Creacion</th>                    
                    <th field="nUsuarioAclara" width="50">Usuario</th>                    
                    <th field="IdUsuarioAclara" width="50" hidden="true">IdUsuario</th>                    
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nueva Aclaracion</a>
            <!-- por estandar de la paliccion no se puede editar
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
            -->
        </div>

        <div id="dlg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Gestion de Aclaraciones</div>
            <form id="fm" method="post" novalidate>
                <div class="fitem">
                    <div class="row">   
                        <label>Requerimiento</label>
                        <input id="cc" class="easyui-combobox" name="idRequerimiento" style="width:100%" data-options="
                                valueField:'IdRequerimiento',
                                textField:'Requerimiento',
                                required: 'true',
                                url:'../php/getRequirements_original.php'
                            ">
                    </div>
                    <div class=row>
                        <label>Aclaracion</label>
                        <input name="Aclaracion" class="easyui-textbox" required="true" style="width:100%">
                    </div>
                    <!-- no se utiliza ya que la aplicaion recive los datos por session y procesos internos
                    <label>Fecha Creacion</label>
                    <input name="FechaCreacion" class="easyui-textbox" required="true">
                    <label>Usuario</label>
                    <input id="cc" class="easyui-combobox" name="nUsuario" data-options="
                            valueField:'IdUsuario',
                            textField:'Nombre',
                            required: 'true',
                            url:'../php/getUser.php'
                        ">-->                    
                </div>                
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <script type="text/javascript">
            $('#dg').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                return '<div class="ddv" style="padding:5px 0"></div>';
             },
            onExpandRow: function(index,row){
            var ddv = $(this).datagrid('getRowDetail',index).find('div.ddv');
            ddv.datagrid({
                width:300,
                height:120,
                title:"Requerimiento",              
                //border:false,
                cache:false,
                url:'../php/getRequirementsExcel.php?requirement='+row.IdRequerimiento,
                columns:[[
                {field:'Ticket',title:'Ticket'},
                {field:'Requerimiento',title:'Requerimiento'},
                ]],
                onLoad:function(){
                    $('#dg').datagrid('fixDetailRowHeight',index);
                }
            });
                    $('#dg').datagrid('fixDetailRowHeight',index);
              }
            });

            var url;
            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo');
                $('#fm').form('clear');
                url = '../php/saveClarification.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar');
                    $('#fm').form('load', row);
                    url = '../php/updateClarification.php?id=' + row.IdAclaraciones;
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