<?php
require './functions.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$nombre = $_REQUEST['Nombre'];
$curl = curl_init();

$insert="{
    \r\n  \"Nombre\": \"".$nombre."\",
    \r\n  \"Usuario\": ".$idUser.",
    \r\n  \"DirIp\": \"".$ipUser."\"\r\n
    }";

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => "http://server:8016/api/Especialidades/EspecialidadesInsertar",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $insert ,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 63d6e411-171c-8506-d8f2-bb105d23e441"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $result = (is_numeric($response)) ? "Especialidad ingresada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
  echo json_encode($result);
}