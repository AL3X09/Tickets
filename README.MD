APLICATIVO REQUERIMIENTOS 
==========
### Version 
0.0.1
### Introduccion
Esta aplicación permite mantener los historicos de requerimientos.
### Base de datos 
requerimientos
### TODO
* master de menu
* pendiente por hablar la estructura para generar el ticket
* 

Estructura
--------------------
modulo estructurado de la siguente forma:

    APLICAIÓN
        |-libs
        |-config
        |-php
        |-views
        |-img
        |-js
        |-css
        |-files
              |-apliction
              |-user_files

### Para Manejo de Errores
>ini_set("display_errors", "on");
### Configuraciones
incluir a los archivos las siguentes lineas de configuraciones 
>require './functions.php';

>session_start();

>$config = parse_ini_file('../config/config.ini');

>$classFunction = new functions(); // Clase funciones

>$idUser = intval($_SESSION["id"]);

>$ipUser = htmlspecialchars($classFunction->getRealIp());

>$config["server"] .
    
    * example 
    $config["server"] . "/api/Aclaraciones/AclaracionesInsertar"
### Ejemplo capturar y trabajar el retorno de la api en un Array 
con el siguiente codigo se controla la respuesta de la api y luego se trabaja con un array asociativo para
posteriormente imprimirla en la vista .

```sh
//echo $response;
/*
//tener en cuenta si hay modificaciones en las consultas y no aparecen los datos es porque
//estan en un array asosiativo para tener mejor control de este.
*/
    //envio respuesta a un array 
    $array = json_decode($response, true);
    //valido si no es un array
    if (!is_array($array)) {
    var_dump($array);
    }else {                         //si es un array se trabaja 
    $result = array();              // variable donde se re asigna array
    $row;                           //variable donde con la que se trabaja el array 
    foreach ($array as $key => $value) {
        //re asigno valores
        $row = array(
            "IdAclaraciones" => $value["IdAclaraciones"],
            "IdRequerimiento" => $value["IdRequerimiento"],
            "Aclaracion" => $value["Aclaracion"],
            "FechaCreacion" => str_replace("T"," ",substr($value["FechaCreacion"],0,16)), // con str_ireplace remplael valor t que me retona la consulta y substr controlo las cadenas a mostar
            "IdUsuarioAclara" =>$value["IdUsuarioAclara"],
        );
        array_push($result, $row);      //agrego valores de row en result 
    }
       //var_dump($result);
   echo json_encode($result, true);     //envio jason a vista para trabajarlo
  }
```
### ® derechos reservados
[SIES](http://www.siesweb.com/)
--------------------
Manuales y gias 
--------------------
* [manual de git colaborativo](http://www.cristalab.com/tutoriales/como-colaborar-en-un-proyecto-en-github-c112327l/)
* [Edcicion del README](http://dillinger.io/)