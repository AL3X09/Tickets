<?php

$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Tareas/TareasConsultarTodo",
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
        "postman-token: 7fb6d363-a827-5e5f-2fd9-c040b4bee60d"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
/*
//tener en cuenta si hay modificaciones en las consultas y no aparecen los datos es porque
//estan en un array asosiativo para tener mejor control de este.
*/
    //envio respuesta a un array 
    $array = json_decode($response, true);
    //valido si no un array
    if (!is_array($array)) {
    var_dump($array);
    }else {                         //si es un array se trabaja 
    $result = array();              // variable donde se re asigna array
    $row;                           //variable donde con la que se trabaja el array 
    foreach ($array as $key => $value) {
        //re asigno valores
        $row = array(
            "IdTarea" => $value["IdTarea"],
            "Nombre" => $value["Nombre"],
            "IdResponsableTarea" => $value["IdResponsableTarea"],
            "nResponsableTarea" => $value["nResponsableTarea"],
            "FechaInicioTarea" => substr($value["FechaInicioTarea"],0,10), // con substr controlo las cadenas a mostar
            "FechaFinEstimadoTarea" => substr($value["FechaFinEstimadoTarea"],0,10),
            "FechaFinTarea" => substr($value["FechaFinTarea"],0,10),
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
}