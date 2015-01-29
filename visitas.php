<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<style type="text/css">@import"js/jquery.datepick.css";</style> 

<script type="text/javascript">
$(function() {	
		$('#fecha1').datepick();
	});
$(function() {	
		$('#fecha2').datepick();
	});
</script>

<?
	include("conexion.php");
	$link = conexion();

	if ($_POST){
		$idDevice = $_POST["idDevice"];
		$fecha1   = $_POST["fecha1"];
		$fecha2   = $_POST["fecha2"];

	}
	else{
		$idDevice = "0";
	}
		?>
			<form action='visitas.php' name='form2' method='post'>
<table width="466" border="0">
    <tr>
      <td width="81">Fecha Inicio:</td>
      <td><input name="fecha1" type="text" id="fecha1" size="10" maxlength="12">
      </td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><input name="fecha2" type="text" id="fecha2" size="10" maxlength="12">
      </td>
    </tr>
 </table>

			<select name='idDevice' id='idDevice'>
		<?
	
		$sql_pro = mysql_query("SELECT promotor, id FROM dispositivo;",$link);
	
			echo "<option value='0'>PROMOTOR-SUPERVISOR</option>";
			while($res_pro = mysql_fetch_array($sql_pro)){
				echo "<option value='$res_pro[id]'>$res_pro[promotor]</option>";
			}
		?>
		</select>
		<input type='submit' name='enviar' id='enviar' value='enviar'
		?>
			</form>	
		<?
	

	

	echo "<form action='panel_gps.php' name='form1' id='form1' method='post'>";
	echo "<table>";
		echo "<tr bgcolor='#9999CC'>";
			echo "<td>Cont.</td>";
			echo "<td>selecc</td>";
			echo "<td width='100'>Promotor</td>";						
            echo "<td style='text-align:center' width='100'>Fecha Hora</td>";
            echo "<td style='text-align:center' width='100'>Canal</td>";
            echo "<td style='text-align:center' width='100'>Tipo Local</td>";
            echo "<td style='text-align:center' width='30'>Codigo</td>";
            echo "<td style='text-align:center' width='100'>nombreCliente</td>";
            echo "<td style='text-align:center' width='100'>Zona</td>";
			echo "<td style='text-align:center' width='170'>Direccion</td>";
			echo "<td style='text-align:center' width='70'>Nro</td>";
			echo "<td style='text-align:center' width='70'>Tipo Venta</td>";
			echo "<td style='text-align:center' width='100'>Mot. Rechazo</td>";
		echo "</tr>";
	$cont = 1;
	$sel = "SELECT v.id, v.idDevice, idCliente, tipoVenta, tipoVisita, latitud, longitud, DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) as fechaHoraVisita, promotor, nombreCliente, zona, direccion, c.nro, canal, tipoLocal FROM visita v JOIN dispositivo d ON d.id = v.idDevice JOIN cliente c ON v.idCliente = c.id ";
	if($idDevice=="0"){
		$sel = "1";
		$whe = "DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) BETWEEN '$fecha1' AND DATE_ADD('$fecha2', INTERVAL 1 DAY)";	
	}
	else{		
		$whe = "WHERE v.idDevice = '$idDevice' AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) BETWEEN '$fecha1' AND DATE_ADD('$fecha2', INTERVAL 1 DAY)";
	}
        
	$sql = mysql_query($sel.$whe, $link);
	while($res = mysql_fetch_array($sql)){
		echo "<tr style='font-size:11'>";
			echo "<td bgcolor='#FFFFCC'>$cont</td>";
			echo "<td><input type='checkbox' name='id_visita[]' id='id_visita[]' value='$res[id]'></td>";
			echo "<td bgcolor='#FFFFCC'>$res[promotor]</td>";			
			$lat = $res[longitud];			
			$lon = $res[latitud];
			//echo "<td bgcolor='#FFFFCC'><a href=punto.php?lat=$lat&lon=$lon>$res[fechaHoraVisita]</a></td>";
			echo "<td bgcolor='#FFFFCC'>$res[fechaHoraVisita]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[canal]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[tipoLocal]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[idCliente]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[nombreCliente]</td>";
                        echo "<td bgcolor='#FFFFCC'>$res[zona]</td>";
                        echo "<td bgcolor='#FFFFCC'>$res[direccion]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[nro]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[tipoVenta]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[tipoVisita]</td>";
		echo "</tr>";		
		$cont = $cont + 1;
	}
	echo "</table>";
	echo "<input name='confirmar' type='submit' id='confirmar' value='Confirmar'>";
echo "<form>";

?>