<?php

//ini_set("display_errors", "on");
require './functions.php';

session_start();

$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

$ticketNumber = htmlspecialchars($_SESSION["empresa"] . $_REQUEST["IdTipoRequerimiento"]);
$idCompany = htmlspecialchars($_SESSION["empresa"]);
$idTypeRequirement = intval($_REQUEST["IdTipoRequerimiento"]);
$idApp = intval($_REQUEST["IdAplicativo"]);
$idModule = intval($_REQUEST["IdModulo"]);
$idPriority = intval($_REQUEST["IdPrioridad"]);
$requirement = htmlspecialchars($_REQUEST["Requerimiento"]);
$objective = htmlspecialchars($_REQUEST["Objetivo"]);
$orderBuy = false;
htmlspecialchars($_REQUEST["OrdenCompra"]);
$cost = null;
$accepted = false;
$acceptedBy = null;
$dateSies = null; //date_format(new DateTime($_REQUEST["FechaEstSIES"]), 'Y-m-d');
$dateClient = null; //date_format(new DateTime($_REQUEST["FechaEstCliente"]), 'Y-m-d H:i:s');
$idStatus = 1;
//echo "{\r\n  \"Ticket\": \"$ticketNumber\",\r\n  \"IdEmpresaRadica\": $idCompany,\r\n  \"IdEstado\": $idStatus,\r\n  \"IdUsuarioRadica\": $idUser,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"IdPrioridad\": $idPriority,\r\n  \"Requerimiento\": \"$requirement\",\r\n  \"Objetivo\": \"$objective\",\r\n  \"OrdenCompra\": false,\r\n  \"Costo\": null,\r\n  \"Autorizado\": false,\r\n  \"UAutoriza\": null,\r\n  \"FechaEstSIES\":null,\r\n  \"FechaEstCliente\":null,\r\n  \"FechaTerminado\": null,\n  \"FechaInicioDesarrollo\": null,\r\n  \"IdResponsable\": null,\r\n  \"FechaPruebas\": null,\r\n  \"FechaProduccion\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"Ticket\": \"$ticketNumber\",\r\n  \"IdEmpresaRadica\": $idCompany,\r\n  \"IdEstado\": $idStatus,\r\n  \"IdUsuarioRadica\": $idUser,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"IdPrioridad\": $idPriority,\r\n  \"Requerimiento\": \"$requirement\",\r\n  \"Objetivo\": \"$objective\",\r\n  \"OrdenCompra\": false,\r\n  \"Costo\": null,\r\n  \"Autorizado\": false,\r\n  \"UAutoriza\": null,\r\n  \"FechaEstSIES\":null,\r\n  \"FechaEstCliente\":null,\r\n  \"FechaTerminado\": null,\n  \"FechaInicioDesarrollo\": null,\r\n  \"IdResponsable\": null,\r\n  \"FechaPruebas\": null,\r\n  \"FechaProduccion\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: aea02a3c-9bea-ae17-2fc3-8f698b487923"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    if (is_numeric($response)) {

        /*
         * ------------------------- SE AGREGA A LA LINEA DE TIEMPO ------------------
         * author: Bryan Muñoz
         */

        $paramRequest = "{"
                . "\r\n  \"IdRequerimiento\": $response,"
                . "\r\n  \"IdTipoLineaTiempo\": 2,"
                . "\r\n  \"Descripcion\": \"Se crea en requerimiento\","
                . "\r\n  \"EmailTo\": \"$emailTo\","
                . "\r\n  \"Tarea\": false,"
                . "\r\n  \"IdTarea\": null,"
                . "\r\n  \"UsuarioCreacion\": $idUser\r\n"
                . "}";
        echo $paramRequest;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8016",
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
            $result = "Requerimiento ingresado con exito ";
        }
    } else {
        $result = "Ha ocurrido un error, por favor intente nuevamente. $response";
    }
    echo json_encode($result);
}