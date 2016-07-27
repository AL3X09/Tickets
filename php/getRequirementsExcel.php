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
//echo $values;
<<<<<<< HEAD
session_start();
$config = parse_ini_file('../config/config.ini');
=======
$config = parse_ini_file('config.ini');
>>>>>>> refs/remotes/origin/master
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

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}