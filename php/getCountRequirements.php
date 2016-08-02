<?php
/*
*lo que hago en este archivo primero invoco la api de todo los usuarios 
*posterior a esto le enlazo la api de de todos los estados, continuando con la api que realiza un conteo de 
*de estados por cada usuario la api se llama  api/TotalesTabla/TotalesViewRequerimientos
*asi enlazar lo retornado por la api y trabajarlos a mi manera
*y con el archivo lleno un combogrig por ajax
*POSTDATA: tambien si desea puede solicitar una api pero debe ser mue especifico 
*/
require './functions.php';

session_start();
$classFunction = new functions(); // Clase funciones
$config = parse_ini_file('../config/config.ini');
$cantidad = array();
//$totalAsignados = 0;
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Usuarios/UsuariosConsultarTodo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 0c6e107c-5f77-a01c-d99a-35eaeff833ba"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
    //armo un array con todos los usuarios
    $arrayU = json_decode($response, true);
    $usuarios = array(); //array que va a contener los usuarios
    
    foreach ($arrayU as $key => $value) {
        $row = array(
            
            "IdUsuario" => $value["IdUsuario"],
            "Nombre" => $value["Nombre"],
            "nEspecialidad" => $value["nEspecialidad"],
        );
        $IdUsuario = $row['IdUsuario'];
        array_push($usuarios, $row);
    }
//print_r($rowU);

    /**********INVOCO API DE ESTADOS************/
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Estados/EstadosConsultarTodo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: db232231-ce17-3046-08ba-29ed9b664268"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$arrayE = json_decode($response, true);
$estados = array();
if ($err) {
    echo "cURL Error #:" . $err;
} else {

    foreach ($arrayE as $key => $value) {

        $row = array(
            "IdEstado" => $value["IdEstado"],
            "Nombre" => $value["Nombre"],
        );
        $IdEstado = $row["IdEstado"];
        array_push($estados, $row);

    }
    //print_r($estados);
}
            /****************************FIN API ESTADOS*******************************/
        $contUsers = count($usuarios);
        $contEstate = count($estados); 
        /*************invoco api donde cuento los estados de cada usuario*******************/ 
             //columna usuarios  
            for ($i=0; $i < $contUsers ; $i++) { 
            $IdUsuario = array_column($usuarios, 'IdUsuario');
            $nUsuario = array_column($usuarios, 'Nombre');
            $nEspecialidad = array_column($usuarios, 'nEspecialidad');
                 //columna estados
                for ($j=0; $j < $contEstate; $j++) {
                    $IdEstado = array_column($estados, 'IdEstado');
                    $nEstado = array_column($estados, 'Nombre');

        $consulta="{
                    \r\n  \"IdEstado\":".$IdEstado[$j].",
                    \r\n  \"IdResponsable\": ".$IdUsuario[$i]."    
                    }";
                    $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_PORT => "8016",
            CURLOPT_URL => $config['server']."/api/TotalesTabla/TotalesViewRequerimientos",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $consulta,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 535ce963-52cb-a6b3-15f7-b02c94e3bf7b"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $arrayC = json_decode($response, true);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
                    $contEstados[]=$arrayC; //array donde almaceno los valores obtenidos de la api de conteo de cantidad de estados
                    $keys[] =$nEstado[$j]; //array donde almaceno los valores de los nombres de los estados
                    
                    //calculo el total de requerimientos asignados
                     foreach ($contEstados as $values ) {
                            $totalAsignados=array_sum($contEstados); 
                        }
                    $valor['ASIGNADO']=$totalAsignados;     //asigno el total a la variable con el key asignado
                    
                    if ($keys[$j] ==='PENDIENTE' or $keys[$j] ==='PRUEBAS') {
                        $valor[$keys[$j]] = $contEstados[$j]; //array final que me envia los concatenados el nombre de los estados y su valor
                    }
                    

            }       // fin else

        }           // fin ciclo for j

        //array donde armo json a enviar
        $row = array(
                    "IdUsuario" =>$IdUsuario[$i],
                    "nUsuario" =>$nUsuario[$i],                    
                    "nEspecialidad" =>$nEspecialidad[$i],
              );
        //echo"<br>";
        //echo $totalAsignados;
        $totalAsignados = 0;
        $row = array_merge($row, $valor); //mesclo los valores
        array_push($cantidad,$row); //inserto en un array vacio los valores mexclados para continuar trabajando  
        
        $contEstados=array();   //vacio los array para que no aya repeticion de datos
        $keys=array();          //vacio los array para que no aya repeticion de datos

    }     //fin ciclo for i
    
     echo json_encode($cantidad, true);
     $cantidad=array();     //vacio los array para que no aya repeticion de datos

}