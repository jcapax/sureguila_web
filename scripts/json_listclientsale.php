<?php
	$criterio = $_GET['criterio'];
	$tipo     = $_GET['tipo']; 

    include("../conexion.php");
	$link = conexion();

	$sql = "SELECT DATE(fechaHoraVenta) fecha, cantidad, nombreProducto
			FROM venta v
  				JOIN detalleVenta d ON v.id = d.idVenta
  				JOIN producto p ON d.idproducto = p.id
			WHERE tipo = $tipo AND idCliente = $criterio and impresionMovil = 1
			ORDER BY fechahoraVenta Desc";

	$result = mysql_query($sql, $link);
	
	while($row = mysql_fetch_assoc($result)){
		$arr[] = $row;
	}

	$json = json_encode($arr);

	echo $json;
?>
