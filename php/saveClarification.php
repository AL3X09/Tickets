<?php

require './functions.php';
session_start();

$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$clarification = htmlspecialchars($_REQUEST["Aclaracion"]);
//$idRequirement = htmlspecialchars($_REQUEST["id"]);
$idRequirement = (isset($_REQUEST["id"])) ? htmlspecialchars($_REQUEST["id"]) : htmlspecialchars($_REQUEST["nRequerimiento"]) ;

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config["server"] . "/api/Aclaraciones/AclaracionesInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"Aclaracion\": \"$clarification\",\r\n  \"IdUsuarioAclara\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 5b2f0ba4-593c-14e8-13c3-004d122ff4ed"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {

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
        CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": 1,\r\n  \"Descripcion\": \"$clarification\",\r\n  \"EmailTo\": \"$email\",\r\n  \"Tarea\": 1,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: f72e1c43-295c-4896-882b-e9d5dc9fd8f7"
        ),
    ));

    $responseTimeLine = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

//    echo $response;
    $result = (is_numeric($response)&&  is_numeric($responseTimeLine)) ? "Aclaracion ingresada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}