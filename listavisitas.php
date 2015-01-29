<!DOCTTYPE html>
<html>


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
		$rechazo  = $_POST["rechazo"];

		$fecha2 = $fecha2.' 23:59:59';
	}
?>



	<head>
		<meta charset="UTF-8"/>
		<title>Lista Visitas</title>
	</head>
	<body>

			<form action='listavisitas.php' name='form2' method='post'>
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
				    <tr>
				    	<td>Operador</td>				    	
				    	<td>
							<select name='idDevice' id='idDevice'>

							<? 
								$sql_pro = mysql_query("SELECT promotor, id FROM dispositivo;",$link);
							?>
							<option value='0'>PROMOTOR-SUPERVISOR</option>
							<?
								while($res_pro = mysql_fetch_array($sql_pro))
								{	
							?>
									<option value='<?= $res_pro[id]?>'><?= $res_pro[promotor]?></option>
							<?
								}
							?>
							</select>				    		
				    	</td>
				    </tr>
					<tr>
				    	<td>Venta - Rechazo</td>				    	
				    	<td>
							<? $sql_rech = mysql_query("SELECT UPPER(tipoVisita)AS tipoVisita FROM VISITA WHERE tipoVisita <> '0' GROUP BY tipoVisita;"); ?>
							<select name='rechazo' id='rechazo'>
								<option value='1'>TODOS</option>
								<option value='0'>VENTA PREVENTA EVENTOS</option>
								<?
									while($res_rech = mysql_fetch_array($sql_rech)){
								?>
									<option value='<?= $res_rech[tipoVisita]?>'><?= $res_rech[tipoVisita]?></option>			
								<? 
									}
								?>
							</select>				    		
				    	</td>
				    </tr>
				    <tr>
				    	<td>
				    		<input type='submit' name='enviar' id='enviar' value='enviar'
				    	</td>
				    </tr>

				 </table>
			</form>

	

	<form action='panel_gps.php' name='form1' id='form1' method='post'>
	<table>
		<tr bgcolor='#9999CC'>
			<td>Cont.</td>			
			<td width='100'>Promotor</td>
            <td style='text-align:center' width='100'>Fecha Hora</td>
            <td style='text-align:center' width='100'>Canal</td>
            <td style='text-align:center' width='100'>Tipo Local</td>
            <td style='text-align:center' width='30'>Codigo</td>
            <td style='text-align:center' width='100'>nombreCliente</td>
            <td style='text-align:center' width='100'>Zona</td>
			<td style='text-align:center' width='170'>Direccion</td>
			<td style='text-align:center'>Nro</td>
			<td style='text-align:center' width='70'>Tipo Venta</td>
			<td style='text-align:center' width='100'>Mot. Rechazo</td>
		</tr>
	<?php
	$cont = 1;
	$sel = "SELECT v.id, v.idDevice, idCliente, tipoVenta, tipoVisita, latitud, longitud, 
				DATE_ADD(fechaHoraVisita, INTERVAL 2 HOUR) as fechaHoraVisita, promotor, 
				nombreCliente, zona, direccion, c.nro, canal, tipoLocal 
			FROM visita v JOIN dispositivo d ON d.id = v.idDevice JOIN cliente c ON v.idCliente = c.id ";
	if($idDevice=="0"){		
		$whe = "WHERE DATE_ADD(fechaHoraVisita, INTERVAL 2 HOUR) between '$fecha1' AND '$fecha2' ";	
	}
	else{		
		$whe = "WHERE v.idDevice = '$idDevice' AND 
					DATE_ADD(fechaHoraVisita, INTERVAL 2 HOUR) between '$fecha1' AND '$fecha2' ";
	}

	if($rechazo == "0"){
		$whe = $whe."AND (tipoVenta LIKE '%venta%' OR tipoVenta LIKE '%directa%')";
	}
	else{
		if($rechazo != "1"){
			$whe = $whe."AND tipoVisita = '$rechazo'";
		}
	}


	//echo $sel.$whe;
	$sql = mysql_query($sel.$whe, $link);
	while($res = mysql_fetch_array($sql)){
		echo "<tr style='font-size:11'>";
			echo "<td bgcolor='#FFFFCC'>$cont</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[promotor]</td>";			
			$lat = $res[longitud];			
			$lon = $res[latitud];			
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
echo "<form>";

?>		
	</body>
</html>

