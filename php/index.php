<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
  	
	<title>Línea de Tiempo</title>
</head>
<body>
	<header>
		<h1>Línea de Tiempo</h1>
	</header>
	<section id="cd-timeline" class="cd-container">    
<?php
require_once("../Code/dbconfig.php");
$SiniestroID = 1;
$sql = "select LineaTiempo.*,TipoLinea.Icono,TipoLinea.Color,Usuarios.Nombre as nUsuario from LineaTiempo";
$sql.= " inner join TipoLinea on (TipoLineaID = LineaTiempo.TipoID)";
$sql.= " inner join Usuarios on (Usuarios.UsuarioID = LineaTiempo.UsuarioID)";
$sql.= " where LineaTiempo.SiniestroID=".$SiniestroID;
echo"holaaaa";
echo $sql;
/*
$stmt = $db_con->prepare($sql);
$stmt->execute();

while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
	{
	$Fecha = $row['Fecha'];
	 //echo date("d-m-Y (H:i:s)", $time);
	 $Ano = date("y",strtotime($row['Fecha']));
	 $Mes = date("M",strtotime($row['Fecha']));
	 $Dia = date("d",strtotime($row['Fecha']));
	$Hora = date("H:i",strtotime($row['Fecha']));
	$Come = $row['Comentario'];
	$class = "cd-timeline-img cd-".$row['Color'];
	//echo $class;
?>
		<div class="cd-timeline-block">
			<div class="<?php echo($class)?>">
				<img src="<?php echo("img/".$row['Icono'])?>" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content">
				<h2><?php echo($row['Titulo'])?></h2>
				<p><?php echo(utf8_decode($Come))?></p>
				<a href="#0" class="cd-read-more">Ver más...</a>
				<span class="cd-date"><?php echo( $Dia."-".$Mes."-".$Ano.",  ".$Hora. "<br />".$row['nUsuario'] )?></span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->
<?php
}
function NombreMes($mes)
{
	}
?>
	</section> <!-- cd-timeline -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>