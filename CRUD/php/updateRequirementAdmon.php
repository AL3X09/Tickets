<?php

require './functions.php';
//ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$idRequirement = intval($_REQUEST["id"]);
$responsble = intval($_REQUEST["IdResponsable"]);
$status = intval($_REQUEST["IdEstado"]);
$cost = round(str_replace(".", "", $_REQUEST["Costo"]));
$accepted = (htmlspecialchars($_REQUEST["Autorizado"]) == "on" ) ? 1 : 0;
$orderBuy = (htmlspecialchars($_REQUEST["OrdenCompra"]) == "on" ) ? 1 : 0;
$acceptedBy = intval($idUser);
$dateSies = date_format(new DateTime($_REQUEST["FechaEstSIES"]), 'Y-m-d H:i:s');
$dateClient = date_format(new DateTime($_REQUEST["FechaEstCliente"]), 'Y-m-d H:i:s');
$finishDate = date_format(new DateTime($_REQUEST["FechaTerminado"]), 'Y-m-d H:i:s');
$productionDate = date_format(new DateTime($_REQUEST["FechaProduccion"]), 'Y-m-d H:i:s');
$testDate = date_format(new DateTime($_REQUEST["FechaPruebas"]), 'Y-m-d H:i:s');
$ticket = intval($_REQUEST["ticket"]);


//echo "{\r\n  \"IdRequerimiento\": $idRequirement,"
// . "\r\n  \"IdEstado\": $status,"
// . "\r\n  \"FechaEstSIES\": \"$dateSies\","
// . "\r\n  \"FechaEstCliente\": \"$dateClient\","
// . "\r\n  \"FechaTerminado\": \"$finishDate\","
// . "\r\n  \"IdResponsable\": $responsble,"
// . "\r\n  \"OrdenCompra\": $orderBuy,"
// . "\r\n  \"Costo\": $cost,"
// . "\r\n  \"Autorizado\": $accepted,"
// . "\r\n  \"UAutoriza\": $acceptedBy,"
// . "\r\n  \"Usuario\": $idUser,"
// . "\r\n  \"DirIp\": \"$ipUser\"\r\n}";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoActualizarGestionAdmon",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdEstado\": $status,\r\n  \"FechaEstSIES\": \"$dateSies\",\r\n  \"FechaEstCliente\": \"$dateClient\",\r\n  \"FechaPruebas\": \"$testDate\",\r\n  \"FechaProduccion\": \"$productionDate\",\r\n  \"FechaTerminado\": \"$finishDate\",\r\n  \"IdResponsable\": $responsble,\r\n   \"OrdenCompra\": $orderBuy,\r\n  \"Costo\": $cost,\r\n  \"Autorizado\": $accepted,\r\n  \"UAutoriza\": $acceptedBy,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 6f4283fe-d187-465c-696a-354619f4ab88"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Requerimiento #$ticket actualizado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}