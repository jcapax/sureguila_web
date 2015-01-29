<?
	include("../conexion.php");
	$link = conexion();

	$sqlLastDate = "SELECT UNIX_TIMESTAMP(fechaHora), UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(fechaHora)  FROM gps ORDER BY id DESC LIMIT 1";

	$qryLastDate = mysql_query($sqlLastDate, $link);

	$resLastDate = mysql_fetch_array($qryLastDate);

	$lastRegister = $resLastDate[0];
	$actualDate   = $resLastDate[1];
	$diff		  = $resLastDate[2];

	
	echo $lastRegister.' - '. $actualDate.' - '. $diff.'<br>';




?>