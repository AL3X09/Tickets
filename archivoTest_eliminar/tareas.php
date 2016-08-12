<?php
/*
*ARCHIVO NO FUNCIONAL
*/

require './functions.php';
require '../libs/phpmailer/PHPMailerAutoload.php';
session_start();
ini_set("display_errors", "on");
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
echo "<br>";
echo $idUser;
/**
 * clase que mantiene las relaciones entre requerimiento 
 *linea de tiempo y 
 *tareas
 */
class Tareas
{
    
//echo $idUser;
//var $idUser=1;
    
    function __construct()
    {
     if(!empty($idUser)) {
    //echo cargar($_POST['iduser']);
    echo "entra al contruc";
    Tarea();
    } 
        
    }

   
    /*metodo tareas*/
    public function Tarea()
    {
        echo "entra almenos";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_PORT => "8016",
            CURLOPT_URL => $config['server'] . "/api/Tareas/TareasConsultarFiltros",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"IdResponsableTarea\": ".$idUser.",\n  }",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 9e62730f-edc3-7ef2-a9ac-5953c1fe4b1b"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err)
            {
            echo "cURL Error #:" . $err;
            } else {
                //echo $response;
            /*
            //tener en cuenta si hay modificaciones en las consultas y no aparecen los datos es porque
            //estan en un array asosiativo para tener mejor control de este.
            */
                //envio respuesta a un array 
                $array = json_decode($response, true);
                //valido si no un array
                if (!is_array($array)) {
                var_dump($array);
                }else {                     //si es un array se trabaja  
                $result = array();          // variable donde se re asigna array
                $row;                       //variable donde con la que se trabaja el array 
                foreach ($array as $key => $value) {
                    //re asigno valores
                    $row = array(
                        "IdTarea" => $value["IdTarea"],
                        "Nombre" => $value["Nombre"],
                        "IdResponsableTarea" => $value["IdResponsableTarea"],
                        "nResponsableTarea" => $value["nResponsableTarea"],
                        //"FechaInicioTarea" => substr($value["FechaInicioTarea"],0,10),  // con substr controlo las cadenas a mostar
                        "FechaInicioTarea" => $value["FechaInicioTarea"] == ("") ? "" : substr($value["FechaInicioTarea"],0,10),
                        "FechaFinEstimadoTarea" => substr($value["FechaFinEstimadoTarea"],0,10),
                        //"FechaFinTarea" => substr($value["FechaFinTarea"],0,10),
                        //quito false de la vista de campos fechas
                        "FechaFinTarea" => $value["FechaFinTarea"] == ("") ? "" : substr($value["FechaFinTarea"],0,10),
                    );
                    array_push($result, $row);      //agrego valores de row en result 
                }
                //var_dump($result);
            return json_encode($result, true);     //envio jason a vista para trabajarlo
            }
        }
    }

    public function ConsultaLineTime()
    {
        $values = "{" . $classFunctions->concatComma($classFunctions->validateRequestParameter("IDLineaTiempo", "idTimeLine")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("IdRequerimiento", "requirement")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("IdTipoLineaTiempo", "TipeLine")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("Descripcion", "description")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("EmailTo", "emailTo")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("Tarea", "homework")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("IdTarea", "creationDate")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("FechaCreacion", "idUserCreation")) .
        $classFunctions->concatComma($classFunctions->validateRequestParameter("UsuarioCreacion", "idTimeLine")) . "}";

         $curl = curl_init();
        //echo $values;
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8016",
            CURLOPT_URL => $config['server'] . "/api/LineaTiempo/LineaTiempoConsultarFiltros",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $values,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 975b4845-4d83-fbd3-8e65-49267af0b1be"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }


    }

    public function FunctionName($value='')
    {
        # code...
    }
}
