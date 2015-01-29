<?
	include("conexion.php");
	$link = conexion();

	$idAplicacion  = $_POST['idAplicacion'];



	$sql = "SELECT * FROM  `versionador` WHERE id = '$idAplicacion'";
        //$sql = "SELECT * FROM  `versionador` WHERE id = 1";
	

	$ver = mysql_query($sql);

	if (mysql_affected_rows() == 0){
		echo 0;
	}
	else{
		$fil = mysql_fetch_array($ver);
		echo $fil[versionLast];
	}

?>