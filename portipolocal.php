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
		$tipoLocal = $_POST["tipoLocal"];
		$fecha1   = $_POST["fecha1"];
		$fecha2   = $_POST["fecha2"];

		$fecha2 = $fecha2.' 23:59:59';		
	}
		?>
			<form action='portipolocal.php' name='form2' method='post'>
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

			<select name='tipoLocal' id='tipoLocal'>
		    <?	
		      $sql_pro = mysql_query("SELECT tipoLocal FROM cliente GROUP BY tipoLocal ORDER BY tipoLocal;",$link);		
			  echo "<option value='0'>TIPO LOCAL</option>";
			  while($res_pro = mysql_fetch_array($sql_pro)){
				echo "<option value='$res_pro[tipoLocal]'>$res_pro[tipoLocal]</option>";
			  }
			  echo "<option value='REFRIGERADO'>REFRIGERADO</option>";
		?>
		</select>
		<input type='submit' name='enviar' id='enviar' value='enviar'
		?>
			</form>	
		<?
	//echo "</form>";

//	echo $idDevice;

	echo "<form action='panel_gps.php' name='form1' id='form1' method='post'>";
	echo "<table>";
		echo "<tr bgcolor='#9999CC'>";
			echo "<td>Cont.</td>";												
            echo "<td style='text-align:center' width='120'>Cliente</td>";
            echo "<td style='text-align:center' width='50'>Zona</td>";
            echo "<td style='text-align:center' width='120'>Direccion</td>";            
            echo "<td style='text-align:center' width='40'>Nro</td>";
            echo "<td style='text-align:center' width='80'>Canal</td>";
			echo "<td style='text-align:center' width='120'>Tipo Local</td>";
			echo "<td style='text-align:center' width='40'>Registro</td>";
			echo "<td style='text-align:center' width='70'>Producto</td>";
			echo "<td style='text-align:center' width='90'>Cantidad</td>";
			echo "<td style='text-align:center' width='50'>Veces</td>";
		echo "</tr>";
	$cont = 1;
	$sel = "SELECT idVisita, idCliente, nombreCliente, zona, direccion, nro, 
				canal, tipoLocal, tipoVisita,  
				tipoVenta, producto, SUM(cantidad) AS cantidad, COUNT(*) AS rep
			FROM vVisitaPreventa ";
	
	if($tipoLocal=="0"){		
		$whe = "WHERE idVisita IS NOT NULL
				AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between '$fecha1' AND '$fecha2' 								
			GROUP BY idCliente, nombreCliente, zona, direccion, nro, 
				canal, tipoLocal, tipoVisita, producto
			ORDER BY tipoVenta DESC, SUM(cantidad) DESC;";	
	}
	else{		
		if($tipoLocal=="REFRIGERADO"){
			$whe = "WHERE idVisita IS NOT NULL
					AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between '$fecha1' AND '$fecha2' 				
					AND tipoLocal IN ('Bar','Billar','Broasteria','Cafeteria','Cantina','Chicharroneria','Choriceria','Churrasqueria','Comedor Popular','Discoteca','Jugueras','Karaoque','Kiosco','Night Club','Pension','Pizzeria','Restaurant','Salon de Eventos','SalteÃ±eria')
				GROUP BY idCliente, nombreCliente, zona, direccion, nro, 
					canal, tipoLocal, tipoVisita, producto
				ORDER BY tipoLocal, tipoVenta DESC, SUM(cantidad) DESC;";
		}
		else{
			$whe = "WHERE idVisita IS NOT NULL
					AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between '$fecha1' AND '$fecha2' 				
					AND tipoLocal LIKE '%$tipoLocal%'
				GROUP BY idCliente, nombreCliente, zona, direccion, nro, 
					canal, tipoLocal, tipoVisita, producto
				ORDER BY tipoVenta DESC, SUM(cantidad) DESC;";
		}
	}

        $total = 0;

    //echo $sel.$whe;
	
	$sql = mysql_query($sel.$whe, $link);
	while($res = mysql_fetch_array($sql)){
		echo "<tr style='font-size:11'>";
			if($cont > 1){
				if ($contPromotor != $res[promotor]){
					$cont = 1;
				}
			}
			echo "<td bgcolor='#FFFFCC'>$cont</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[nombreCliente]</td>";									
			echo "<td bgcolor='#FFFFCC'>$res[zona]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[direccion]</td>";
			echo "<td bgcolor='#FFFFCC' align='right'>$res[nro]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[canal]</td>";
            echo "<td bgcolor='#FFFFCC'>$res[tipoLocal]</td>";
            echo "<td bgcolor='#FFFFCC'>$res[tipoVenta]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[producto]</td>";
			echo "<td bgcolor='#FFFFCC' align='right'>$res[cantidad]</td>";
			echo "<td bgcolor='#FFFFCC' align='right'>$res[rep]</td>";
			echo "<td ></td>";

                        $total = $total + $res[cantidad];

		echo "</tr>";		
		$cont = $cont + 1;		
	}
		echo "<tr bgcolor='#9999CC'>";
			echo "<td colspan='9' align='center'><strong>TOTAL</strong></td>";
			echo "<td align='right'><strong>$total</strong></td>";
			echo "<td align='right'></td>";
		echo "</tr>";

	echo "</table>";	
echo "<form>";

?>