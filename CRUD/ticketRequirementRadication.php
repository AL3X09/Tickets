<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Radicacion</title>
        <link rel="stylesheet" type="text/css" href="themes/bootstrap/easyui.css">
        <link rel="stylesheet" type="text/css" href="themes/icon.css">
        <link rel="stylesheet" type="text/css" href="themes/color.css">
        <link rel="stylesheet" type="text/css" href="demo/demo.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="jquery.min.js" type="text/javascript"></script>
        <script src="jquery.easyui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script> 
        <script id="script-lang" src="locale/easyui-lang-es.js"></script> 
    </head>
    <body>
        <div id="toolbar">

            <a href="javascript:void(0)" class="easyui-linkbutton" id="new-requirement" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Requerimiento</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-mini-add" plain="true" onclick="startAclaration()">Aclarar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" id="edit-requirement" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-chart" plain="true" onclick="timeLine()">Linea de tiempo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-smartart" plain="true" onclick="addComment()">Agregar Comentario</a>
        </div>
        <table id="tt" title="Requerimientos" style="width:100%;height:600px" data-options="
               view:scrollview,rownumbers:false,singleSelect:true,
               url:'php/getRequirementsRadication.php',
               autoRowHeight:true" footer="#pp" toolbar = "#toolbar" pagination="false" fitColumns="true">
            <thead>
                <tr>
                    <th field="IdRequerimiento" width="10" hidden="true">#</th>
                    <th field="Ticket" width="30" >Ticket</th>
    <!--                    <th field="IdEmpresaRadica" width="50" hidden="true">IDEmpresa</th>                    
                    <th field="nEmpresaRadica" width="50">Empresa</th>                    -->
                    <th field="FechaRadicado" width="50">Fecha de radicacion</th>
                    <th field="IdTipoRequerimiento" width="50" hidden="true">IDTipo requerimiento</th>
                    <th field="nTipoRequerimiento" width="50">Tipo requerimiento</th>
                    <th field="IdAplicativo" width="50"hidden="true">IDAplicativo</th>
                    <th field="nAplicativo" width="50">Aplicativo</th>
                    <th field="IdModulo" width="50"hidden="true">IDModulo</th>
                    <th field="nModulo" width="50">Modulo</th>
                    <th field="IdPrioridad" width="50" hidden="true">IDPrioridad</th>
                    <th field="nPrioridad" width="50">Prioridad</th>
                    <th field="valOrdenCompra" width="50">Orden de compra</th>
                    <th field="valAutorizado" width="50">Autorizado</th>                    
    <!--                    <th field="FechaEstSIES" width="50">Fecha estimado SIES</th>-->
                    <th field="nEstado" width="50">Estado</th>                         
                </tr>
            </thead>
        </table>
        <div id="pp" class="easyui-pagination" style="width:100%;background:#efefef;border:1px solid #ccc;">
        </div>
        <style type="text/css">
            .datagrid-header-rownumber,.datagrid-cell-rownumber{
                width:40px;
            }
        </style>

        <!--Modal de Edicion -->
        <div id="dlg" class="easyui-dialog" style=" width:900px; padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <form id="fm" method="post" novalidate>

                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="IdTipoRequerimiento">Tipo de requerimiento</label>

                    <select class="easyui-combobox" name="IdTipoRequerimiento" style="width:100%;height:32px" id="IdTipoRequerimiento " data-options="
                            url: 'php/getTypeRequirement.php',
                            method: 'get',
                            valueField:'IdTipoRequerimiento',
                            textField:'Nombre'">
                    </select>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="IdAplicativo">Aplicativo</label>

                    <select name="IdAplicativo" id="IdAplicativo"  style="width:100%;height:32px" >
                    </select>
                </div>
                <div class="col-md-3 col-lg-3">   
                    <label class="label-top" for="IdModulo">Modulo</label>
                    <select name="IdModulo" id="IdModulo" style="width:100%;height:32px">

                    </select>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="IdPrioridad">Prioridad</label>

                    <select class="easyui-combobox" name="IdPrioridad" id="IdPrioridad" style="width:100%;height:32px" data-options="
                            url: 'php/getPriority.php',
                            method: 'get',
                            valueField:'IdPrioridad',
                            textField:'Nombre'">
                    </select>
                </div>
                <div class="col-md-12 col-lg-12"><hr></div>

                <div class="col-md-12 col-lg-12">
                    <label class="label-top" for="Requerimiento">Requerimiento</label>

                    <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" id="Requerimiento" name="Requerimiento" data-options="multiline:true" style="height:60px"></input>
                </div>
                <div class="col-md-12 col-lg-12">
                    <label class="label-top" for="Objetivo">Objetivo</label>

                    <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" id="Objetivo"  name="Objetivo" data-options="multiline:true" style="height:60px"></input>
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <div id="dlg-aclaraciones" class="easyui-dialog" style=" width:900px; padding:10px 20px"
             closed="true" buttons="#dlg-buttons-clarification">
            <form id="fm-aclaraciones" method="post" novalidate>            
                <div class="col-md-12 col-lg-12">
                    <label class="label-top" for="Requerimiento">Aclaraci&oacute;n</label>

                    <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" name="Aclaracion" data-options="multiline:true" style="width: 100%;height:60px"></input>
                </div>            
            </form>
        </div>
        <div id="dlg-buttons-clarification">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAclaration()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-aclaraciones').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <!-- fin modal de edicion -->
        <div id="time-line" class="easyui-dialog" style="width:90%;height:500px;padding:1px 1px; overflow:hidden;"
             closed="true" >
            <iframe style="width:100%; height:500px;border: 0px;" name="frame-time-line" id="frame-time-line"></iframe>
        </div>
        <!-- modale de comentario -->
        <div id="dlg-comment" class="easyui-dialog" style=" width:80%;height:600px; padding:10px 20px"
             closed="true" buttons="#comment-buttons">
            <form id="fm-comment" method="post" novalidate>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="IdTipoLineaTiempo">Tipo de requerimiento</label>
                    <select class="easyui-combobox" name="IdTipoLineaTiempo" style="width:100%;height:32px" id="IdTipoRequerimiento " data-options="
                            url: 'php/getTypeTimeLine.php',
                            method: 'get',
                            valueField:'IdTipoLineaTiempo',
                            textField:'Nombre'">
                    </select>
                </div>
                <div class="col-md-11 col-lg-11">
                    <label class="label-top" for="Descripcion">Descripcion</label>

                    <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox"  id="Descripcion" name="Descripcion" data-options="multiline:true" style="height:60px"></input>
                </div>
            </form>
        </div>
        <div id="comment-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveComment()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-comment').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <div id="time-line" class="easyui-dialog" style="width:900px;height:700px;padding:1px 1px; overflow:hidden;"
             closed="true" >
            <iframe style="width:100%; height:700px;border: 0px;" name="frame-time-line" id="frame-time-line"></iframe>
        </div>
        <!--fin modal comentario-->


        <script type="text/javascript">
            var url;
            var pager;
            $(document).ready(function () {
                getTotalRows();
                pager = $('#tt').datagrid().datagrid('getPager');
                $.ajax({
                    url: 'php/getApp.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#IdAplicativo").append("<option value='" + data[index]["IdAplicativo"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    }
                });



                $("#IdAplicativo").change(function (event) {
                    event.preventDefault();
                    getModuleByApp();
                });



                $("#pp").pagination({
                    pageSize: 10,
                    onSelectPage: function (pageNumber, pageSize) {
                        $(this).pagination('loading');
                        refrescar(pageSize, pageNumber);
                        $(this).pagination('loaded');
                    }

                });
            });

            function getTotalRows() {
                $.ajax({url: 'php/getTotalRequirementsRadication.php',
                    dataType: 'json',
                    type: "POST",
                    success: function (data) {
                        $("#pp").pagination({
                            total: data
                        });
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }

            function refrescar(pageSize, pageNumber) {
                $.ajax({url: 'php/getRequirementsRadication.php',
                    data: {page: pageNumber, rows: pageSize},
                    dataType: 'json',
                    type: "POST",
                    success: function (data) {
                        $("#tt").datagrid("loadData", data);
                    }, error: function (error) {
                        console.log(error);
                    }
                });

            }

            function getModuleByApp() {
                $("#IdModulo").children("option").remove();
                $.ajax({
                    url: 'php/getModulesExcel.php?app=' + $("#IdAplicativo option:selected").val(),
                    type: 'POST',
                    data: {"app": $("#IdAplicativo option:selected").val()},
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#IdModulo").append("<option value='" + data[index]["IdModulo"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
            function newUser() {
                newRequirement();
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Requerimiento');
                $('#fm').form('clear');
                url = 'php/saveRequirementRadication.php';
            }
            function editUser() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
                editRequirement();
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Requerimiento');
                    $('#fm').form('load', row);
                    url = 'php/updateRequirementRadication.php?id=' + row.IdRequerimiento + "&ticket=" + row.Ticket;
                }
            }
            function newRequirement() {
                $("#IdPrioridad").textbox({disabled: false});
                $("#Requerimiento").textbox({disabled: false});
                $("#Objetivo").textbox({disabled: false});
            }
            function editRequirement() {
                $("#IdPrioridad").textbox({disabled: true});
                $("#Requerimiento").textbox({disabled: true});
                $("#Objetivo").textbox({disabled: true});
            }
            function startAclaration() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
                if (row) {
                    $('#dlg-aclaraciones').dialog('open').dialog('center').dialog('setTitle', 'Aclarar');
                    $('#fm-aclaraciones').form('load', row);
                    url = 'php/saveClarification.php?id=' + row.IdRequerimiento;
                }
            }

            function saveAclaration() {
                $('#fm-aclaraciones').form('submit', {
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
                            $('#dlg-aclaraciones').dialog('close');        // close the dialog
                            $('#tt').datagrid('reload');    // reload the user data
                            getTotalTable();
                        }
                    }
                });
            }
            function saveUser() {
                $('#fm').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (result) {
                        console.log(result);
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
                            $('#tt').datagrid('reload');    // reload the user data
                            getTotalRows();

                        }
                    }
                });
            }
            function timeLine() {
                var row = $('#tt').datagrid('getSelected');
                if (row) {
                    ///alert("index.html?id=" + row.IdRequerimiento);
                    $('#frame-time-line').attr("src", "index.html?id=" + row.IdRequerimiento);
                    $('#time-line').dialog('open').dialog('center').dialog('setTitle', 'Linea de tiempo requerimiento No.' + row.IdRequerimiento);

                }
            }

            $(function () {
                $('#tt').datagrid({
                    detailFormatter: function (rowIndex, rowData) {
                        return '<table><tr>' +
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>Usuario radica:</label> ' + rowData.nUsuarioRadica + '</p>' +
                                '<p><label>Requerimiento:</label> ' + rowData.Requerimiento + '</p>' +
                                '</td>' +
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>Objetivo:</label> ' + rowData.Objetivo + '</p>' +
                                '<p><label>Quien Autoriza:</label> ' + rowData.nUsuarioAutoriza + '</p>' +
                                '</td>' +
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>Fecha estimado:</label>' + rowData.FechaEstSIES + '</p>' +
                                '<p><label>Fecha Terminado:</label> ' + rowData.FechaTerminado + ' </p>' +
                                '</td>' +
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>FechaPruebas:</label> ' + rowData.FechaPruebas + '</p>' +
                                '<p><label>FechaProduccion:</label> ' + rowData.FechaProduccion + '</p>' +
                                '</td>' +
                                '</tr></table>';
                    }
                });
            });
            function loadLocal() {
                var rows = [];
                for (var i = 1; i <= 8000; i++) {
                    var amount = Math.floor(Math.random() * 1000);
                    var price = Math.floor(Math.random() * 1000);
                    rows.push({
                        inv: 'Inv No ' + i,
                        date: $.fn.datebox.defaults.formatter(new Date()),
                        name: 'Name ' + i,
                        amount: amount,
                        price: price,
                        cost: amount * price,
                        note: 'Note ' + i
                    });
                }
                $('#tt').datagrid('loadData', rows);
            }

            function addComment() {
                var row = $('#tt').datagrid('getSelected');
//                alert(row.Autorizado);
                if (row) {
                    $('#dlg-comment').dialog('open').dialog('center').dialog('setTitle', 'Agregar Comentario');
                    $('#fm-comment').form('load', row);
                    url = 'php/saveTimeLine.php?IdRequerimiento=' + row.IdRequerimiento;
                }
            }

            function saveComment() {
                $('#fm-comment').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (result) {
                        console.log(result);
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
                            $('#dlg-comment').dialog('close'); // close the dialog
                        }
                    }, error: function (error) {
                        console.log(error);
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