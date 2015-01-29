<?

	include("../conexion.php");
	$link = conexion();

	$nombreCliente       = $_POST['nombreCliente'];
	$denominacionCliente = $_POST['denominacionCliente'];
	$direccion           = $_POST['direccion'];
	$nro				 = $_POST['nro'];
    $ruta				 = $_POST['ruta'];
	$zona				 = $_POST['zona'];
	$canal				 = $_POST['canal'];
	$tipoLocal			 = $_POST['tipoLocal'];
	$telefono			 = $_POST['telefono'];
	$fechaNacimiento 	 = $_POST['fechaNacimiento'];

	$sql = "INSERT INTO cliente(nombreCliente, denominacionCliente, direccion, nro, ruta, zona, 
					canal, tipoLocal, telefono, fechaNacimiento, fechaHoraRegistro	) 
			VALUES('$nombreCliente', '$denominacionCliente', '$direccion', '$nro', '$ruta', '$zona', 
					'$canal', '$tipoLocal', '$telefono', '$fechaNacimiento', now())";


	mysql_query($sql, $link);

        if(mysql_affected_rows() <> 0){
   
         	$sql = "SELECT id, nombreCliente FROM cliente ORDER BY id DESC LIMIT 1";

    	    $res = mysql_fetch_array(mysql_query($sql,$link));

	        echo $res[id];
    	    
        }
        else{
               echo "error";
        }
    
?>
