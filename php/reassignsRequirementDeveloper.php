<?php

require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
session_start();
//ini_set("display_errors", "on");
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$emailUser = htmlspecialchars($_SESSION["emailUser"]); //"bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);         // recivo el nombre del usuario logueado

$idStatus = intval($_REQUEST["IdEstado"]);
$FechaInicioDesarrollo = ($_REQUEST["FechaInicioDesarrollo"]==" Sin iniciar") ? null : date_format(new DateTime($_REQUEST["FechaInicioDesarrollo"]), "Y-m-d H:i:s") ;
$idRequirement = intval($_REQUEST["id"]);
$ticket = intval($_REQUEST["ticket"]);
$IdResponsable= $_REQUEST["IdResponsable"];                 //id nuevo responsable del requerimiento
$nResponsable= $_REQUEST["respRequeriment"];                //nombre nuevo responsable del requerimiento
$emailResponsable= $_REQUEST["emailResp"];                  //correo nuevo responsable del requerimiento
$descrip= $_REQUEST["Descripcion"];                         //descripicon por la cual se reasigna la nuevo responsable

$paramRequest = "{"
        . "\r\n  \"IdRequerimiento\": $idRequirement,"
        . "\r\n  \"IdEstado\": $idStatus,"
        . "\r\n  \"FechaInicioDesarrollo\": \"$FechaInicioDesarrollo\","
        . "\r\n  \"IdResponsable\": \"$IdResponsable\","        
        . "\r\n  \"Usuario\": $idUser,"
        . "\r\n  \"DirIp\": \"$ipUser\"\r\n"
        . "}";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config["server"] . "/api/Requerimiento/RequerimientoActualizarProgramador",
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
        "postman-token: 94a04a01-7c09-3daf-401d-0d13c3bb9efa"
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
            * ---------------- SE INICIA ENVIO CORREOS -----------------------
            *  
            */
                
                $contenido='
                        <table>                    
                            <tr>
                                <td>Nueva asignacion para el ticket #'.$ticket.'</td>
                            </tr>
                            <tr>
                                <td>Se asigna a '.$nResponsable.' como responsable del requerimiento</td>
                            </tr>
                            <tr>
                                <td>'.$descrip.'</td>
                            </tr>                    
                        </table>
                            ';
                    /*** CONSULTO LA API DE USUARIOS EXCEL Y OBTENER LOS CORREOS DE LOS ADMINISTRADORES DEL APLICATIVO***/

                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                CURLOPT_PORT => $config['server'],
                                CURLOPT_URL => $config['server'] . "/api/Usuarios/UsuariosConsultarFiltrosExcel",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "  {\r\n  \"IdRol\": 1,\r\n}", //se deja siempre el rol del usuario admin 1 es decir es un valor constate
                                CURLOPT_HTTPHEADER => array(
                                    "cache-control: no-cache",
                                    "content-type: application/json",
                                    "postman-token: f0c98dc6-40f1-4797-1174-8233bd4fbde1"
                                ),
                                ));

                                $responseAdmin = curl_exec($curl);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {
                                echo "cURL Error Filtro Usuarios #:" . $err;
                                } else {
                                        $usuarios = array(); //array que va a contener los emails de los usuarios
                                        $arrayU = json_decode($responseAdmin, true);
                                        foreach ($arrayU as $key => $value) {
                                        $row = array(
                                            "IdUsuario" => $value["IdUsuario"],
                                            "Nombre" => $value["Nombre"],
                                            "nEspecialidad" => $value["nEspecialidad"],
                                            "Email" => $value["Email"],
                                        );
                                        array_push($usuarios, $row);
                                        }
                                        $EmailAdmin = array_column($usuarios, 'Email');     //extraigo la columna de email
                                        $contUsers = count($usuarios);                      //variable contar la cantidad de correo recividos de la api                            
                            /*** FIN CONSULTO LA API DE USUARIOS EXCEL Y OBTENER LOS CORREOS DE LOS ADMINISTRADORES DEL APLICATIVO***/

                            /**********************************************CORREO*******************************************************/
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
                                for ($i=0; $i <$contUsers ; $i++) { 
                                    $emailsTo.=$EmailAdmin[$i].',';
                                }
                                    $correo->AddAddress($emailsTo.$emailResponsable);
                            
                                //Ponemos el asunto del mensaje
                                $correo->Subject = "Se asigna requerimientp #".$ticket."";
                                
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
                         }   //fin else curl usuarios

                /*
                * ---------------- SE TERMINA DE ENVIAR CORREOS -----------------------
                *  
                */

                    /*
                    * ------------------------- SE AGREGA A LA LINEA DE TIEMPO ------------------
                    * author: Bryan Muñoz
                    */

                    $paramRequest = "{"
                            . "\r\n  \"IdRequerimiento\": $idRequirement,"
                            . "\r\n  \"IdTipoLineaTiempo\": 3,"
                            . "\r\n  \"Descripcion\": \"se Reasigna a $nResponsable para el requerimiento #$ticket  $descrip\","
                            . "\r\n  \"EmailTo\": \"$emailsTo\","
                            . "\r\n  \"Tarea\": 1,"
                            . "\r\n  \"IdTarea\": null,"
                            . "\r\n  \"UsuarioCreacion\": $idUser\r\n"
                            . "}";
            //        echo $paramRequest;
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
                    * ---------------- FIN AGREGAR A LA LINEA DE TIEMPO -----------------------
                    *  
                    */

                    if ($err) {
                        echo "cURL Error  Linea de Tiempo #:" . $err;
                    } else {

                       $result = (is_numeric($responseTimeLine)) ? "Requerimiento #$ticket asignado con exito " : "Ha ocurrido un error al insertar en la linea de tiempo" ;
                        //$result = "Requerimiento #$ticket asignado con exito ";
                }

    } /*fin si responde numericamente*/ 
    else {
        $result = "Ha ocurrido un error, por favor intente nuevamente. $response";
    }
    echo json_encode($result);

} //fin else si no hay errores al actualizar el requerimiento 