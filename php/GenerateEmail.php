<?php
require '../libs/phpmailer/PHPMailerAutoload.php';
$ticket='#5215151';
$IdUsuarioRadica= 1;
$contenido='
        <table>
            <tr>
               <td>Nueva aclaracion para el ticket '.$ticket.'</td>
            <tr>
            </tr>
               <td>'.$clarification.'<td>
            </tr>
        </table>
            ';
            $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
            // Codificación UTF8. Obligado utilizarlo en aplicaciones en Español
            $correo->CharSet = 'UTF-8';
            //Tell PHPMailer to use SMTP
            $correo->IsSMTP();
            $correo->SMTPDebug = 2;
            //Ask for HTML-friendly debug output
            $correo->Debugoutput = 'html';
            //configuracion del ssl
            $correo->SMTPOptions = array(
            'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Whether to use SMTP authentication
            $correo->SMTPAuth = true;
            //Set the encryption system to use - ssl (deprecated) or tls
            $correo->SMTPSecure = 'tls';
            //Set the hostname of the mail server
            $correo->Host = 'mail.siesweb.com';
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $correo->Port = 25;
            //Username to use for SMTP authentication - use full email address for gmail
            $correo->Username = "serviciocliente@siesweb.com";
            //Password to use for SMTP authentication
            $correo->Password = "serviciocliente2015";
            //Usamos el SetFrom para decirle al script quien envia el correo
            $correo->SetFrom('serviciocliente@siesweb.com', 'Sies Web'); 
            $correo->Timeout=60;       
            
            //Usamos el AddAddress para agregar un destinatario
            $correo->AddAddress("alexcisas@gmail.com");
            
            //Ponemos el asunto del mensaje
            $correo->Subject = "Mi primero correo con PHPMailer";
            $correo->IsHTML(true);
            /*
            * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
            * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
            * Si deseamos enviarlo en texto plano, haremos lo siguiente:
            * $correo->IsHTML(false);
            * $correo->Body = "Mi mensaje en Texto Plano";
            */
            $correo->MsgHTML("Mi Mensaje en <strong>".$contenido."</strong>");
            
            //Enviamos el correo
            if(!$correo->Send()) {
            echo "Hubo un error: " . $correo->ErrorInfo;
            } else {
            echo "Mensaje enviado con exito.";
            }