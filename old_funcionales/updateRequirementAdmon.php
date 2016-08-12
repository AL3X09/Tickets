<?php
//TODO SI SE UTILIZA ESTE ARCHIVO PARA ACTUALIZAR EL REQUERIMIENTO EJECUTA ACCIONES PARA API LINEA DE TIEMPO 
require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
//ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$emailUser = htmlspecialchars($_SESSION["emailUser"]); //"bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);         // recivo el nombre del usuario logueado

$idRequirement = intval($_REQUEST["id"]);
$idresponsable = intval($_REQUEST["IdResponsable"]);
$emailResponsable=$_REQUEST["emailResp"];
$status = intval($_REQUEST["IdEstado"]);
$cost = round(str_replace(".", "", $_REQUEST["Costo"]));
$accepted = (htmlspecialchars($_REQUEST["Autorizado"]) == "on" ) ? 1 : 0;
$orderBuy = (htmlspecialchars($_REQUEST["OrdenCompra"]) == "on" ) ? 1 : 0;
$acceptedBy = intval($idUser);
$dateSies = date_format(new DateTime($_REQUEST["FechaEstSIES"]), 'Y-m-d H:i:s');
$dateClient = date_format(new DateTime($_REQUEST["FechaEstCliente"]), 'Y-m-d H:i:s');
$finishDate = date_format(new DateTime($_REQUEST["FechaTerminado"]), 'Y-m-d H:i:s');
$productionDate = date_format(new DateTime($_REQUEST["FechaProduccion"]), 'Y-m-d H:i:s');
$testDate = date_format(new DateTime($_REQUEST["FechaPruebas"]), 'Y-m-d H:i:s');
$ticket = intval($_REQUEST["ticket"]);
//variables para la tarea
$Requerimiento = htmlspecialchars($_REQUEST["Requerimiento"]);         // recivo el requerimiento para armar la tarea
//variables para la linea de tiempo 
$descripcion = 'se asigna a '.$_REQUEST["respRequeriment"].' como responsable para el requerimiento: #'.$ticket.'';   // armo mensaje para la liena de tiempo
 
//echo $descripcion;
//echo "{\r\n  \"IdRequerimiento\": $idRequirement,"
// . "\r\n  \"IdEstado\": $status,"
// . "\r\n  \"FechaEstSIES\": \"$dateSies\","
// . "\r\n  \"FechaEstCliente\": \"$dateClient\","
// . "\r\n  \"FechaTerminado\": \"$finishDate\","
// . "\r\n  \"IdResponsable\": $idresponsable,"
// . "\r\n  \"OrdenCompra\": $orderBuy,"
// . "\r\n  \"Costo\": $cost,"
// . "\r\n  \"Autorizado\": $accepted,"
// . "\r\n  \"UAutoriza\": $acceptedBy,"
// . "\r\n  \"Usuario\": $idUser,"
// . "\r\n  \"DirIp\": \"$ipUser\"\r\n}";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoActualizarGestionAdmon",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdEstado\": $status,\r\n  \"FechaEstSIES\": \"$dateSies\",\r\n  \"FechaEstCliente\": \"$dateClient\",\r\n  \"FechaPruebas\": \"$testDate\",\r\n  \"FechaProduccion\": \"$productionDate\",\r\n  \"FechaTerminado\": \"$finishDate\",\r\n  \"IdResponsable\": $idresponsable,\r\n   \"OrdenCompra\": $orderBuy,\r\n  \"Costo\": $cost,\r\n  \"Autorizado\": $accepted,\r\n  \"UAutoriza\": $acceptedBy,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 6f4283fe-d187-465c-696a-354619f4ab88"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;

    /***********************CURL LINEA DE TIEMPO**********************************/
    //TODO OJO ARREGLAR Y DETERMINAR QUE TIPO DE LINEA DE TIEMPO SE DETERMINA PARA ESE REQUICITO
     $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8016",
        CURLOPT_URL => $config['server'] . "/api/LineaTiempo/LineaTiempoInsertar",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": 1,\r\n  \"Descripcion\": \"$descripcion\",\r\n  \"EmailTo\": \"$emailResponsable\",\r\n  \"Tarea\": 1,\r\n  \"IdTarea\": $responseTarea,\r\n  \"UsuarioCreacion\": $idUser\r\n}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: f72e1c43-295c-4896-882b-e9d5dc9fd8f7"
        ),
    ));

    $responseTimeLine = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    /*************************FIN CURL LINEA DE TIEMPO***************************************/

    $result = (is_numeric($response)) ? "Requerimiento #$ticket actualizado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);

    /**************************INICIA ENVIAR CORREO*****************************************/
            $contenido='
                <table>                    
                    <tr>
                    <td>Se le asigno el requerimineto #'.$ticket.'</td>
                    </tr>
                    <tr>
                    <td>tarea con fecha estimada para termniacion '.$dateSies.'</td>
                    </tr>
                    <tr>
                    <td>Para mas información consulte el modulo de requerimientos</td>
                    </tr>
                </table>
                    ';
            $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
            // Codificación UTF8. Obligado utilizarlo en aplicaciones en Español
            $correo->CharSet = 'UTF-8';
            //Tell PHPMailer to use SMTP
            $correo->IsSMTP();
            //configuracion del ssl
            $correo->SMTPOptions = array(
            'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Whether to use SMTP authentication
            $correo->SMTPAuth = $config["smtpauth"] ;
            //Set the encryption system to use - ssl (deprecated) or tls
            $correo->SMTPSecure = $config["smtpsecure"];
            //Set the hostname of the mail server
            $correo->Host = $config["host"];
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $correo->Port = $config["port"];
            //Username to use for SMTP authentication - use full email address for gmail
            $correo->Username = $config["username"];
            //Password to use for SMTP authentication
            $correo->Password = $config["password"];
            //Usamos el SetFrom para decirle al script quien envia el correo
            $correo->SetFrom($emailUser, $nameUser);        
            //Usamos el AddAddress para agregar un destinatario
            $correo->AddAddress($emailResponsable); 
            //Ponemos el asunto del mensaje
            $correo->Subject = "Asignacion de ticket #$ticket ";
            /*
            * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
            * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
            * Si deseamos enviarlo en texto plano, haremos lo siguiente:
            * $correo->IsHTML(false);
            * $correo->Body = "Mi mensaje en Texto Plano";
            */
            $correo->MsgHTML("<strong>".$contenido."</strong>");
            //Enviamos el correo
            $correo->Send();
            /* correos no salen por cuenta smtp//Enviamos el correo
            if(!$correo->Send()) {
            echo "Hubo un error al enviar el correo: " . $correo->ErrorInfo;
            }
            */
    /**************************FIN ENVIAR CORREO *****************************************/
} 
