<?php
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$idAplicativo=$_REQUEST['idAplicativo'];
$idModulo=$_REQUEST['idModulo'];
$requerimiento=$_REQUEST['Requerimiento'];
$respuesta=$_REQUEST['Respuesta'];


/*
echo $idAplicativo."<br>".
$idModulo."<br>".
$requerimiento."<br>".
$respuesta."<br>";
*/
$insertar="{
    \r\n  \"IdAplicativo\": ".$idAplicativo.",
    \r\n  \"IdModulo\": ".$idModulo",
    \r\n  \"Requerimiento\": \"".$requerimiento."\",
    \r\n  \"respuesta\": \"".$respuesta."\",
    \r\n  \"Usuario\": ".$idUser",
    \r\n  \"DirIp\": \"".$ipUser"\"\r\n
    }";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => "http://server:8016/api/FAQ/FAQInsertar",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>$insertar ,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: e09295d5-92ef-2163-7ff3-81204d05af84"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $result = (is_numeric($response)) ? "FAQ almacenada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
  echo json_encode($result);
}