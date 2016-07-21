<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
        <table id="dg" title="Aplicativos" class="easyui-datagrid" class="col-lg-12 col-md-12"
               url="../php/GetApp.php"
               toolbar="#toolbar" pagination="true"
               rownumbers="false" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="IdAplicativo" width="10">#</th>
                    <th field="Nombre" width="50">Nombre</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Aplicativo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>

        </div>

        <div id="dlg" class="easyui-dialog" style="width:400px;padding:20px;"
             closed="true" buttons="#dlg-buttons">
            <div class="ftitle">Aplicativo</div>
            <form id="fm" method="post" novalidate>
                <div class="col-md-12 col-lg-12">
                    <label class="label-top" for="Nombre">Nombre</label>
                    <input name="Nombre" id="Nombre" class="easyui-textbox" style="width:100%;height:32px" required="true">
                </div>            
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <script type="text/javascript">
            var url;
//            var pager;
//            var totalRows;
//            $(document).ready(function () {
//                               
//                pager = $("#dg").datagrid().datagrid("getPager");
//                getTotalTable(pager); 
//                pager.pagination({                  
//                    pageSize: 10;                    
//                    onSelectPage: function (pageNumber, pageSize) {
//                        $(this).pagination('loading');
//                        refrescar(pageSize, pageNumber);
//                        $(this).pagination('loaded');
//                    }
//                });
//            });

//            function refrescar(pageSize, pageNumber) {
//                $.ajax({url: 'php/getRequirementsAdministration.php',
//                    data: {page: pageNumber, rows: pageSize},
//                    dataType: 'json',
//                    type: "POST",
//                    success: function (data) {
//                        $("#tt").datagrid("loadData", data);
//                    }, error: function (error) {
//                        console.log(error);
//                    }
//                });
//
//            }
//            
//            function getTotalTable(paginator) {
//                var total;
//                $.ajax({
//                    url: 'php/getTotalTable.php',
//                    type: 'POST',
//                    data: {table: "requerimiento"},
//                    dataType: 'json',
//                    success: function (data) {
//                        paginator.pagination({
//                            total: data
//                        });
//                    }, error: function (error) {
//                        console.log(error);
//                    }
//                });
//            }

            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Aplicativo');
                $('#fm').form('clear');
                url = '../php/saveApp.php';
            }
            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Aplicativo');
                    $('#fm').form('load', row);
                    url = '../php/updateApp.php?id=' + row.IdAplicativo;
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