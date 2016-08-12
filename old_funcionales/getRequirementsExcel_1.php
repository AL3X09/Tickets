<?php

include './functions.php';
$classFunctions = new functions();
$values = "{"
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdRequerimiento", "requirement"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("Ticket", "ticket"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdEmpresaRadica", "IdEmpresaRadica"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdUsuarioRadica", "IdUsuarioRadica"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("FechaRadicado", "FechaRadicado"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdTipoRequerimiento", "IdTipoRequerimiento"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdAplicativo", "IdAplicativo"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdModulo", "IdModulo"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdPrioridad", "IdPrioridad"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("Requerimiento", "Requerimiento"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("Objetivo", "Objetivo"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("OrdenCompra", "OrdenCompra"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("Costo", "Costo"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("Autorizado", "Autorizado"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("UAutoriza", "UAutoriza"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("FechaDesde", "FechaDesde"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("FechaHasta", "FechaHasta"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdEstado", "IdEstado"))
        . $classFunctions->concatComma($classFunctions->validateRequestParameter("IdResponsable", "IdResponsable"))
        . $classFunctions->validateRequestParameter("FechaInicioDesarrollo", "FechaInicioDesarrollo")
        . "}";
//$IdRequerimiento=$_REQUEST["requirement"];

session_start();
$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Requerimiento/RequerimientoConsultarFiltrosExcel",
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
        "postman-token: 8fb84a2e-f75a-0811-4e82-36a1bc73f52b"
    ),
));

$responseRequerimiento = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
//print_r($responseRequerimiento);

$arrayR = json_decode($responseRequerimiento, true);

//valido si no un array
if (!is_array($arrayR)) {
    var_dump($arrayR);
}else {                         //si es un array se trabaja  
    $result = array();          // variable donde se re asigna array
    $row;                       //variable donde con la que se trabaja el array 
    foreach ($arrayR as $key => $value) {
        //re asigno valores
        $row = array(
            "IdTarea" => $value["IdTarea"],
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
    print_r($result);
}
   //echo json_encode($result, true);     //envio jason a vista para trabajarlo

/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => $config['server'] . "/api/TipoLineaTiempo/TipoLineaTiempoConsultarFiltrosExcel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n \"IdRequerimiento\": $IdRequerimiento,\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: e478eb8e-28f2-f81d-e8a4-3e947bc33588"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
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
            //quitar false de la vista de campos fechas
            "FechaFinTarea" => $value["FechaFinTarea"] == ("") ? "" : substr($value["FechaFinTarea"],0,10),
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
}