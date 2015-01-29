<?
	include("conexion.php");
	$link = conexion();

	echo "<table>";
		echo "<tr bgcolor='#9999CC'>";
			echo "<td>Códgio</td>";
			echo "<td width='100'>Nombre Cliente</td>";			
            echo "<td style='text-align:center' width='100'>Direccion</td>";
            echo "<td style='text-align:center' width='100'>Nro</td>";
            echo "<td style='text-align:center' width='100'>Zona</td>";
            echo "<td style='text-align:center' width='100'>Canal</td>";
            echo "<td style='text-align:center' width='100'>Tipo Local</td>";
			echo "<td style='text-align:center' width='170'>Telefono</td>";
			echo "<td style='text-align:center' width='70'>Fecha Nacimiento</td>";			
		echo "</tr>";	
	$sql = mysql_query("SELECT id, nombreCliente, direccion, nro, zona, canal, tipoLocal, telefono, fechaNacimiento FROM cliente ORDER BY id DESC;", $link);
	while($res = mysql_fetch_array($sql)){
		echo "<tr style='font-size:11'>";
			echo "<td bgcolor='#FFFFCC'>$res[id]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[nombreCliente]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[direccion]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[nro]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[zona]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[canal]</td>";
            echo "<td bgcolor='#FFFFCC'>$res[tipoLocal]</td>";
            echo "<td bgcolor='#FFFFCC'>$res[telefono]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[fechaNacimiento]</td>";
		echo "</tr>";				
	}
	echo "</table>";

?>