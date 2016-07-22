<?php

require './functions.php';
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones
//ini_set("display_errors", "on");
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
    echo $response;
}

//$jsonDecoded = json_decode($responseUser, true);
//$arrayMenuOptions = array();
//foreach ($jsonDecoded as $key => $value) {// Se rrecorre el arreglo con los registros
//    $arrayCompany = $classFunction->getValue($value,"IdEmpresa", "getCompanyById.php");
//    $arrayCity = $classFunction->getValue($value,"IdCiudad", "getCityById.php");
//    $arrayRol = $classFunction->getValue($value,"IdRol", "getRolById.php");
//    $row = array ("IdUsuario" => $value["IdUsuario"],
//                  "Nombre"=>$value["Nombre"],
//                  "Password"=>$value["Password"],
//                  "IdEmpresa"=>$value["IdEmpresa"],
//                  "NombreEmpresa"=>$arrayCompany[0]["Nombre"],
//                  "IdCiudad"=>$value["IdCiudad"],
//                  "NombreCiudad"=>$arrayCity[0]["Nombre"],
//                  "IdRol"=>$value["IdRol"],
//                  "NombreRol"=>$arrayRol[0]["Nombre"],
//                  "Activo"=>$value["Activo"],
//                  "Email"=>$value["Email"],
//                  "Celular"=>$value["Celular"],
//                  "DirIp"=>$value["DirIp"],
//                  "Fotografia"=>$value["Fotografia"]
//        );
//    array_push($arrayMenuOptions, $row);     
//}
//echo json_encode($arrayMenuOptions,TRUE);
//echo get_class_vars("getRol");