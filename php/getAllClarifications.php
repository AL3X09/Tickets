<?php
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server'] . "/api/Aclaraciones/AclaracionesConsultarTodo",
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
    "postman-token: f52608c6-3ace-596a-7140-935b2be534a4"
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
            "IdAclaraciones" => $value["IdAclaraciones"],
            "IdRequerimiento" => $value["IdRequerimiento"],
            "Aclaracion" => $value["Aclaracion"],
            "FechaCreacion" => str_replace("T"," ",substr($value["FechaCreacion"],0,16)), // con str_ireplace remplael valor t que me retona la consulta y substr controlo las cadenas a mostar
            "IdUsuarioAclara" =>$value["IdUsuarioAclara"],
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
}