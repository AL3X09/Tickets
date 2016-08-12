<?php

/*
/*el numero del ticket es el consecutivo de la base de datos
/*se deja comentariada la variable $ticketNumber ya que despues se puede
/*modificar segun los requerimientos del gerente del aplicativo
/*se definio que el usuario solo puede editar el requerimiento siempre y cuando el estado sea pendiente
*/ 

//ini_set("display_errors", "on");
require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';

session_start();

$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());

    /*
    *
    *api o curl que consulta el total de las tabla y lo uso para armar el consecutivo del requerimiento es decir el campo ticket
    */
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => $config['server'],
        CURLOPT_URL => $config['server'] . "/api/TotalesTabla/TotalesTabla",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"Tabla\": \"Requerimiento\"\r\n}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 8475849c-e905-5ad6-fcc7-b6a664e3c451"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        $ticketNumber = $response;
        $ticketNumber = $ticketNumber+1;
        }
    /*
    *
    *fin api donde se arma el consecutivo
    */
    
//$ticketNumber = htmlspecialchars($_SESSION["empresa"] . $_REQUEST["IdTipoRequerimiento"]);
$ticketNumber = $ticketNumber;
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
$dateSies = null;       //date_format(new DateTime($_REQUEST["FechaEstSIES"]), 'Y-m-d');
$dateClient = null;     //date_format(new DateTime($_REQUEST["FechaEstCliente"]), 'Y-m-d H:i:s');
$idStatus = 1;
//echo "{\r\n  \"Ticket\": \"$ticketNumber\",\r\n  \"IdEmpresaRadica\": $idCompany,\r\n  \"IdEstado\": $idStatus,\r\n  \"IdUsuarioRadica\": $idUser,\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,\r\n  \"IdAplicativo\": $idApp,\r\n  \"IdModulo\": $idModule,\r\n  \"IdPrioridad\": $idPriority,\r\n  \"Requerimiento\": \"$requirement\",\r\n  \"Objetivo\": \"$objective\",\r\n  \"OrdenCompra\": false,\r\n  \"Costo\": null,\r\n  \"Autorizado\": false,\r\n  \"UAutoriza\": null,\r\n  \"FechaEstSIES\":null,\r\n  \"FechaEstCliente\":null,\r\n  \"FechaTerminado\": null,\n  \"FechaInicioDesarrollo\": null,\r\n  \"IdResponsable\": null,\r\n  \"FechaPruebas\": null,\r\n  \"FechaProduccion\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
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
         * ---------------- SE INICIA ENVIO CORREO NOTIFICANDO A ADMINISTRADORES -----------------------
         *  
         */
         
          $contenido='
                <table>                    
                    <tr>
                        <td>Se creo nuevo requerimiento con #'.$ticketNumber.'</td>
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
                            $correo->AddAddress($EmailAdmin[$i]);
                            $emailsTo.=$EmailAdmin[$i].',';
                        }
                       
                        //Ponemos el asunto del mensaje
                        $correo->Subject = "Se crea un nuevo requerimiento ";
                        
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
                                /*
                                * ------------------------- SE AGREGA A LA LINEA DE TIEMPO ------------------
                                * author: Bryan Muñoz
                                */

                                $paramRequest = "{"
                                        . "\r\n  \"IdRequerimiento\": $response,"
                                        . "\r\n  \"IdTipoLineaTiempo\": 2,"
                                        . "\r\n  \"Descripcion\": \"Se crea un nuevo requerimiento $requirement\","
                                        . "\r\n  \"EmailTo\": \"$emailsTo\","
                                        . "\r\n  \"Tarea\": false,"
                                        . "\r\n  \"IdTarea\": null,"
                                        . "\r\n  \"UsuarioCreacion\": $idUser\r\n"
                                        . "}";
                                
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
                                
                                
                                if ($err) {
                                    echo "cURL Error #:" . $err;
                                } else {
//            echo $responseTimeLine;
                                    $result = "Requerimiento ingresado con exito ";
                                }  
                                /*
                                * ---------------- SE TERMINA DE AGREGAR A LA LINEA DE TIEMPO -----------------------
                                *  
                                */

                        }
                        /*
                        * ---------------- SE FINALIZA ENVIO CORREO NOTIFICACNDO A ADMINISTRADORES -----------------------
                        *  
                        */ 
        }/*fin si responde numericamente*/
        else {
              $result = "Ha ocurrido un error, por favor intente nuevamente. $response";
              }
    echo json_encode($result); 
      

}

