<?php

//TODO implementar nueva API
require './functions.php';
ini_set("display_errors", "on");
session_start();
$config = parse_ini_file('../config/config.ini');
$classFunction = new functions(); // Clase funciones

$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$identificationNumber = intval($_REQUEST["IdUsuario"]);
$password = hash('sha256', '34a@$#aA9823$' . $_POST["Pass"]);
$nameUser = htmlspecialchars($_REQUEST["Nombre"]);
$idCompany = intval($_REQUEST["IdEmpresa"]);
$idCity = intval($_REQUEST["IdCiudad"]);
$idRol = intval($_REQUEST["IdRol"]);
$state = intval($_REQUEST["Estado"]);
$mail = htmlspecialchars($_REQUEST["Email"]);
$cellphone = htmlspecialchars($_REQUEST["Celular"]);
$ipAddress = htmlspecialchars($_REQUEST["DirIp"]);
$picture = NULL;
$idEspecialidad=$_REQUEST["IdEspecialidad"];
$FechaCambio = NULL;
$FechaUltimoIngreso = NULL;
$UsuarioSies = NULL;
$PasswordReset = NULL;

//variable con parametros a insertar
$insertar="{
\r\n  \"IdUsuario\": $identificationNumber,
\r\n  \"Nombre\": \"$nameUser\",
\r\n  \"Contrasena\": \"$password\",
\r\n  \"Email\": \"$mail\",
\r\n  \"Celular\": \"$cellphone\",
\r\n  \"Fotografia\": \"$picture\",
\r\n  \"IdRol\": $idRol,
\r\n  \"IdEmpresa\": $idCompany,
\r\n  \"IdCiudad\": $idCity,
\r\n  \"Activo\": $state,
\r\n  \"DirIp\": \"$ipAddress\",
\r\n  \"FechaCambio\": \"$FechaCambio\",
\r\n  \"FechaUltimoIngreso\": \"$FechaUltimoIngreso\",
\r\n  \"UsuarioSies\": $UsuarioSies,
\r\n  \"PasswordReset\": $PasswordReset,
\r\n  \"Usuario\": $idUser,
\r\n  \"DirIpUsuario\": \"$ipUser\",
\r\n  \"IdEspecialidad\": $idEspecialidad\r\n
}";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8016",
    CURLOPT_URL => $config['server'] . "/api/Usuarios/UsuariosInsertar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>$insertar,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: f2cddf74-ee6d-c5eb-1a18-124258a5f750"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $result = (is_numeric($response)) ? "Usuario ingresado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
    echo json_encode($result);
}

/*OLD
CURLOPT_POSTFIELDS => "{\r\n  \"IdUsuario\": $identificationNumber,\r\n  \"Nombre\": \"$nameUser\",\r\n  \"Password\": \"$password\",\r\n  \"IdEmpresa\": $idCompany,\r\n  \"IdCiudad\": $idCity,\r\n  \"IdRol\": $idRol,\r\n  \"Activo\": $state,\r\n  \"Email\": \"$mail\",\r\n  \"Celular\": \"$cellphone\",\r\n  \"DirIp\": \"$ipAddress\",\r\n  \"Fotografia\": \"$picture\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIpUsuario\": \"$ipUser\"\r\n}",
    
