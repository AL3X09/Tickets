<?php

require './functions.php';
session_start();
$classFunction = new functions(); // Clase funciones
$config = parse_ini_file('config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nameApp = htmlspecialchars($_REQUEST["Nombre"]);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Aplicativos/AplicativosInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"Nombre\": \"" . $nameApp . "\",\r\n  \"Usuario\": " . $idUser . ",\r\n  \"DirIp\": \"" . $ipUser . "\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: afe57366-a206-3244-c039-3c5ec0c40783"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Aplicacion Registrada con exito." : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}