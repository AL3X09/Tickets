<?php

$config = parse_ini_file('../config/config.ini');
require './functions.php';
session_start();
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$idApp = intval($_REQUEST["id"]);
$nameApp = htmlspecialchars($_REQUEST["Nombre"]);

$curl = curl_init();


curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Aplicativos/AplicativosActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdAplicativo\": " . $idApp . ",\r\n  \"Nombre\": \"" . $nameApp . "\",\r\n  \"Usuario\": " . $idUser . ",\r\n  \"DirIp\": \"" . $ipUser . "\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 16cde622-256b-45bd-325f-d86a5ee67025"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Aplicacion actualizada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}