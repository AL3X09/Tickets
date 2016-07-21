<?php

require './functions.php';
session_start();

$config = parse_ini_file('config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$idStatus = intval($_REQUEST["IdEstado"]);
$startDevelopmentDate = date_format(new DateTime($_REQUEST["FechaInicioDesarrollo"]), "Y-m-d H:i:s");
$idRequirement = intval($_REQUEST["id"]);
$ticket = intval($_REQUEST["ticket"]);
//echo "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdEstado\": $idStatus,\r\n  \"FechaInicioDesarrollo\": \"$startDevelopmentDate\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => "http://server:8016/api/Requerimiento/RequerimientoActualizarProgramador",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdEstado\": $idStatus,\r\n  \"FechaInicioDesarrollo\": \"$startDevelopmentDate\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 94a04a01-7c09-3daf-401d-0d13c3bb9efa"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Requerimiento #$ticket actualizado con exito " : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}