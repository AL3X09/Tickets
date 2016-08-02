<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Administracion</title>
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/material/easyui.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/themes/color.css">
        <link rel="stylesheet" type="text/css" href="../libs/easyui/demo/demo.css">
        <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../libs/easyui/jquery.min.js" type="text/javascript"></script>
        <script src="../libs/easyui/jquery.easyui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>    <!-- Agregar ScrollView Local-->    
        <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/functions.js" type="text/javascript"></script>
        <script id="script-lang" src="../libs/easyui/locale/easyui-lang-es.js"></script>
        <link href="../libs/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="toolbar">            
            <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateRequirement()">Gestionar Requerimiento</a>-->
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateRequirement()">Asignar Requerimiento</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-chart" plain="true" onclick="timeLine()">Linea de tiempo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-smartart" plain="true" onclick="generateOrder()">Orden de Compra</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-large-smartart" plain="true" onclick="addComment()">Agregar Comentario</a>

            <span>Empresa:</span>
            <select class="" name="buscarIdEmpresa" id="buscarIdEmpresa" style="width:150px;height:26px" >
                <option ><option>
            </select>
            <span>Responsable:</span>
            <select class="" name="IdUsuarioResponsable" id="IdUsuarioResponsable" style="width:150px;height:26px" >
                <option ><option>
            </select>
            <span>Prioridad</span>
            <select name="buscarIdAplicativo" id="buscarIdAplicativo" style="width:150px;height:26px" >
                <option ><option>
            </select>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="doSearch()">Filtrar</a>

        </div>

        <table id="tt" title="Requerimientos" style="width:100%;height:600px" class="easyui-datagrid" data-options="
               view:scrollview,rownumbers:false,singleSelect:true,
               url:'../php/getRequirementsAdministration.php',
               autoRowHeight:false" footer="#pp"  toolbar = "#toolbar" pagination="false" fitColumns="true">
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
                    <!--<th field="FechaEstSIES" width="50">FechaEstSIES</th>-->
                    <th field="nModulo" width="50">Modulo</th>
                    <th field="IdPrioridad" width="50" hidden="true">IDPrioridad</th>
                    <th field="nPrioridad" width="50">Prioridad</th>
                    <th field="valOrdenCompra" width="50" align="center" formatter ="purchaseOrder">Orden de compra</th>
                    <th field="valAutorizado" width="50">Autorizado</th>                    
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

        <div id="dlg" class="easyui-dialog" style=" width:80%;height:600px; padding:10px 20px"
             closed="true" buttons="#dlg-buttons">
            <form id="fm" method="post" novalidate>

                <div class="easyui-accordion" style="width:100%;height:500px;">
                    <div title="Gestion de Requerimiento" data-options="collapsed:false,collapsible:true" style="padding:5px;">
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="IdTipoRequerimiento">Tipo de requerimiento</label>
                            <select class="easyui-combobox" name="IdTipoRequerimiento" disabled="true" style="width:100%;height:32px" id="IdTipoRequerimiento " data-options="
                                    url: '../php/getTypeRequirement.php',
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
                                    url: '../php/getPriority.php',
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
                        <div class="col-md-11 col-lg-11">
                            <label class="label-top" for="Requerimiento">Requerimiento</label>

                            <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" disabled="true" id="Requerimiento" name="Requerimiento" data-options="multiline:true" style="height:60px"></input>
                        </div>
                        <div class="col-md-11 col-lg-11">
                            <label class="label-top" for="Objetivo">Objetivo</label>

                            <input class="col-md-12 col-lg-12 col-sm-12 easyui-textbox" disabled="true" id="Objetivo"  name="Objetivo" data-options="multiline:true" style="height:60px"></input>
                        </div>

                    </div>
                    <div title="Datos de requerimiento" data-options="selected:false" style="padding:10px;">
                        <p>Asignacion de requerimientos</p>
                        <div class="col-md-4 col-lg-3">
                            <label class="label-top" for="IdResponsable">Responsable</label>
<!--                            <select class="easyui-combobox" name="IdResponsable" style="width:100%;height:32px" data-options="
                                    url: 'php/getUser.php',
                                    method: 'get',
                                    valueField:'IdUsuario',
                                    textField:'Nombre'">
                            </select>-->
                            <select class="easyui-combogrid" name="IdResponsable" id="IdResponsable" style="width:100%;height:32px" data-options="
                                    panelWidth: 500,
                                    idField: 'IdUsuario',
                                    textField: 'Nombre',
                                    url: '../php/getUser.php',
                                    method: 'get',
                                    //columns: [[
                                    //{field:'IdUsuario',title:'#',width:80},
                                    //{field:'Nombre',title:'Nombre',width:120},
                                    //{field:'Email',title:'Correo',width:120}
                                    //]],
                                    fitColumns: true
                                    ">
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="FechaEstSIES">Fecha estimado SIES</label>
                            <!--<input name="FechaEstSIES" id="FechaEstSIES" class="easyui-datetimebox" style="width:100%;height:32px">-->


                            <div class='input-group datetime' id='FechaEstSIES'>
                                <input type='text' class="form-control" name="FechaEstSIES" style="width:100%;height:32px"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>


                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="FechaEstCliente">Fecha estimado Cliente</label>
                            <!--<input name="FechaEstCliente" class="easyui-datetimebox" style="width:100%;height:32px">-->

                            <div class='input-group datetime' id='FechaEstCliente'>
                                <input type='text' class="form-control" name="FechaEstCliente" style="width:100%;height:32px" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>

                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="FechaTerminado">Fecha terminacion</label>
                            <!--<input name="FechaTerminado" class="easyui-datetimebox" style="width:100%;height:32px">-->
                            <div class='input-group datetime' id='FechaTerminado'>
                                <input type='text' class="form-control" name="FechaTerminado" style="width:100%;height:32px" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">

                            <label class="label-top" for="FechaPruebas">Fecha de pruebas</label>                              

                            <!--<input name="FechaPruebas" class="easyui-datetimebox" style="width:100%;height:32px">-->
                            <div class='input-group datetime' id='FechaPruebas'>
                                <input type='text' class="form-control" name="FechaPruebas" style="width:100%;height:32px"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">

                            <label class="label-top" for="FechaProduccion">Fecha produccion</label>                              

<!--                            <input name="FechaProduccion" class="easyui-datetimebox" style="width:100%;height:32px">-->
                            <div class='input-group datetime' id='FechaProduccion'>
                                <input type='text' class="form-control" name="FechaProduccion" style="width:100%;height:32px" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="OrdenCompra">Orden de compra</label>
                            <div style="width:100%;height:32px"><input class="easyui-switchbutton col-md-4"  name="OrdenCompra" id="OrdenCompra" /></div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="Costo">Costo</label>
                            <input class="" type="text" name="Costo" id="Costo" data-options="required:true"style="width:100%;height:32px"/>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <label class="label-top" for="Autorizado">Autorizado</label>
                            <div style="width:100%;height:32px"><input class="easyui-switchbutton" id="Autorizado" name="Autorizado"/></div>
                        </div>                
                        <div class="col-md-4 col-lg-3">
                            <label class="label-top" for="IdEstado">Estado</label>
                            <select class="easyui-combobox" name="IdEstado" style="width:100%;height:32px" data-options="
                                    url: '../php/getStatusRequirement.php',
                                    method: 'get',
                                    valueField:'IdEstado',
                                    textField:'Nombre'">
                            </select>
                        </div>
                    </div>                    
                </div>
            </form>
        </div>
        <div id="dlg-comment" class="easyui-dialog" style=" width:80%;height:600px; padding:10px 20px"
             closed="true" buttons="#comment-buttons">
            <form id="fm-comment" method="post" novalidate>
                <div class="col-md-3 col-lg-3">
                    <label class="label-top" for="IdTipoLineaTiempo">Tipo de requerimiento</label>
                    <select class="easyui-combobox" name="IdTipoLineaTiempo" style="width:100%;height:32px" id="IdTipoRequerimiento " data-options="
                            url: '../php/getTypeTimeLine.php',
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
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>

        <div id="time-line" class="easyui-dialog" style="width:900px;height:700px;padding:1px 1px; overflow:hidden;"
             closed="true" >
            <iframe style="width:100%; height:700px;border: 0px;" name="frame-time-line" id="frame-time-line"></iframe>
        </div>
        <div id="purchase-order" class="easyui-dialog" style="width:900px;height:700px;padding:1px 1px; overflow:hidden;"
             closed="true" >
            <iframe style="width:100%; height:700px;border: 0px;" name="frame-purchase-order" id="frame-purchase-order"></iframe>
        </div>

        <script type="text/javascript">
            function purchaseOrder(val, row) {
                if (val == "NO") {
                    return '<span style="color:red;"><img style="width:5;height:5;" src="../img/Alerta.png" alt=""/>(' + val + ')</span>';
                }
                return '<span style="color:green;"><img style="width:5;height:5;" src="../img/tick-large.png" alt=""/>(' + val + ')</span>';
            }
            var url;
            var urlList;
            var json;
            $(document).ready(function () {
                getTotalTable();
                $("#Costo").keyup(function () {
                    var num = this.value.replace(/\./g, '');
                    if (!isNaN(num)) {
                        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
                        num = num.split('').reverse().join('').replace(/^[\.]/, '');
                        this.value = num;
                    } else {

                    }
                });
                $.ajax({
                    url: '../php/getApp.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#IdAplicativo").append("<option value='" + data[index]["IdAplicativo"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    }
                });
                $.ajax({
                    url: '../php/getUser.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#IdUsuarioResponsable").append("<option value='" + data[index]["IdUsuario"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    }
                });
                $.ajax({
                    url: '../php/getCompany.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#buscarIdEmpresa").append("<option value='" + data[index]["IdEmpresa"] + "'>" + data[index]["Nombre"] + "</option>");
                        });
                    }
                });
                $.ajax({
                    url: '../php/getPriority.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index) {
                            $("#buscarIdAplicativo").append("<option value='" + data[index]["IdPrioridad"] + "'>" + data[index]["Nombre"] + "</option>");
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



                $.ajax({
                    url: '../php/getStatusRequirementCG.php',
                    dataType: 'json',
                    method: 'post',
                    success: function (respuesta) {
                        
                        $("#IdResponsable").combogrid({
                            columns: respuesta
                        });
                    },error:function(error){
                        console.log(error);
                    }
                });
            });

            function doSearch() {
                $.ajax({url: '../php/getRequirementsAdministration.php',
                    data: {IdUsuarioResponsable: $("#IdUsuarioResponsable option:selected").val(), IdEmpresa: $("#buscarIdEmpresa option:selected").val(), IdPrioridad: $("#buscarIdAplicativo option:selected").val()},
                    dataType: 'json',
                    type: "POST",
                    success: function (data) {
                        $("#tt").datagrid("loadData", data);
                        getTotalRows();
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
            function getTotalRows() {
                $.ajax({url: '../php/getTotalRequirementsAdmon.php',
                    data: {IdUsuarioResponsable: $("#IdUsuarioResponsable option:selected").val(), IdEmpresa: $("#buscarIdEmpresa option:selected").val(), IdPrioridad: $("#buscarIdAplicativo option:selected").val()},
                    dataType: 'json',
                    type: "POST",
                    success: function (data) {
//                        alert(data);
                        $("#pp").pagination({
                            total: data
                        });
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
            function refrescar(pageSize, pageNumber) {
                $.ajax({url: '../php/getRequirementsAdministration.php',
                    data: {page: pageNumber, rows: pageSize, IdUsuarioResponsable: $("#IdUsuarioResponsable option:selected").val(), IdEmpresa: $("#buscarIdEmpresa option:selected").val(), IdPrioridad: $("#buscarIdAplicativo option:selected").val()},
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
                    url: '../php/getTotalTable.php',
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
                    offText: "NO"
                });
                $('#OrdenCompra').switchbutton({
                    onText: "SI",
                    offText: "NO"
                });
            });
            function getModuleByApp() {
                $("#IdModulo").children("option").remove();
                $.ajax({
                    url: '../php/getModulesExcel.php?app=' + $("#IdAplicativo option:selected").val(),
                    type: 'POST',
                    data: {"app": $("#buscarIdAplicativo option:selected").val()},
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
                url = '../php/saveRequirementClient.php';
            }
            function editUser() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
//                alert(row);
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Requerimiento');
                    $('#fm').form('load', row);
                    url = '../php/updateRequirement.php?id=' + row.IdRequerimiento + "&ticket=" + row.Ticket;
                }
            }
            function updateRequirement() {
                var row = $('#tt').datagrid('getSelected');
                getModuleByApp();
                if (row) {
//                    $('#FechaEstSIES').datetimepicker().children('input').val(row.FechaEstSIES);
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Reasignar Requerimiento');
                    $('#fm').form('load', row);
                    url = '../php/updateRequirementAdmon.php?id=' + row.IdRequerimiento + "&ticket=" + row.Ticket;
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
                            $.messager.show({
                                title: 'Notificacion',
                                msg: result,
                                showType: 'show'
                            });
                            $('#reasignar').dialog('close'); // close the dialog
                            $('#tt').datagrid('reload'); // reload the user data
                        }
                    }, error: function (error) {
                        console.log(error);
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

                            $('#dlg').dialog('close'); // close the dialog
                            $('#tt').datagrid('reload'); // reload the user data
                        }
                    }, error: function (error) {
                        console.log(error);
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
            function generateOrder() {
                var row = $('#tt').datagrid('getSelected');
//                alert(row.Autorizado);
                if (row && row.Autorizado === "on") {
                    $('#frame-purchase-order').attr("src", "../php/GeneratePDF.php?IdRequerimiento=" + row.IdRequerimiento);
                    $('#purchase-order').dialog('open').dialog('center').dialog('setTitle', 'Orden de compra requerimiento No.' + row.IdRequerimiento);
//                    window.open("php/GeneratePDF.php?IdRequerimiento=" + row.IdRequerimiento);
                }
            }
            function addComment() {
                var row = $('#tt').datagrid('getSelected');
//                alert(row.Autorizado);
                if (row) {
                    $('#dlg-comment').dialog('open').dialog('center').dialog('setTitle', 'Agregar Comentario');
                    $('#fm-comment').form('load', row);
                    url = '../php/saveTimeLine.php?IdRequerimiento=' + row.IdRequerimiento;
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
                                '<td style="border:2px;padding-right:10px">' +
                                '<p><label>Costo</label> ' + rowData.Costo + '</p>' +
                                '<p><label></label> </p>' +
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
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->                
        <script src="../libs/bootstrap/moment/moment.js" type="text/javascript"></script>
        <script src="../libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../libs/bootstrap/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="../libs/bootstrap/moment/locale/es.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#FechaEstSIES').datetimepicker({
                    format: "DD-MM-YYYY HH:mm",
                    locale: 'es',
                    daysOfWeekDisabled: [0, 6],
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                    minDate: new Date()
                });
                $('#FechaEstCliente').datetimepicker({
                    format: "DD-MM-YYYY HH:mm",
                    locale: 'es',
                    daysOfWeekDisabled: [0, 6],
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                    minDate: new Date()
                });
                $('#FechaTerminado').datetimepicker({
                    format: "DD-MM-YYYY HH:mm",
                    locale: 'es',
                    daysOfWeekDisabled: [0, 6],
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                    minDate: new Date()
                });
                $('#FechaPruebas').datetimepicker({
                    format: "DD-MM-YYYY HH:mm",
                    locale: 'es',
                    daysOfWeekDisabled: [0, 6],
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                    minDate: new Date()
                });
                $('#FechaProduccion').datetimepicker({
                    format: "DD-MM-YYYY HH:mm",
                    locale: 'es',
                    daysOfWeekDisabled: [0, 6],
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                    minDate: new Date()
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