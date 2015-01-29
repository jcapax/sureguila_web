<?

	include("../conexion.php");
	$link = conexion();

	$idVenta     = $_POST['idVenta'];
	$idProducto  = $_POST['idProducto'];
	$cantidad    = $_POST['cantidad'];
	$precioTotal =  (float) $_POST['precioTotal'];

	$cantProducto = $cantidad;

//********************************************************************************************
//********************************************************************************************

	$sql_exists_botella = "SELECT id FROM detalleVenta WHERE idVenta = '$idVenta' AND idProducto IN (1,2,3,4)";
	mysql_query($sql_exists_botella, $link);	
	if(mysql_affected_rows() == 0){
		mysql_query("INSERT INTO detalleVenta(idVenta, idProducto, cantidad, precioUnitario, precioTotal)
			VALUES('$idVenta', 15, '$cantidad', 0, 0)");
	}
	else{
		mysql_query("UPDATE detalleVenta SET cantidad = cantidad + '$cantidad' WHERE idVenta = '$idVenta' AND idProducto = 15");
	}


//********************************************************************************************
//********************************************************************************************
	$sql = "INSERT INTO detalleVenta(idVenta, idProducto, cantidad, precioUnitario, precioTotal)
			VALUES('$idVenta', '$idProducto', '$cantProducto', ($precioTotal / $cantProducto), $precioTotal);";

	//echo $sql;

	mysql_query($sql, $link);

	if(mysql_affected_rows() == 0){
		echo 0;
	}
	else{
		echo 1;
	}

?>