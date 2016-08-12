<?php

require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';

session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$emailUser = htmlspecialchars($_SESSION["emailUser"]);                  // recivo el email de usuario logueado
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);             // recivo el nombre del usuario logueado

$nameModule = htmlspecialchars($_REQUEST["Nombre"]);
$idResponsableHomework = htmlspecialchars($_REQUEST["IdResponsableTarea"]);
$dateEndHomework = date_format(new DateTime($_REQUEST["FechaFinEstimadoTarea"]), 'Y-m-d');
$emailResponsable=$_REQUEST('emailResponsable');                        //recivo el email del responsable al que se le asigna la tarea
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Tareas/TareasInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"Nombre\": \"$nameModule\",\r\n  \"IdResponsableTarea\": $idResponsableHomework,\r\n  \"FechaInicioTarea\": null,\r\n  \"FechaFinEstimadoTarea\": \"$dateEndHomework\",\r\n  \"FechaFinTarea\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: b9ea58d5-78da-44f5-9d0d-2558232ef985"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Tarea ingresada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
      /************* INICIO ENVIO CORREO  *********************************/
      $contenido='
                <table>                                       
                    <tr>
                        <td>'.$nameModule.' con fecha estimada para termniacion '.$dateEndHomework.'</td>
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
                        $correo->Subject = "Tiene una tarea Asignada";
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
                        } */
     /************* FIN ENVIO CORREO  *********************************/
}