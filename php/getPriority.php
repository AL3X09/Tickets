<?php

$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Prioridad/PrioridadConsultarTodo",
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
        "postman-token: e11fc007-d112-48f2-9161-1ea965c4ba6a"
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