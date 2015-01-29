<?

	include("../conexion.php");
	$link = conexion();

	$idCliente = $_POST['idCliente'];

	$sql = "SELECT id, idPrecio, nombreCliente, direccion, nro, tipoLocal FROM cliente WHERE id = '$idCliente'";

	$res = mysql_fetch_array(mysql_query($sql,$link));

	if (mysql_affected_rows() == 0){
		echo 0;
	}
	else{
		echo $res[id].' // '.$res[idPrecio].' // '.$res[nombreCliente].' // '.$res[direccion].' '.$res[nro].' // '.$res[tipoLocal];
	}
?>
