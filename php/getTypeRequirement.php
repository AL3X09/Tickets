<?php

$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server']."/api/TipoRequerimiento/TipoRequerimientoConsultarTodo",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 2ab90cc7-a938-f07c-c96d-2985ed8ed06d"
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