<?

	include("conexion.php");
	$link = conexion();

	$idVisita  = $_POST['idVisita'];
	$producto  = $_POST['producto'];
	$cantidad  = $_POST['cantidad'];

/*
	$detalle   = $_POST['detalle'];

	$abierto = explode("-", $detalle);

	$producto = $abierto[0];
	$cantidad = $abierto[1];
*/
	$sql = "INSERT INTO preventa(idVisita, producto, cantidad) VALUES($idVisita, '$producto', $cantidad)";


	mysql_query($sql, $link);

	if(mysql_affected_rows() == 0){
		echo 0;
	}
	else{
		echo 1;
	}

?>