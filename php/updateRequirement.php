<?php

//ini_set("display_errors", "on");
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$idRequirement = intval($_REQUEST["id"]);
$ticketNumber = htmlspecialchars($_SESSION["empresa"] . $_REQUEST["IdTipoRequerimiento"]);
$idCompany = htmlspecialchars($_SESSION["empresa"]);
$idTypeRequirement = intval($_REQUEST["IdTipoRequerimiento"]);
$idApp = intval($_REQUEST["IdAplicativo"]);
$idModule = intval($_REQUEST["IdModulo"]);
$idPriority = intval($_REQUEST["IdPrioridad"]);
$requirement = htmlspecialchars($_REQUEST["Requerimiento"]);
$objective = htmlspecialchars($_REQUEST["Objetivo"]);
$orderBuy = htmlspecialchars($_REQUEST["OrdenCompra"]);
$cost = 0; //htmlspecialchars($_REQUEST["Costo"]);
$accepted = false;
$acceptedBy = null;
$dateSies = date_format(new DateTime($_REQUEST["FechaEstSIES"]), 'Y-m-d');
$dateClient = date_format(new DateTime($_REQUEST["FechaEstCliente"]), 'Y-m-d H:i:s');
$idStatus = intval($_REQUEST["IdEstado"]);
$responsble = intval($_REQUEST["IdResponsable"]);
$finishDate = date_format(new DateTime($_REQUEST["FechaTerminado"]), 'Y-m-d H:i:s');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"Ticket\": \"$ticketNumber\",\r\n  \"IdEstado\": $idStatus,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"IdPrioridad\": $idPriority,\r\n  \"Requerimiento\": \"$requirement\",\r\n  \"Objetivo\": \"$objective\",\r\n  \"Costo\": $cost,\r\n  \"FechaEstSIES\": \"$dateSies\",\r\n  \"FechaEstCliente\": \"$dateClient\",\r\n  \"FechaTerminado\": \"$finishDate\",\r\n  \"IdResponsable\": $responsable,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 65081559-eef3-71f4-535e-4f93225993a4"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if (is_numeric($response)) {

        /*
         * ------------------------- SE AGREGA A LA LINEA DE TIEMPO ------------------
         * author: Bryan Muñoz
         */

        $paramRequest = "{"
                . "\r\n  \"IdRequerimiento\": $idRequirement,"
                . "\r\n  \"IdTipoLineaTiempo\": 4,"
                . "\r\n  \"Descripcion\": \"Se actualiza el requerimiento\","
                . "\r\n  \"EmailTo\": \"$emailTo\","
                . "\r\n  \"Tarea\": false,"
                . "\r\n  \"IdTarea\": null,"
                . "\r\n  \"UsuarioCreacion\": $idUser\r\n"
                . "}";
        echo $paramRequest;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => $config['server'],
            CURLOPT_URL => $config["server"] . "/api/LineaTiempo/LineaTiempoInsertar",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $paramRequest,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 98631f5b-94d2-e7dd-e5f7-d7213819498a"
            ),
        ));

        $responseTimeLine = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        /*
         * ---------------- SE TERMINA DE AGREGAR A LA LINEA DE TIEMPO -----------------------
         *  
         */
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//            echo $responseTimeLine;
            $result = "Requerimiento #$ticket actualizado con exito ";
        }
    } else {
        $result = "Ha ocurrido un error, por favor intente nuevamente. $response";
    }
}