<?

	include("../conexion.php");
	$link = conexion();

	function getIdProduct($product){
		$producto   = trim($product);
	
		$sql = "SELECT id FROM producto WHERE nombreProducto = '$producto'";

		$fil = mysql_query($sql,$link);

		$res = mysql_fetch_assoc($fil);	
		
		return $res['id'];
	}