<?php

/*
 * Se reciben las varibles de la vista 
 */
$user = $_POST["user"];
$password = hash('sha256', '34a@$#aA9823$' . $_POST["password"]);

$userData = array();
$userData ["user"] = "bryan";
if (!empty($userData) && isset($userData["user"])) {// TODO validar si es un arreglo el que retorna el json 
    if ($password == hash('sha256', '34a@$#aA9823$' . "algo")) {
        session_start();
        $_SESSION["nameUser"] = "Bryan Steven Mu&ntilde;oz";
        $_SESSION["firma"] = "bryan.png";
        $_SESSION["NUsuario"] = $userData["user"];
        $_SESSION["id"] = 1;
        $_SESSION["empresa"] = 2;
        echo "<script>location.href='../home.html';</script>";
    } else {
        echo "<script>alert('Contraseña incorrecta, Por favor intente otra vez.);"
        . "location.href='../index.html';"
        . "</script>";
    }
} else {
    echo "<script>alert('Usuario o contraseña erronea, Por favor intente otra vez o comuniquese con el administrador');"
    . "location.href='../index.html';"
    . "</script>";
}
?>