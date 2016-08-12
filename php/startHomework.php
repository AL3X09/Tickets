<?php

include './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunctions = new functions();
$idUser = $_SESSION["id"];
$ipUser = $classFunctions->getRealIp();
$emailUser = htmlspecialchars($_SESSION["emailUser"]); //"bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);         // recivo el nombre del usuario logueado

$idHomework = intval($_REQUEST["id"]);
$nameHomework = htmlspecialchars($_REQUEST["nombre"]);
$idResponsableTarea = htmlspecialchars($_REQUEST["idresponsable"]);
$FechaFinEstimadoTarea = htmlspecialchars($_REQUEST["fechaestimado"]);
$FechaFinEstimadoTarea = substr($FechaFinEstimadoTarea,0,10);
$dateStartHomework = date("Y-m-d");
//echo "{\r\n  \"IdTarea\": $idHomework,\r\n  \"Nombre\": \"$nameHomework\",\r\n  \"IdResponsableTarea\": $idResponsableTarea,\r\n  \"FechaInicioTarea\": \"$dateStartHomework\",\r\n  \"FechaFinEstimadoTarea\": \"$FechaFinEstimadoTarea\",\r\n  \"FechaFinTarea\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}";

//valido si ya se a iniciado la tarea
if (($_POST["FechaInicioTarea"]!="") and ($_POST["FechaInicioTarea"]!="false")) {
    $result ="Error ya habia iniciado la tarea";
    echo json_encode($result);
}else {     //valido no se haya iniciado la tarea
    /*
    *consulto linea de tiempo si no tiene asociacion con el id de la tarea dejo iniciar la tarea
    *pero si tiene asosiacion no dejo iniciar la tarea y envio mensage
    */
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => $config['server'],
        CURLOPT_URL => $config['server'] . "/api/LineaTiempo/LineaTiempoConsultarFiltrosExcel",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: ccc3ff21-7cf5-363e-f8d8-296f318c2cd8"
        ),
        ));

        $responseLT = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error al consultar la linea de tiempo #:" . $err;
        } else {
        $LineTime = array(); //array que va a contener los emails de los usuarios
        $arrayL = json_decode($responseLT, true);
         foreach ($arrayL as $key => $value) {
                  $row = array(
                  "IDLineaTiempo" => $value["IDLineaTiempo"],
                  "IdRequerimiento" => $value["IdRequerimiento"],
                  "IdTarea" => $value["IdTarea"],
                   );
                  array_push($LineTime, $row);
            }

            //valido que la respuesta de la api de linea de tiempos no sea nula
            if(!empty($arrayL))
            {
                $result ="Error tarea asociada a un requerimiento por favor dirijace al modulo de requerimientos para darle inicio";
                echo json_encode($result);                
            }else{
                
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => $config['server'],
                CURLOPT_URL => $config['server'] . "/api/Tareas/TareasActualizar",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n  \"Nombre\": \"$nameHomework\",\r\n  \"IdResponsableTarea\": $idResponsableTarea,\r\n  \"FechaInicioTarea\": \"$dateStartHomework\",\r\n  \"FechaFinEstimadoTarea\": \"$FechaFinEstimadoTarea\",\r\n  \"FechaFinTarea\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
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
                $result = (is_numeric($response)) ? "Tarea iniciada" : "Ha ocurrido un error, por favor intente nuevamente. $response";
                echo json_encode($result);

                /************* INICIO ENVIO CORREO  *********************************/
                $contenido='
                            <table>                                       
                                <tr>
                                    <td>'.$nameHomework.'</td>
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
                                        //$emailsTo.=$EmailAdmin[$i].',';
                                    }
                                
                                    //Ponemos el asunto del mensaje
                                    $correo->Subject = "Se da inico a tarea ";
                                    
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
                                    } 
                                /************* FIN ENVIO CORREO  *********************************/
                     }

            } // fin else valido que la respuesta de la api de linea de tiempos sea nula

        }
    /*
    *fin consulto linea de tiempo si no tiene asociacion dejo iniciar la tarea
    */
}
