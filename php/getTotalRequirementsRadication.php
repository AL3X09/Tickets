<?php

require './functions.php';
session_start();

$classFunction = new functions(); // Clase funciones

$config = parse_ini_file('../config/config.ini');
$page = (isset($_POST['page'])) ? intval($_POST['page']) : 0;
$rows = (isset($_POST['rows'])) ? intval($_POST['rows']) : 10;
$idCompany = (isset($_SESSION['empresa']) && !is_null($_SESSION['empresa'])) ? $_SESSION['empresa'] : "null";
$idRadicatorUser = (isset($_REQUEST['IdUsuarioRadica']) && !is_null($_REQUEST['IdUsuarioRadica'])) ? $_REQUEST['IdUsuarioRadica'] : "null";
$idTypeRequirement = (isset($_REQUEST['IdTipoRequerimiento']) && !is_null($_REQUEST['IdTipoRequerimiento'])) ? $_REQUEST['IdTipoRequerimiento'] : "null";
$idApp = (isset($_REQUEST['IdAplicativo']) && !is_null($_REQUEST['IdAplicativo'])) ? $_REQUEST['IdAplicativo'] : "null";
$idModule = (isset($_REQUEST['IdModulo']) && !is_null($_REQUEST['IdModulo'])) ? $_REQUEST['IdModulo'] : "null";
$idPriority = (isset($_REQUEST['IdPrioridad']) && !is_null($_REQUEST['IdPrioridad'])) ? $_REQUEST['IdPrioridad'] : "null";
$idResponsable = (isset($_REQUEST['IdUsuarioResponsable']) && !is_null($_REQUEST['IdResponsable'])) ? $_REQUEST['IdResponsable'] : "null";

$offset;

if ($page == 1 || $page == 0) {
    $offset = 0;
} else {
    $offset = ($rows * $page) - $rows;
}

$values = "{\r\n  \"offset\": " . intval($offset) . ","
        . "\r\n  \"rows\": " . intval($rows) . ","
        . "\r\n  \"IdEmpresaRadica\": $idCompany,"
        . "\r\n  \"IdUsuarioRadica\": $idRadicatorUser,"
        . "\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,"
        . "\r\n  \"IdAplicativo\": $idApp,"
        . "\r\n  \"IdModulo\":  $idModule,"
        . "\r\n  \"IdPrioridad\": $idPriority,"
        . "\r\n  \"IdResponsable\":$idResponsable\r\n}";
//echo $values;


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config["server"] . "/api/TotalesTabla/TotalesViewRequerimientos",
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
        "postman-token: dfc7651b-8c5d-3538-8ac7-9fd47b64d9f5"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}