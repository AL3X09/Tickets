<?php

//ini_set("display_errors", "on");
require './functions.php';
session_start();
$config = parse_ini_file('config.ini');
$classFunction = new functions(); // Clase funciones
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/MenuOpciones/MenuOpcionesConsultarTodo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRol\": 1,\r\n  \"Nombre\": \"sample string 1\",\r\n  \"Usuario\": 1,\r\n  \"DirIp\": \"sample string 2\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: c46d6972-ea01-82eb-4666-4beb948d3510"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

$jsonDecoded = json_decode($response, true);
$arrayMenuOptions = array();
foreach ($jsonDecoded as $key => $value) {// Se rrecorre el arreglo con los registros
    $arrayModule = $classFunction->getValue($value, "IdPadre", "getModuleById.php");
    $row = array("IdMenuOpcion" => $value["IdMenuOpcion"],
        "Nombre" => $value["Nombre"],
        "Formulario" => $value["Formulario"],
        "IdPadre" => $value["IdPadre"],
        "NombrePadre" => $arrayModule[0]["Nombre"],
        "Icono" => $value["Icono"],
        "Activo" => $value["Activo"]);
    array_push($arrayMenuOptions, $row);
}
echo json_encode($arrayMenuOptions, TRUE);
