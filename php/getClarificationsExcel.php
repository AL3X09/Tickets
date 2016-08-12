<?php
/*
//tener en cuenta si hay modificaciones en las consultas y no aparecen los datos es porque
//estan en un array asosiativo para tener mejor control de este.
*/
require './functions.php';
ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones

$Requerimiento=intval($_REQUEST["id"]);           //recivo el id de cada requerimiento

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => $config['server'],
  CURLOPT_URL => $config['server'] . "/api/Aclaraciones/AclaracionesConsultarFiltrosExcel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $Requerimiento\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: ee6f650d-81ba-8a87-db81-975dc90ff83c"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  
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
            "nUsuarioAclara" =>$value["nUsuarioAclara"],
            "abierto" => false,
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
}