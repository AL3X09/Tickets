<?php
require './functions.php';
ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$id=$_REQUEST['id'];
$idAplicativo=$_REQUEST['IdAplicativo'];
$idModulo=$_REQUEST['IdModulo'];
$requerimiento=$_REQUEST['Requerimiento'];
$respuesta=$_REQUEST['Respuesta'];
//armo variable  con datos a enviar
$actualizar="{
    \r\n  \"idFAQ\": ".$id.",
    \r\n  \"IdAplicativo\": ".$idAplicativo.",
    \r\n  \"IdModulo\": ".$idModulo.",
    \r\n  \"Requerimiento\": \"".$requerimiento."\",
    \r\n  \"respuesta\": \"".$respuesta."\",
    \r\n  \"Usuario\": ".$idUser.",
    \r\n  \"DirIp\": \"".$ipUser."\"\r\n
    }";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server'] . "/api/FAQ/FAQActualizar",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $actualizar,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: ecf9bda7-c919-6715-38d9-50e91f14e22e"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $result = (is_numeric($response)) ? "FAQ actualizada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
  echo json_encode($result);
}