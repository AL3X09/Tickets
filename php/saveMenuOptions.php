<?php

require './functions.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nameMenuOptions = htmlspecialchars($_REQUEST["Nombre"]);
$form = htmlspecialchars($_REQUEST["Formulario"]);
$idApp = intval($_REQUEST["IdAplicativo"]);
$idApp = htmlspecialchars($_REQUEST["Icono"]);
$idApp = intval($_REQUEST["estado"]);
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/MenuOpciones/MenuOpcionesInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"Nombre\": \"sample string 1\",\r\n  \"Formulario\": \"sample string 2\",\r\n  \"IdPadre\": 1,\r\n  \"Icono\": \"sample string 3\",\r\n  \"Activo\": true,\r\n  \"Usuario\": 1,\r\n  \"DirIp\": \"sample string 4\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: fa49a621-2972-3038-e610-6182bd0ba547"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
     $result = (is_numeric($response)) ? "Opcion ingresado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}