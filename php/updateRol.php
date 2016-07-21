<?php

require './functions.php';
session_start();

$classFunction = new functions(); // Clase funciones
$config = parse_ini_file('../config/config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$idRol = htmlspecialchars($_REQUEST["id"]);
$nameTypeLineTime = htmlspecialchars($_REQUEST["Nombre"]);


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Roles/RolesActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRol\": " . $idRol . ",\r\n  \"Nombre\": \"" . $nameTypeLineTime . "\",\r\n  \"Usuario\": " . $idUser . ",\r\n  \"DirIp\": \"" . $ipUser . "\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 30806878-0f39-0d39-65c5-97080023f511"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Rol actualizado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}