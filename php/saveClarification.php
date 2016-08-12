<?php
//TODO 
require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
//ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions();                                       // Clase funciones
$emailsTo='';                                                           //variable mantiene concatenacion de un multiples correos se agrega al inicio ya que nulea demas variables
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$emailUser = htmlspecialchars($_SESSION["emailUser"]);                  // recivo el email de usuario logueado
$nameUser = htmlspecialchars_decode($_SESSION["nameUser"]);             // recivo el nombre del usuario logueado
$clarification = htmlspecialchars($_REQUEST["Aclaracion"]);             //recivo la aclaracion
//$clarification = ($_REQUEST["Aclaracion"]) ? htmlspecialchars($_REQUEST["Aclaracion"]) : $_REQUEST["Aclaraciones"] ;
//$idRequirement = htmlspecialchars($_REQUEST["id"]);
$idRequirement = (isset($_REQUEST["id"])) ? htmlspecialchars($_REQUEST["id"]) : htmlspecialchars($_REQUEST["idRequerimiento"]) ;
$ticket = htmlspecialchars($_REQUEST["ticket"]);                         // recivo el codigo/numero del ticket
$mailto=$_REQUEST["mailto"];                                //recibo los emails de destino
$contEmali = count($mailto);                                //variable que permite contar la cantidad de emails q llegan

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

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config["server"] . "/api/Aclaraciones/AclaracionesInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n  \"Aclaracion\": \"$clarification\",\r\n  \"IdUsuarioAclara\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 5b2f0ba4-593c-14e8-13c3-004d122ff4ed"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {


    /*
    *
    ************************INICIA ENVIAR CORREO****************************************
    */
            $contenido='
                <table>                    
                    <tr>
                        <td>'.$clarification.'</td>
                    </tr>
                </table>
                    ';
            //valido si la aclaracion llega de la vista de ticketrequerimentradication para enviar un solo correo
            //if (isset($_POST['isRadication'])) {
                        
                /*
                *
                * CONSULTO LA API DE USUARIOS EXCEL Y OBTENER LOS CORREOS DE LOS ADMINISTRADORES DEL APLICATIVO**
                */

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

                    /*
                    *
                    ********************************************CORREO******************************************************
                    */
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
                        for ($i=0; $i <$contEmali ; $i++) { 
                            $correo->AddAddress($mailto[$i]);
                            //$emailsTo.=$EmailAdmin[$i].',';
                            //array_push($emailsTo,$EmailAdmin[$i].',');
                        }
                       
                        //Ponemos el asunto del mensaje
                        $correo->Subject = "Aclaracion para ticket #$ticket ";
                        
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
                    }   //fin else api usuariosexcel 
            //} 
            /*
            *
            ************************FIN ENVIAR CORREO ****************************************
            */

            /*
            *
            *****************INICIO AGREGA/ENVIAR  A LA LINEA DE TIEMPO***************************
            */
            //valido si llegan los emails del administrador 
            /* if ($emailsTo!='') {
                 $emailTo=$emailsTo;
                 
             } else {
                 $emailTo=null;
             }*/
             //armo variable a consumir por la api linea de tiempo 
             $contLineaTiemp="{
                     \r\n  \"IdRequerimiento\": $idRequirement,
                     \r\n  \"IdTipoLineaTiempo\": 1,
                     \r\n  \"Descripcion\": \"$clarification\",
                     \r\n  \"EmailTo\": \"$emailTo\",
                     \r\n  \"Tarea\": 0,
                     \r\n  \"IdTarea\": null,
                     \r\n  \"UsuarioCreacion\": $idUser\r\n
                     }";
        
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
                CURLOPT_POSTFIELDS => $contLineaTiemp,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: f72e1c43-295c-4896-882b-e9d5dc9fd8f7"
                ),
            ));

            $responseTimeLine = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            /*if ($err) {
            echo "cURL Error #:" . $err;
            } else {
                */
            //    echo $response;
            
            $result = (is_numeric($response)&&  is_numeric($responseTimeLine)) ? "Aclaracion ingresada con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
            echo json_encode($result);
            /*
            *
            ************************FIN AGREGAR A LA LINEA DE TIEMPO****************************************
            */
            
} // fin else api save clarfication