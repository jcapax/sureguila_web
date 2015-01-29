<?

	include("../conexion.php");
	$link = conexion();

	$idDistribuidor = $_POST['idDistribuidor'];
	$idCliente      = $_POST['idCliente'];
	$tipoVenta      = $_POST['tipoVenta'];
	$idPrecio       = $_POST['idPrecio'];
	$movimiento     = $_POST['movimiento'];
	$latitud        = $_POST['latitud'];
	$longitud       = $_POST['longitud'];
//	$jsonList       = $_POST['jsonList'];


	$sql = "INSERT INTO venta(idDistribuidor, idCliente, tipo, idPrecio, fechaHoraVenta, movimiento, latitud, longitud) 
			VALUES('$idDistribuidor', '$idCliente', '$tipoVenta','$idPrecio', now(), '$movimiento', '$latitud', '$longitud')";

	mysql_query($sql, $link);

	if(mysql_affected_rows() <> 0){
   
         	$sqlIdVenta = "SELECT id FROM venta ORDER BY id DESC LIMIT 1";

    	    $res = mysql_fetch_array(mysql_query($sqlIdVenta,$link));

	        $idVenta = $res[id];

	        echo $idVenta;	    
    }
    else{
           echo "0";
    }
    
?>