<?php

require './functions.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nameTypeRequirement = htmlspecialchars($_REQUEST["Nombre"]);
$idTypeRequirement = intval($_REQUEST["id"]);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/TipoRequerimiento/TipoRequerimientoActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"Nombre\": \"$nameTypeRequirement\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser`\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 09a83d3e-c902-6622-0788-7095cf17b456"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Tipo de requerimiento actualizado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}