<?php
/*se inutiliza el archivo ya que por relacion y estandar no se puede 
/*modificar una aclaracion
*/
require './functions.php';
ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$IdAclaraciones=htmlspecialchars($_REQUEST['id']);
$IdRequerimiento=htmlspecialchars($_REQUEST['idRequerimiento']);
$Aclaracion=htmlspecialchars($_REQUEST['Aclaracion']);
//armo varible a actualizar
$actualizar="{
    \r\n  \"IdAclaraciones\": $IdAclaraciones,
    \r\n  \"IdRequerimiento\": $IdRequerimiento,
    \r\n  \"Aclaracion\": \"$Aclaracion\",
    \r\n  \"IdUsuarioAclara\": $idUser,
    \r\n  \"DirIp\": \"$ipUser\"\r\n
    }";
var_dump ($actualizar);
/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config["server"] . "/api/Aclaraciones/AclaracionesActualizar",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $actualizar ,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: b56e9ad7-8687-aac9-85e9-15e1bdc7801f"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    //echo $response;
    $result = (is_numeric($response)) ? "Aclaracion actualizada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}