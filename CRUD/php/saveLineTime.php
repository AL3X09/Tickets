<?php

require './functions.php';
session_start();
$config = parse_ini_file('config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$requirement = htmlspecialchars($_REQUEST["requirement"]);
$idTypeLineTime = intval($_REQUEST["IdTipoLineaTiempo"]);
$description = htmlspecialchars($_REQUEST["Descripcion"]);
$email = htmlspecialchars($_REQUEST["Email"]);
$homework = 0;
$idHomework = null;

//echo "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": $idLineType,\r\n  \"Descripcion\": \"$description\",\r\n  \"EmailTo\": \"$email\",\r\n  \"Tarea\": $homework,\r\n  \"IdTarea\": $idHomework,\r\n  \"UsuarioCreacion\": $idUser\r\n}";

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
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": $idLineType,\r\n  \"Descripcion\": \"$description\",\r\n  \"EmailTo\": \"$email\",\r\n  \"Tarea\": $homework,\r\n  \"IdTarea\": $idHomework,\r\n  \"UsuarioCreacion\": $idUser\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: f72e1c43-295c-4896-882b-e9d5dc9fd8f7"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
     $result = (is_numeric($response)) ? "Comentario ingresado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}