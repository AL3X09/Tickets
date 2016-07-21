<meta charset='utf-8'>
<?php
//$miFecha = gmmktime(12, 0, 0, 1, 15, 2089);
//echo 'Antes de setlocale strftime devuelve: ' . strftime("%A, %d de %B de %Y", $miFecha) . '<br/>';
//echo 'Antes de setlocale date devuelve: ' . date("l, d-m-Y (H:i:s)", $miFecha) . '<br/>';
//setlocale(LC_TIME, "es_ES");
//echo 'Después de setlocale es_ES date devuelve: ' . date("l, d-m-Y (H:i:s)", $miFecha) . '<br/>';
//echo 'Después de setlocale es_ES strftime devuelve: ' . strftime("%A, %d de %B de %Y", $miFecha) . '<br/>';
//setlocale(LC_TIME, 'es_ES.UTF-8');
//echo 'Después de setlocale es_ES.UTF-8 date devuelve: ' . date("l, d-m-Y (H:i:s)", $miFecha) . '<br/>';
//echo 'Después de setlocale es_ES.UTF-8 strftime devuelve: ' . strftime("%A, %d de %B de %Y", $miFecha) . '<br/>';
//setlocale(LC_TIME, 'de_DE.UTF-8');
//echo 'Después de setlocale de_DE.UTF-8 date devuelve: ' . date("l, d-m-Y (H:i:s)", $miFecha) . '<br/>';
//echo 'Después de setlocale de_DE.UTF-8 strftime devuelve: ' . strftime("%A, %d de %B de %Y", $miFecha) . '<br/>';
//



date_default_timezone_set('America/Bogota'); //puedes cambiar Guayaquil por tu Ciudad
setlocale(LC_TIME, 'spanish');
$fecha = strftime("%A, %d de %B de %Y");
echo date('w, d n Y');

//Formato de salida: Friday, 24 Feb 2012
session_start();
session_destroy();

$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
//Salida: Viernes 24 de Febrero del 2012