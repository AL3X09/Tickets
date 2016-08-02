<?php

require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$idRequirement = intval($_REQUEST["id"]);
$idTypeRequirement = intval($_REQUEST["IdTipoRequerimiento"]);
$idApp = intval($_REQUEST["IdAplicativo"]);
$idModule = intval($_REQUEST["IdModulo"]);
$ticket = intval($_REQUEST["ticket"]);
//echo "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";
$curl = curl_init();


curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoActualizarCliente",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 9832fa38-3c8a-0364-116b-b10a95fcd882"
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
                . "\r\n  \"IdRequerimiento\": $idRequirement,"
                . "\r\n  \"IdTipoLineaTiempo\": 3,"
                . "\r\n  \"Descripcion\": \"Se actualiza el requerimiento\","
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
            $result = "Requerimiento #$ticket actualizado con exito ";
        }
    } else {
        $result = "Ha ocurrido un error, por favor intente nuevamente. $response";
    }
    echo json_encode($result);
}