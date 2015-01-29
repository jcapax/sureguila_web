<?

	include("../conexion.php");
	$link = conexion();

	$producto   = trim($_POST['producto']);
	
	$sql = "SELECT id
			FROM producto 
			WHERE nombreProducto = '$producto'";

	//echo $sql;

	$fil = mysql_query($sql,$link);

	if(mysql_affected_rows() == 0){
		$aux = 0;
	}
	else{
		$res = mysql_fetch_array($fil);	
		$aux = $res['id'];
	}	

    echo $aux;
	    
