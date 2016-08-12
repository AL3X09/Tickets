<?php

//TODO poner joins
require './functions.php';
ini_set("display_errors", "on");
session_start();

$classFunction = new functions(); // Clase funciones
$config = parse_ini_file('../config/config.ini');
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$identificationNumber = intval($_REQUEST["IdUsuario"]); //antiguo valor id usuario
$password = hash('sha256', '34a@$#aA9823$' . $_POST["Pass"]);
$nameUser = htmlspecialchars($_REQUEST["Nombre"]);
$idCompany = intval($_REQUEST["IdEmpresa"]);
$idCity = intval($_REQUEST["IdCiudad"]);
$idRol = intval($_REQUEST["IdRol"]);

$state = intval($_REQUEST["Estado"]);
$idUpdateUser = intval($_REQUEST["id"]); //valor nuevo id usuario
$mail = htmlspecialchars($_REQUEST["Email"]);
$cellphone = htmlspecialchars($_REQUEST["Celular"]);
$ipAddress = htmlspecialchars($_REQUEST["DirIp"]);
$picture = $_FILES['foto']['name'];
$idEspecialidad=$_REQUEST["IdEspecialidad"];
$FechaCambio = NULL;
$FechaUltimoIngreso = NULL;
$UsuarioSies = NULL;
$PasswordReset = NULL;
$directorio_destino="../files/user_files";    //ruta de directorio para almacenar las imagenes
//variable con parametros a actualizar
$actualizar= "{
\r\n  \"IdUsuario\": $identificationNumber,
\r\n  \"Nombre\": \"$nameUser\",
\r\n  \"Contrasena\": \"$password\",
\r\n  \"Email\": \"$mail\",
\r\n  \"Celular\": \"$cellphone\",
\r\n  \"Fotografia\": \"$directorio_destino/$picture\",
\r\n  \"IdRol\": $idRol,
\r\n  \"IdEmpresa\":$idCompany,
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
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Usuarios/UsuariosActualizar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $actualizar,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: b69b3469-f44e-ab2a-525d-6e235b941594"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;

/**trabajo la foto del usuario**/
//comprobamos si ha ocurrido un error en el archivo.
if ( !isset($_FILES['foto']) || $_FILES['foto']["error"] > 0){
	echo "ha ocurrido un error cargando la foto";
} else {                        
    
    //valido que exista el destino si no exite lo creo
    if (!file_exists($directorio_destino)) {
        mkdir($directorio_destino);
    }
	//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
	//y que el tamano del archivo no exceda los 16MB
	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	$limite_kb = 16384;

	if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_kb * 1024){

		//este es el archivo temporal
		$imagen_temporal  = $_FILES['foto']['tmp_name'];
		//valido si se mueve el archivo
        if (copy($imagen_temporal, $directorio_destino.'/'.$picture))
            {
            //respondo mensaje
            $result = (is_numeric($response)) ? "Usuario actualizado con exito" : "Ha ocurrido un error, por favor intente nuevamente. $response";
           
            }else{
                 $result=die("Error al subir!");
            }
	} else {
		 $result= "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
	}
}
/**fin de trabajo de la foto del usuario*/

    echo json_encode($result);
}


/* old
 "{\r\n  \"IdUsuario\": $idUpdateUser,\r\n  \"Nombre\": \"$nameUser\",\r\n  \"Password\": \"$password\",\r\n  \"IdEmpresa\": $idCompany,\r\n  \"IdCiudad\": $idCity,\r\n  \"IdRol\": $idRol,\r\n  \"Activo\": $state,\r\n  \"Email\": \"$mail\",\r\n  \"Celular\": \"$cellphone\",\r\n  \"DirIp\": \"$ipAddress\",\r\n  \"Fotografia\": \"$picture\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIpUsuario\": \"$ipUser\"\r\n}",    