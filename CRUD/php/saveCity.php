<?php

require './functions.php';
session_start();
$config = parse_ini_file('config.ini');
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nameCity = htmlspecialchars($_REQUEST["Nombre"]);
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_PORT => "8016",
 CURLOPT_URL => $config['server']."/api/Ciudades/CiudadesInsertar",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "{\r\n  \"Nombre\": \"$nameCity\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
 CURLOPT_HTTPHEADER => array(
"cache-control: no-cache",
 "content-type: application/json",
 "postman-token: 1f56b968-d96d-70dc-442e-f3f00513c0fc"
),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Ciudad ingresada con exito." : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}