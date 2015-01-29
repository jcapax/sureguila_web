<?
	include("../conexion.php");
	$link = conexion();

	$idDevice = $_POST['idDevice'];
	$latitud  = $_POST['latitud'];
	$longitud = $_POST['longitud'];
	
	mysql_query("INSERT INTO gps(idDevice, latitud, longitud, fechaHora)
			VALUES('$idDevice', '$latitud', '$longitud', now())");

	echo 1;
?>