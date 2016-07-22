<?php
require './functions.php';

session_start();
$config = parse_ini_file('../config/config.ini');

$classFunction = new functions(); // Clase funciones
$idUser = intval($_SESSION["id"]);
$ipUser = htmlspecialchars($classFunction->getRealIp());
$id=$_REQUEST['id'];
$idAplicativo=$_REQUEST['idAplicativo'];
$idModulo=$_REQUEST['idModulo'];
$requerimiento=$_REQUEST['Requerimiento'];
$respuesta=$_REQUEST['Respuesta'];
/*
echo $idAplicativo."<br>".
$id."<br>".
$idModulo."<br>".
$requerimiento."<br>".
$respuesta."<br>";
*/


/*TODO conpletar no se encuentra la api */