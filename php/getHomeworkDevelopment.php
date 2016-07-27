<?php
$config = parse_ini_file('../config/config.ini');
include './functions.php';
session_start();
$classFunctions = new functions();
$idUser = $_SESSION["id"];
$ipUser = $classFunctions->getRealIp();
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server'] . "/api/Tareas/TareasConsultarFiltros",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n    \"IdResponsableTarea\": ".$idUser.",\n  }",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 9e62730f-edc3-7ef2-a9ac-5953c1fe4b1b"
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
    }else {                     //si es un array se trabaja  
    $result = array();          // variable donde se re asigna array
    $row;                       //variable donde con la que se trabaja el array 
    foreach ($array as $key => $value) {
        //re asigno valores
        $row = array(
            "IdTarea" => $value["IdTarea"],
            "Nombre" => $value["Nombre"],
            "IdResponsableTarea" => $value["IdResponsableTarea"],
            "nResponsableTarea" => $value["nResponsableTarea"],
            "FechaInicioTarea" => substr($value["FechaInicioTarea"],0,10),  // con substr controlo las cadenas a mostar
            "FechaFinEstimadoTarea" => substr($value["FechaFinEstimadoTarea"],0,10),
            "FechaFinTarea" => substr($value["FechaFinTarea"],0,10),
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
}