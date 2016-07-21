<?php

//ini_set("display_errors", "on");
class functions {

    private $method;

    public function __construct() {
        $this->method = $_POST["method"];
        switch ($this->method) {
            case 1:
                self::session();
                break;
            case 2:
                self::menu();
                break;
            default:
                break;
        }
    }

    private function session() {
        if (!isset($_SESSION["id-user"]) && empty($_SESSION["id-user"])) {
            $response = "<script>alert('falso');</script>";
        } else {
            $response = "<script>alert('true');</script>";
        }
        echo $response;
    }

    private function menu() {

        switch ($_SESSION["rol-user"]) {
            case 1:
                $data = "'menu':{'menu1':'INICIO'}, 'user-name':'" . $_SESSION["user"] . "'";
                $response = "true";
                $message = "'algo'";
                echo self::builJson($data, $response, $message);
                break;

            default:
                echo "<script>location.href='../index.html';</script>";
                break;
        }
    }

    private function buildJson($data, $response, $message) {
        $json = "{'response':'" . $response . "', 'message':'" . $message . "', 'data':'" . $data . "'}";
        return $json;
    }

    public function getRealIp() {

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public function getJson($url) {

        $response = file($url); //$this->get_include_contents($url);
        //include $url;
        echo $response;
//        $response = json_encode($response, true);
//        $jsonDecoded = json_decode($response, true);
//        return $jsonDecoded;
    }

    public function get_include_contents($filename) {
        if (is_file($filename)) {
            ob_start();
            include $filename;
            return ob_get_clean();
        }
        return false;
    }

    public function getValue($array, $id, $url) {

        foreach ($array as $key => $value) {// Se recorre cada registro del arreglo
            //echo $keyValue . "=>". $value1."<br>";        
            if ($key == $id) {
                $json = $this->getJson($url . "?id=" . $array[$id]);
            }
        }
        return $json;
    }

    public function validateRequestParameter($item, $parameterUrl) {
        if (isset($_REQUEST[$parameterUrl]) && is_numeric($_REQUEST[$parameterUrl])) {
            return "\r\n  \"$item\": $_REQUEST[$parameterUrl]";
        } else if (isset($_REQUEST[$parameterUrl]) && is_string($_REQUEST[$parameterUrl])) {
            return "\r\n  \"$item\": \"$_REQUEST[$parameterUrl]\"";
        }
        return "\r\n  \"$item\": null";
    }

    public function concatComma($value) {
        if (!is_null($value)) {
            return $value . ",";
        }
        return $value;
    }    

    public function validateDateUpdate($item, $idStatus) {
        if (is_numeric($idStatus) && !is_null($idStatus) && !empty($idStatus)) {
            return "\r\n  \"$item\": \"" . date_format(getdate(), 'Y-m-d H:i:s') . "\"";
        } else {
            return "\r\n  \"$item\": null";
        }
    }

}

new functions();
