<?

	include("conexion.php");
	$link = conexion();

	$idCliente = $_POST['idCliente'];
	$idDevice = $_POST['idDevice'];
	$tipoVisita = $_POST['tipoVisita'];
        $tipoVenta = $_POST['tipoVenta'];
	$longitud = $_POST['longitud'];
	$latitud = $_POST['latitud'];

	$sql = "INSERT INTO visita(idCliente, idDevice, tipoVisita, longitud, latitud, fechaHoraVisita, tipoVenta) VALUES('$idCliente', '$idDevice', '$tipoVisita', '$longitud', '$latitud', now(), '$tipoVenta')";
//	$sql = "INSERT INTO cliente(nombreCliente, direccion) VALUES('$nombreCliente', '$direccion')";

	mysql_query($sql, $link);

	if(mysql_affected_rows() == 0){
		echo 0;
	}
	else{
		$sql_res = mysql_query(" SELECT id FROM visita WHERE idDevice = '$idDevice' ORDER BY id DESC LIMIT 1;",$link);
		$idVisita = mysql_fetch_array($sql_res);
		echo $idVisita[0];
	}
?>