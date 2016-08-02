<?php
$config = parse_ini_file('../config/config.ini');
include './functions.php';
session_start();
$classFunctions = new functions();
$idUser = $_SESSION["id"];
$ipUser = $classFunctions->getRealIp();
$idHomework = intval($_REQUEST["id"]);
$nameHomework = htmlspecialchars($_REQUEST["nombre"]);
$idResponsableTarea = htmlspecialchars($_REQUEST["idresponsable"]);
$FechaFinEstimadoTarea = htmlspecialchars($_REQUEST["fechaestimado"]);
$FechaFinEstimadoTarea = substr($FechaFinEstimadoTarea,0,10);
$FechaInicioTarea=htmlspecialchars($_REQUEST["FechaInicioTarea"]);
//valida que ya se haya iniciado la tarea antes de finalizarla
if (($FechaInicioTarea !== "false") and ($FechaInicioTarea !== "") ) {
   
$FechaInicioTarea = substr($FechaInicioTarea,0,10);
$dateEndtHomework = date("Y-m-d");

 $updateFechaEnd="{
     \r\n  \"IdTarea\": $idHomework,
     \r\n  \"Nombre\": \"$nameHomework\",
     \r\n  \"IdResponsableTarea\": $idResponsableTarea,
     \r\n  \"FechaInicioTarea\": \"$FechaInicioTarea\",
     \r\n  \"FechaFinEstimadoTarea\": \"$FechaFinEstimadoTarea\",
     \r\n  \"FechaFinTarea\":\"$dateEndtHomework\",
     \r\n  \"Usuario\": $idUser,
     \r\n  \"DirIp\": \"$ipUser\"\r\n
     }";
if (condition) {
    # code...
}
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Tareas/TareasActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $updateFechaEnd,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: cbb87fcf-3afe-662c-6044-dab108438ec9"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
    $result = (is_numeric($response)) ? "Tarea finalizada" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
    
}
}   //fin valida si exite un inicio de tarea
else {
    $result = "Inicie primero la tarea";
    echo json_encode($result);
}