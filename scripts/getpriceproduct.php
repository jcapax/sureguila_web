<?

	include("../conexion.php");
	$link = conexion();

	$producto   = trim($_POST['product']);
	$tipoPrecio = $_POST['tipePrice'];

	$sql = "SELECT precioVenta
			FROM detallePrecio d JOIN producto p ON d.idProducto = p.id 
			WHERE p.nombreProducto = '$producto' AND idPrecio = '$tipoPrecio'";

	//echo $sql;

	$fil = mysql_query($sql,$link);

	if(mysql_affected_rows() == 0){
		$aux = 0;
	}
	else{
		$res = mysql_fetch_array($fil);	
		$aux = $res['precioVenta'];
	}	

    echo $aux;
	    

