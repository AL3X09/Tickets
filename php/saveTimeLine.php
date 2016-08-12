<?php

require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
//ini_set("display_errors", "on");
session_start();

$classFunction = new functions(); // Clase funciones

$config = parse_ini_file('../config/config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$emailU = htmlspecialchars($_SESSION["emailUser"]); //"bryan_mnz@hotmail.com"; //$_REQUEST["EmailTo"];
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);         // recivo el nombre del usuario logueado

$idRequirement = $_REQUEST["IdRequerimiento"];
$idTypeLineTime = $_REQUEST["IdTipoLineaTiempo"];
$description = $_REQUEST["Descripcion"];

$nomLineaTiempo = $_REQUEST["nombreLineaTiempo"];           //recibo el  nombre del tipo de linea de tiempo
$ticket = $_REQUEST["ticket"];                              //recibo el  ticket del requerimiento 
$mailto=$_REQUEST["mailto"];                                //recibo los emails de destino
$contEmali = count($mailto);                                //variable que permite contar la cantidad de emails q llegan
//$paramRequest = "{\r\n  \"IdRequerimiento\": 1,\r\n  \"IdTipoLineaTiempo\": 1,\r\n  \"Descripcion\": \"se asigna valores al responsable\",\r\n  \"EmailTo\": \"$emailTo\",\r\n  \"Tarea\": false,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}";

/*
*ciclo que me permite mantener las direcciones de correo para
*posteriormente enviarlas a la linea de tiempo
*/   
for ($i=0; $i <$contEmali ; $i++)
  { 
    $emailTo.=$mailto[$i].',';
  }
/*
*fin ciclo
*/

$paramRequest = "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"IdTipoLineaTiempo\": $idTypeLineTime,\r\n  \"Descripcion\": \"$description\",\r\n  \"EmailTo\": \"$emailTo\",\r\n  \"Tarea\": false,\r\n  \"IdTarea\": null,\r\n  \"UsuarioCreacion\": $idUser\r\n}";

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
    CURLOPT_POSTFIELDS => $paramRequest,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 98631f5b-94d2-e7dd-e5f7-d7213819498a"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
    $result = (is_numeric($response)) ? "comentario ingresado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);

    /**************************INICIA ENVIAR CORREO*****************************************/
    
            $contenido='
                <table>                    
                    <tr>
                    <td>'.$description.'</td>
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
            $correo->SetFrom($emailU, $nameUser);        
            
            //Usamos el AddAddress para agregar un destinatario
            for ($i=0; $i <$contEmali ; $i++) { 
                $correo->AddAddress($mailto[$i]);
            }
            
            //Ponemos el asunto del mensaje
            $correo->Subject = "$nomLineaTiempo para ticket #$ticket ";
            
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
            /*if(!$correo->Send()) {
            echo "Hubo un error al enviar el correo: " . $correo->ErrorInfo;
            }*/
            
    /**************************FIN ENVIAR CORREO *****************************************/
}