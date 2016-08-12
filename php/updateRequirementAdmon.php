<?php
/*
*TENER EN CUENTA
*ESTE ARCHVIO CONTIENE DOS APIS UNA QUE ACTUALIZA EL REQUERIMIENTO CON LOS DATOS DEL ASMINISTRADOR
*OTRA ES LA QUE INSERTA EN LA LINEA DE TIEMPO
*ADEMAS QUE SE DEFINE LA LINEA DE TIEMPO CON EL ID 4 ES DECIR "ACTUALIZACION DEL REQUERIMIENTO"
*
*/
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
$finishDate = (isset($_REQUEST["FechaTerminado"])) ? date_format(new DateTime($_REQUEST["FechaTerminado"]), 'Y-m-d H:i:s') : null ;
$testDate = (isset($_REQUEST["FechaPruebas"])) ? date_format(new DateTime($_REQUEST["FechaPruebas"]), 'Y-m-d H:i:s') : null ;
$productionDate = (isset($_REQUEST["FechaProduccion"])) ? date_format(new DateTime($_REQUEST["FechaProduccion"]), 'Y-m-d H:i:s') : null ;

$cantidad= intval($_REQUEST["cantidad"]);
$unidad= htmlspecialchars($_REQUEST["unidad"]);
$unidad = substr($unidad, 0, 2);                    //substraigo los dos primeros caracteres
$unidad = strtoupper($unidad);                      //los vuelvo a mayusculas
//valido si la unidad son minutos
$unidad = ($unidad=="MI") ? $unidad = strtoupper($unidad[1]) : $unidad = strtoupper($unidad[0]) ; 
/*
--- calculo fechas dependiendo de la unidad del acuerdo de servicio---
*/
//si unidad es igual a años
if ($unidad=="A") {
    //echo "años";
}
//sino si unidad es igual a meses
elseif ($unidad=="M") {
    # code...
}
//sino si unidad es igual a dias
elseif ($unidad=="D") {
    # code...
}
//sino si unidad es igual a horas
elseif ($unidad=="H") {
    # code...
}
//sino si unidad es igual a minutos
elseif ($unidad=="I") {
    //echo "minutos";
}
//sino si unidad es igual a segundos
elseif ($unidad=="S") {
    # code...
}
/*
--- fin calculo fechas dependiendo de la unidad del acuerdo de servicio---
*/

$ticket = intval($_REQUEST["ticket"]);
//variables para la linea de tiempo 
$descripcion = 'se asigna a '.$_REQUEST["respRequeriment"].' como responsable para el requerimiento';   // armo mensaje para la liena de tiempo
 
//echo $descripcion;
/*
echo "{\r\n  \"IdRequerimiento\": $idRequirement,"
 . "\r\n  \"IdEstado\": $status,"
 . "\r\n  \"FechaEstSIES\": \"$dateSies\","
 . "\r\n  \"FechaEstCliente\": \"$dateClient\","
 . "\r\n  \"FechaTerminado\": \"$finishDate\","
 . "\r\n  \"IdResponsable\": $idresponsable,"
 . "\r\n  \"OrdenCompra\": $orderBuy,"
 . "\r\n  \"Costo\": $cost,"
 . "\r\n  \"Autorizado\": $accepted,"
 . "\r\n  \"UAutoriza\": $acceptedBy,"
 . "\r\n  \"Usuario\": $idUser,"
 . "\r\n  \"DirIp\": \"$ipUser\"\r\n}";
*/

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
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
    // TIPO DE LINEA DE TIEMPO SE DETERMINA PARA ESE REQUICITO ES ACTUALIZACION
     $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_PORT => $config['server'],
        CURLOPT_URL => $config['server'] . "/api/LineaTiempo/LineaTiempoInsertar",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": 4,\r\n  \"Descripcion\": \"$descripcion\",\r\n  \"EmailTo\": \"$emailResponsable\",\r\n  \"Tarea\": 1,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}",
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
            $correo->Subject = "Asignacion de requerimiento #$ticket ";
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