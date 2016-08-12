<?php

require './functions.php';
session_start();

$classFunction = new functions(); // Clase funciones
$config = parse_ini_file('../config/config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nameHomework = htmlspecialchars($_REQUEST["Nombre"]);
$idResponsableHomework = intval($_REQUEST["IdResponsableTarea"]);
$dateEndHomework = date_format(new DateTime($_REQUEST["FechaFinEstimadoTarea"]), 'Y-m-d');
$idHomework = intval($_REQUEST["id"]);
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Tareas/TareasActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n  \"Nombre\": \"$nameHomework\",\r\n  \"IdResponsableTarea\": $idResponsableHomework,\r\n  \"FechaInicioTarea\": null,\r\n  \"FechaFinEstimadoTarea\": \"$dateEndHomework\",\r\n  \"FechaFinTarea\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: cbb87fcf-3afe-662c-6044-dab108438ec9"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Tarea actualizada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}