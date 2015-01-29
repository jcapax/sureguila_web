<?php
	$criterio = "%".$_GET['criterio']."%";

        include("conexion.php");
	$link = conexion();

	$sql = "select * from cliente where CONCAT(id,nombreCliente) like '$criterio' order by id desc";
	$result = mysql_query($sql, $link);
	while($row = mysql_fetch_assoc($result)){
		$arr[] = $row;
	}

	$json = json_encode($arr);

	echo $json;
?>
