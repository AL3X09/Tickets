<?php

$config = parse_ini_file('config.ini');
//ini_set("display_errors", "on");
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Empresas/EmpresasConsultarUno?idEmpresa=" . $_REQUEST["id"],
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
        "postman-token: 49cb88a5-af4f-8798-d052-1374731f7bc8"
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