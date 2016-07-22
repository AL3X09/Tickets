<?php
require './functions.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$id = $_REQUEST['id'];
$nombre = $_REQUEST['Nombre'];

$curl = curl_init();
$update ="{
    \r\n  \"IdEspecialidad\": ".$id.",
    \r\n  \"Nombre\": \"".$nombre."\",
    \r\n  \"Usuario\": ".$idUser.",
    \r\n  \"DirIp\": \"".$ipUser."\"\r\n
    }";
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => "http://server:8016/api/Especialidades/EspecialidadesActualizar",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $update ,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: da1f2a0d-a79a-9f8d-ab03-ff8eecc91ae8"
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