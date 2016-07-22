<?php

require './functions.php';
session_start();

$classFunction = new functions(); // Clase funciones

$config = parse_ini_file('../config/config.ini');
$page = (isset($_POST['page'])) ? intval($_POST['page']) : 0;
$rows = (isset($_POST['rows'])) ? intval($_POST['rows']) : 10;
$idCompany = (isset($_REQUEST['IdEmpresaRadica']) && !is_null($_REQUEST['IdEmpresaRadica'])) ? $_REQUEST['IdEmpresaRadica'] : "null";
$idRadicatorUser = (isset($_REQUEST['IdUsuarioRadica']) && !is_null($_REQUEST['IdUsuarioRadica'])) ? $_REQUEST['IdUsuarioRadica'] : "null";
$idTypeRequirement = (isset($_REQUEST['IdTipoRequerimiento']) && !is_null($_REQUEST['IdTipoRequerimiento'])) ? $_REQUEST['IdTipoRequerimiento'] : "null";
$idApp = (isset($_REQUEST['IdAplicativo']) && !is_null($_REQUEST['IdAplicativo'])) ? $_REQUEST['IdAplicativo'] : "null";
$idModule = (isset($_REQUEST['IdModulo']) && !is_null($_REQUEST['IdModulo'])) ? $_REQUEST['IdModulo'] : "null";
$idPriority = (isset($_REQUEST['IdPrioridad']) && !is_null($_REQUEST['IdPrioridad'])) ? $_REQUEST['IdPrioridad'] : "null";
$idResponsable = (isset($_SESSION['id']) && !is_null($_SESSION['id'])) ? $_SESSION['id'] : "null";

$offset;

if ($page == 1 || $page == 0) {
    $offset = 0;
} else {
    $offset = ($rows * $page) - $rows;
}
//ini_set("display_errors", "on");
$values = "{\r\n  \"offset\": " . intval($offset) . ","
        . "\r\n  \"rows\": " . intval($rows) . ","
        . "\r\n  \"IdEmpresaRadica\": $idCompany,"
        . "\r\n  \"IdUsuarioRadica\": $idRadicatorUser,"
        . "\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,"
        . "\r\n  \"IdAplicativo\": $idApp,"
        . "\r\n  \"IdModulo\":  $idModule,"
        . "\r\n  \"IdPrioridad\": $idPriority,"
        . "\r\n  \"IdResponsable\":$idResponsable\r\n}";




$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $config['server'] . "/api/SPRequerimientos/SPRequerimientosConsultar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $values,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: cde243ef-e4f4-dd9d-8a16-8ac7c9b39106"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$array = json_decode($response, true);
$result = array();
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    foreach ($array as $key => $value) {
        $radicationDate = date_format(new DateTime($value["FechaRadicado"]), "d-m-Y H:i");
        $siesDate = date_format(new DateTime($value["FechaEstSIES"]), "d-m-Y H:i");
        $clientDate = date_format(new DateTime($value["FechaEstCliente"]), "d-m-Y H:i");
        $finishDate = date_format(new DateTime($value["FechaTerminado"]), "d-m-Y H:i");
        $testDate = date_format(new DateTime($value["FechaPruebas"]), "d-m-Y H:i");
        $productionDate = date_format(new DateTime($value["FechaProduccion"]), "d-m-Y H:i");
        $developmentDate = date_format(new DateTime($value["FechaInicioDesarrollo"]), "d-m-Y H:i");

        $row = array(
            "IdRequerimiento" => $value["IdRequerimiento"],
            "Ticket" => $value["Ticket"],
            "IdEmpresaRadica" => $value["IdEmpresaRadica"],
            "nEmpresaRadica" => $value["nEmpresaRadica"],
            "IdUsuarioRadica" => $value["IdUsuarioRadica"],
            "nUsuarioRadica" => $value["nUsuarioRadica"],
            "FechaRadicado" => $radicationDate,
            "IdTipoRequerimiento" => $value["IdTipoRequerimiento"],
            "nTipoRequerimiento" => $value["nTipoRequerimiento"],
            "IdAplicativo" => $value["IdAplicativo"],
            "nAplicativo" => $value["nAplicativo"],
            "IdModulo" => $value["IdModulo"],
            "nModulo" => $value["nModulo"],
            "IdPrioridad" => $value["IdPrioridad"],
            "nPrioridad" => $value["nPrioridad"],
            "Requerimiento" => $value["Requerimiento"],
            "Objetivo" => $value["Objetivo"],
            "valOrdenCompra" => ($value["OrdenCompra"] == true) ? "SI" : "NO",
            "OrdenCompra" => $value["OrdenCompra"],
            "Costo" => number_format($value["Costo"], 2, ',', '.'),
            "valAutorizado" => ($value["Autorizado"] == true) ? "SI" : "NO",
            "Autorizado" => $value["Autorizado"],
            "UAutoriza" => $value["UAutoriza"],
            "nUsuarioAutoriza" => (is_null($value["nUsuarioAutoriza"])) ? "Sin Autorizacion" : $value["nUsuarioAutoriza"],
            "FechaEstSIES" => (is_null($value["FechaEstSIES"])) ? " - " : $siesDate,
            "FechaEstCliente" => (is_null($value["FechaEstCliente"])) ? " - " : $clientDate,
            "FechaTerminado" => (is_null($value["FechaTerminado"])) ? " - " : $finishDate,
            "FechaInicioDesarrollo" => (is_null($value["FechaInicioDesarrollo"])) ? " Sin iniciar " : $developmentDate,
            "FechaPruebas" => (is_null($value["FechaPruebas"])) ? " - " : $testDate,
            "FechaProduccion" => (is_null($value["FechaProduccion"])) ? " - " : $productionDate,
            "IdEstado" => $value["IdEstado"],
            "nEstado" => $value["nEstado"],
            "IdResponsable" => (is_null($value["IdResponsable"])) ? " - " : $value["IdResponsable"],
            "nUsuarioResponsable" => (is_null($value["nUsuarioResponsable"])) ? " - " : $value["nUsuarioResponsable"],
        );

        array_push($result, $row);
        $radicationDate = "";
        $siesDate = "";
        $clientDate = "";
        $finishDate = "";
        $testDate = "";
        $productionDate = "";
    }
    echo json_encode($result, true);
//    echo $response;
}