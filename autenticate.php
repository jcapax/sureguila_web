<?
	include("conexion.php");
	$link = conexion();

	$idDevice = $_POST['idDevice'];
	$patron = $_POST['patron'];
	

	$sql = "SELECT id, patron, promotor, estado FROM dispositivo WHERE id = '$idDevice' AND patron = '$patron' AND estado is true";

	$res = mysql_fetch_array(mysql_query($sql,$link));

	echo $res[patron].$res[id];	
?>
