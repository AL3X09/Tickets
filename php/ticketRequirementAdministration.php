<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
        <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="themes/icon.css">
        <link rel="stylesheet" type="text/css" href="themes/color.css">
        <link rel="stylesheet" type="text/css" href="demo/demo.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="jquery.min.js" type="text/javascript"></script>
        <script src="jquery.easyui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>        
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="toolbar">
            <div id="pp" class="easyui-pagination" style="width:100%;background:#efefef;border:1px solid #ccc;"
                 data-options="pageSize:10" >
            </div>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateRequirement()">Gestionar Requerimiento</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Requerimiento</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-chart" plain="true" onclick="timeLine()">Linea de tiempo</a>

            <!--            <div class="">
                            <label class="label-top" for="IdAplicativo">Aplicativo</label>
            
                            <select name="" id="type-search" style=";height:26px" >
                                <option value="1">Clientes</option>
                                <option value="2">Estados</option>
                                <option value="3">Responsable</option>
                            </select>
                        </div>
                        <div class="">   
                            <label class="label-top" for="IdModulo">Modulo</label>
                            <select name="filtro" id="filtro"  style="height:26px">
            
                            </select>
            
                        </div>
                        <a onclick="find()" class="easyui-linkbutton" plain="true">Buscar</a>-->
        </div>
        <table id="tt" title="Requerimientos" style="width:100%;height:600px" data-options="
               view:scrollview,rownumbers:false,singleSelect:true,
               url:'php/getRequirementsAdministration.php',
               autoRowHeight:false,pageSize:50" footer="#pp"  toolbar = "#toolbar" pagination="false" fitColumns="true">
            <thead>
                <tr>
                    <th field="IdRequerimiento" width="10" hidden="true">#</th>
                    <th field="Ticket" width="30" >Ticket</th>
                    <th field="IdEmpresaRadica" width="50" hidden="true">IDEmpresa</th>                    
                    <th field="nEmpresaRadica" width="50">Empresa</th>                    
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
                    <th field="nEstado" width="50">Estado</th>                         
                </tr>
            </thead>
        </table>


        <style type="text/css">
            .datagrid-header-rownumber,.datagrid-cell-rownumber{
                width:40px;
            }
        </style>
        <div id="dlg" class="easyui-dialog" style=" width:900px;height:600px; padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <form id="fm" method="post" novalidate>

                <div class="easyui-accordion" style="width:100%;height:500px;">
                    <div title="Gestion de Requerimiento" data-options="iconCls:'icon-search',collapsed:false,collapsible:true" style="padding:10px;">
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdTipoRequerimiento">Tipo de requerimiento</label>

                            <select class="easyui-combobox" name="IdTipoRequerimiento" disabled="true" style="width:100%;height:32px" id="IdTipoRequerimiento " data-options="
                                    url: 'php/getTypeRequirement.php',
                                    method: 'get',
                                    valueField:'IdTipoRequerimiento',
                                    textField:'Nombre'">
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdAplicativo">Aplicativo</label>

                            <select name="IdAplicativo" id="IdAplicativo" disabled="true"  style="width:100%;height:32px" >
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">   
                            <label class="label-top" for="IdModulo">Modulo</label>
                            <select name="IdModulo" id="IdModulo" disabled="true" style="width:100%;height:32px">

                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdPrioridad">Prioridad</label>

                            <select class="easyui-combobox" disabled="true" name="IdPrioridad" style="width:100%;height:32px" data-options="
                                    url: 'php/getPriority.php',
                                    method: 'get',
                                    valueField:'IdPrioridad',
                                    textField:'Nombre'">
                            </select>
                        </div>               
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="OrdenCompra">Orden de compra</label>

                            <select class="easyui-combobox" disabled="true" name="OrdenCompra" style="width:100%;height:32px">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>  
                        <div class="col-md-12 col-lg-12"><hr></div>
                        <div class="col-md-12 col-lg-12">
                            <label class="label-top" for="Requerimiento">Requerimiento</label>

                            <input disabled="true" class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" name="Requerimiento" data-options="multiline:true" style="height:60px"></input>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <label class="label-top" for="Objetivo">Objetivo</label>

                            <input disabled="true" class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" name="Objetivo" data-options="multiline:true" style="height:60px"></input>
                        </div>

                    </div>
                    <div title="Datos de requerimiento" data-options="selected:false" style="padding:10px;">
                        <p>Asignacion de requerimientos</p>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdResponsable">Responsable</label>
                            <select class="easyui-combobox" name="IdResponsable" style="width:100%;height:32px" data-options="
                                    url: 'php/getUser.php',
                                    method: 'get',
                                    valueField:'IdUsuario',
                                    textField:'Nombre'">
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="FechaEstSIES">Fecha estimado SIES</label>
                            <input name="FechaEstSIES" class="easyui-datetimebox" style="width:100%;height:32px">
                        </div>
                        <div class="col-md-3 col-lg-3">

                            <label class="label-top" for="FechaEstCliente">Fecha estimado Cliente</label>                              

                            <input name="FechaEstCliente" class="easyui-datetimebox" style="width:100%;height:32px">
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="FechaTerminado">Fecha terminacion</label>
                            <input name="FechaTerminado" class="easyui-datetimebox" style="width:100%;height:32px">
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="Costo">Costo</label>
                            <input class="easyui-textbox" type="text" name="Costo" data-options="required:true"style="width:100%;height:32px"/>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="Costo">Autorizado</label>
                            <input class="easyui-switchbutton" checked name="Autorizado"/>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdEstado">Estado</label>
                            <select class="easyui-combobox" name="IdEstado" style="width:100%;height:32px" data-options="
                                    url: 'php/getStatusRequirement.php',
                                    method: 'get',
                                    valueField:'IdEstado',
                                    textField:'Nombre'">
                            </select>
                        </div>

                    </div>                    
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>

        <div id="reasignar" class="easyui-dialog" style="width:800px;height:500px;padding:1px 1px; overflow:hidden;"
             closed="true" buttons="#dlg-buttons-2">
            <form id="fm-reasignar" method="post" novalidate>
                <p>Asignacion de requerimientos</p>
                <div class="col-md-4 col-lg-3">
                    <label class="label-top" for="IdResponsable">Responsable</label>
                    <select class="easyui-combobox" name="IdResponsable" style="width:100%;height:32px" data-options="
                            url: 'php/getUser.php',
                            method: 'get',
                            valueField:'IdUsuario',
                            textField:'Nombre'">
                    </select>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="FechaEstSies">Fecha estimado SIES</label>
                    <input name="FechaEstSIES" class="easyui-datetimebox" style="width:100%;height:32px">
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="FechaEstCliente">Fecha estimado Cliente</label>
                    <input name="FechaEstCliente" class="easyui-datetimebox" style="width:100%;height:32px">
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="FechaTerminado">Fecha terminacion</label>
                    <input name="FechaTerminado" class="easyui-datetimebox" style="width:100%;height:32px">
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="Costo">Orden de compra</label>
                    <input class="easyui-switchbutton" name="OrdenCompra" id="OrdenCompra"/>
                </div>
                <div class="col-md-3 col-lg-3">

                    <label class="label-top" for="Costo">Costo</label>
                    <input class="easyui-textbox" type="text" name="Costo" data-options="required:true"style="width:100%;height:32px"/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="Costo">Autorizado</label>
                    <input class="easyui-switchbutton" id="Autorizado" name="Autorizado"/>
                </div>                
                <div class="col-md-4 col-lg-3">
                    <label class="label-top" for="IdEstado">Estado</label>
                    <select class="easyui-combobox" name="IdEstado" style="width:100%;height:32px" data-options="
                            url: 'php/getStatusRequirement.php',
                            method: 'get',
                            valueField:'IdEstado',
                            textField:'Nombre'">
                    </select>
                </div>

            </form>
        </div>
        <div id="dlg-buttons-2">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRequirement()" style="width:90px">Asignar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#reasignar').dialog('close')" style="width:90px">Cancelar</a>
        </div>
        <div id="time-line" class="easyui-dialog" style="width:900px;height:700px;padding:1px 1px; overflow:hidden;"
             closed="true" >
            <iframe style="width:100%; height:700px;border: 0px;" name="frame-time-line" id="frame-time-line"></iframe>
        </div>
        <script type="text/javascript">

            var url;
            var urlList;
            var json;
            $(document).ready(function () {
                getTotalTable();
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
//                $("#type-search").change(function (event) {
//                    event.preventDefault();
//                    switch ($("#type-search option:selected").val()) {
//                        case '1'://Clientes
//                            urlList = "php/getCompany.php";
//                            idCampo = "Empresa";
//
//                            break;
//                        case '2'://Estados
//                            urlList = "php/getStatusRequirement.php";
//                            idCampo = "Estado";
//                            break;
//                        case '3'://Responsable
//                            urlList = "php/getUser.php";
//                            idCampo = "Usuario";
//                            break;
//                    }
//                    $("#filtro").children("option").remove();
//                    $.ajax({
//                        url: urlList,
//                        type: 'POST',
//                        success: function (data) {
//                            console.log(data);
//                            datos = JSON.parse(data);
//                            $.each(datos, function (index) {
//                                $("#filtro").append("<option value='" + datos[index]["Id" + idCampo] + "'>" + datos[index]["Nombre"] + "</option>");
//                            });
//                        },
//                        error: function (error) {
//                            console.log(error);
//                        }
//                    });
//                });
                $("#pp").pagination({
                    displayMsg: "Mostrando desde {from} hasta {to} de {total} registros",
                    onSelectPage: function (pageNumber, pageSize) {
                        $(this).pagination('loading');
                        refrescar(pageSize, pageNumber);
                        $(this).pagination('loaded');
                    }

                });
            });
//            function find() {
//                url = "php/getRequirementsExcel.php";
//                switch ($("#type-search option:selected").val()) {
//                    case "1"://clientes
//                        url += "?IdEmpresaRadica=" + $("#filtro option:selected").val();
//                        break;
//                    case "2":
//                        url += "?IdEstado=" + $("#filtro option:selected").val();
//                        break;
//                    case "3":
//                        url += "?IdResponsable=" + $("#filtro option:selected").val();
//                        break;
//                }
//                alert($("#type-search option:selected").val() + "-" + $("#filtro option:selected").val());
//                $.ajax({
//                    url: url,
//                    type: 'POST',
//                    success: function (data) {
//                        console.log(data);
//                        datos = JSON.parse(data);
//                        $("#tt").datagrid("load", datos);
//                    },
//                    error: function (error) {
//                        console.log(error);
//                    }
//                });
//            }

            function refrescar(pageSize, pageNumber) {
                $.ajax({url: 'php/getRequirements.php',
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

            function getTotalTable() {
                var total;
                $.ajax({
                    url: 'php/getTotalTable.php',
                    type: 'POST',
                    data: {table: "requerimiento"},
                    dataType: 'json',
                    success: function (data) {
                        $("#pp").pagination({
                            total: data
                        });
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }

            $(function () {
                $('#Autorizado').switchbutton({
                    onText: "SI",
                    offText: "NO",
                });
                $('#OrdenCompra').switchbutton({
                    onText: "SI",
                    offText: "NO"
                });
            });
            function getModuleByApp() {
                $("#IdModulo").children("option").remove();
                $.ajax({
                    url: 'php/getModulesExcel.php?app=' + $("#IdAplicativo option:selected").val(),
                    type: 'POST',
                    data: {"app": $("#IdAplicativo option:selected").val()},
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#IdModulo").append("<option value='" + data[index]["IdAplicativo"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Requerimiento');
                $('#fm').form('clear');
                url = 'php/saveRequirementClient.php';
            }
            function editUser() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Requerimiento');
                    $('#fm').form('load', row);
                    url = 'php/updateRequirement.php?id=' + row.IdRequerimiento;
                }
            }
            function updateRequirement() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
                if (row) {
                    $('#reasignar').dialog('open').dialog('center').dialog('setTitle', 'Reasignar Requerimiento');
                    $('#fm-reasignar').form('load', row);
                    url = 'php/updateRequirementAdmon.php?id=' + row.IdRequerimiento;
                }
            }

            function saveRequirement() {
                $('#fm-reasignar').form('submit', {
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
                            $('#reasignar').dialog('close');        // close the dialog
                            $('#tt').datagrid('reload');    // reload the user data
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
                        alert(result);
                        var result = eval('(' + result + ')');
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg').dialog('close');        // close the dialog
                            $('#tt').datagrid('reload');    // reload the user data
                        }
                    }
                });
            }
            function destroyUser() {
                var row = $('#tt').datagrid('getSelected');
                if (row) {
                    $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function (r) {
                        if (r) {
                            $.post('destroy_user.php', {id: row.id}, function (result) {
                                if (result.success) {
                                    $('#tt').datagrid('reload');    // reload the user data
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
            function timeLine() {
                var row = $('#tt').datagrid('getSelected');
                if (row) {
                    ///alert("index.html?id=" + row.IdRequerimiento);
                    $('#frame-time-line').attr("src", "index.html?id=" + row.IdRequerimiento);
                    $('#time-line').dialog('open').dialog('center').dialog('setTitle', 'Linea de tiempo requerimiento No.' + row.IdRequerimiento);

                }
            }
        </script>
        <script type="text/javascript">

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
                                '<p><label>Fecha estimado cliente:</label>' + rowData.FechaEstCliente + '</p>' +
                                '<p><label>Fecha Terminado:</label> ' + rowData.FechaTerminado + ' </p>' +
                                '</td>' +
                                '</td>' +
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>Fecha estimado SIES:</label>' + rowData.FechaEstSIES + '</p>' +
                                '<p><label>Usuario responsable:</label> ' + rowData.nUsuarioResponsable + ' </p>' +
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