<?php
//////TODO Aplicar cambios necesarios
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
//ini_set("display_errors", "on");
$consulta="{
    \r\n  \"IdRequerimiento\": 1,
    \r\n  \"Ticket\": \"sample string 1\",
    \r\n  \"IdEmpresaRadica\": 1,
    \r\n  \"IdUsuarioRadica\": 1,
    \r\n  \"FechaRadicado\": \"2016-07-28T09:31:18.1637751-05:00\",
    \r\n  \"IdTipoRequerimiento\": 1,\r\n  \"IdAplicativo\": 1,
    \r\n  \"IdModulo\": 1,\r\n  \"IdPrioridad\": 1,
    \r\n  \"Requerimiento\": \"sample string 2\",
    \r\n  \"Objetivo\": \"sample string 3\",
    \r\n  \"OrdenCompra\": true,\r\n  \"Costo\": 1.0,
    \r\n  \"Autorizado\": true,
    \r\n  \"UAutoriza\": 1,
    \r\n  \"FechaDesde\": \"2016-07-28T09:31:18.1637751-05:00\",
    \r\n  \"FechaHasta\": \"2016-07-28T09:31:18.1637751-05:00\",
    \r\n  \"IdEstado\": 1,
    \r\n  \"IdResponsable\": 1,
    \r\n  \"FechaInicioDesarrollo\": \"2016-07-28T09:31:18.1637751-05:00\"\r\n
    }";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => $config['server'],
  CURLOPT_URL => "http://server:8016/api/TotalesTabla/TotalesViewRequerimientos",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $consulta,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 535ce963-52cb-a6b3-15f7-b02c94e3bf7b"
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