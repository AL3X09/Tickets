<?php
$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config["server"]."/api/LineaTiempo/LineaTiempoConsultarTodo",
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
        "postman-token: 770d8ddd-3c15-3c62-f35a-7ef4aced192f"
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