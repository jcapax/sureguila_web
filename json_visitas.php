<?php
	$criterio = $_GET['criterio'];

        include("conexion.php");
	$link = conexion();

	$sql = "select v.idCliente, v.tipoVenta, v.tipoVisita, v.fechaHoraVisita,
  				if(isnull(p.producto),'*',p.producto) as producto,
  				if(isnull(p.cantidad),'*', p.cantidad) as cantidad
			from visita v
  				left join preventa p on v.id = p.idVisita 
  			where v.idCliente = $criterio 
  			order by v.fechaHoraVisita desc";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$arr[] = $row;
	}

	$json = json_encode($arr);

	echo $json;
?>
