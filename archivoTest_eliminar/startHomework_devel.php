<?php
/*
*ARCHIVO NO FUNCIONAL
*/
include './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunctions = new functions();
$idUser = $_SESSION["id"];
$ipUser = $classFunctions->getRealIp();
$emailUser = htmlspecialchars($_SESSION["emailUser"]); //"bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);         // recivo el nombre del usuario logueado

$idHomework = intval($_REQUEST["id"]);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config["server"] . "/api/Tareas/TareasConsultarFiltrosExcel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 95e1c63f-94f0-024d-7857-e65e77597a38"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error Tarea #:" . $err;
} else {
  echo $response;
  print_r($response);
}