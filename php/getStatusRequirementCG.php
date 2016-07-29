<?php

$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Estados/EstadosConsultarTodo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: db232231-ce17-3046-08ba-29ed9b664268"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $array = json_decode($response, true);
    $result = array();
    $row = array();
    foreach ($array as $key => $value) {
        $row = array(
            "field" => $value["Nombre"],
            "title" => $value["Nombre"],
            "width" => 80,
            "IdEstado" => $value["IdEstado"],
            "Nombre" => $value["Nombre"]
        );
        array_push($result, $row);
    }
//    var_dump($result);
    echo json_encode(array($result), true);
}