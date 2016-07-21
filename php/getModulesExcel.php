<?php

//ini_set("display_errors", "on");
include './functions.php';
session_start();
$classFunctions = new functions();
$idUser = $_SESSION["id"];
$ipUser = $classFunctions->getRealIp();
$config = parse_ini_file('config.ini');

$values = "{" . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdModulo", "idModule")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("Nombre", "name")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("IdAplicativo", "app")) . "\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Modulos/ModulosConsultarFiltros",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $values,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 79feca21-acb4-7804-d81f-49fd56ee58c2"
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