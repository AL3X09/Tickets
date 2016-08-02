<?php

require './functions.php';
session_start();

$classFunction = new functions(); // Clase funciones

$config = parse_ini_file('../config/config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$idRequirement = $_REQUEST["IdRequerimiento"];
$idTypeLineTime = $_REQUEST["IdTipoLineaTiempo"];
//$idTypeLineTime = $_REQUEST["IdTipoLineaTiempo"];
$description = $_REQUEST["Descripcion"] ;
//$description = $_REQUEST["Descripcion"];
$emailTo = "bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
//$paramRequest = "{\r\n  \"IdRequerimiento\": 1,\r\n  \"IdTipoLineaTiempo\": 1,\r\n  \"Descripcion\": \"se asigna valores al responsable\",\r\n  \"EmailTo\": \"$emailTo\",\r\n  \"Tarea\": false,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}";
$paramRequest = "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": $idTypeLineTime,\r\n  \"Descripcion\": \"$description\",\r\n  \"EmailTo\": \"$emailTo\",\r\n  \"Tarea\": false,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}";
//echo $paramRequest;

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/LineaTiempo/LineaTiempoInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $paramRequest,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 98631f5b-94d2-e7dd-e5f7-d7213819498a"
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