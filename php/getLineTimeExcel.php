<?php

include './functions.php';
$config = parse_ini_file('../config/config.ini');
$classFunctions = new functions();
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