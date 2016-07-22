<?php
//global $response;
$curl = curl_init();
$config = parse_ini_file('../config/config.ini');
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server']."/api/Roles/RolesConsultarUno?idRol=".$_REQUEST["id"],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{\r\n  \"IdPrioridad\": 4,\r\n  \"Nombre\": \"algo\",\r\n  \"Usuario\": 123465,\r\n  \"DirIp\": \"111111\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: d2ff96c5-6ed4-7d82-b3bd-8a56a0d16e5f"
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