<?php
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => $config['server'],
  CURLOPT_URL => $config['server'] . "/api/Especialidades/EspecialidadesConsultarTodo",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 58002142-eadf-9f2b-59f7-b2aa1e3aa99d"
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