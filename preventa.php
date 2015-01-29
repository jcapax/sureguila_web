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

		$fecha2 = $fecha2.' 23:59:59';
	}
		?>
			<form action='preventa.php' name='form2' method='post'>
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
	//echo "<form action='listaVisitas.php' name='form2' method='post'>";		
		$sql_pro = mysql_query("SELECT promotor, id FROM dispositivo;",$link);
		//echo "<select name='idDevice' id='idDevice'>";
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
	//echo "</form>";

//	echo $idDevice;

	echo "<form action='panel_gps.php' name='form1' id='form1' method='post'>";
	echo "<table>";
		echo "<tr bgcolor='#9999CC'>";
			echo "<td>Cont.</td>";			
			echo "<td width='100'>Promotor</td>";						
            echo "<td style='text-align:center' width='100'>Fecha Hora</td>";
            echo "<td style='text-align:center' width='50'>Canal</td>";
            echo "<td style='text-align:center' width='80'>Tipo Loc.</td>";            
            echo "<td style='text-align:center' width='100'>Cliente</td>";
            echo "<td style='text-align:center' width='100'>Zona</td>";
			echo "<td style='text-align:center' width='170'>Direccion</td>";
			echo "<td style='text-align:center' width='40'>Nro</td>";
			echo "<td style='text-align:center' width='70'>Tipo Venta</td>";
			echo "<td style='text-align:center' width='90'>Producto</td>";
			echo "<td style='text-align:center' width='50'>Cantidad</td>";
                        echo "<td style='text-align:center' width='90'>Firma Recep.</td>";
		echo "</tr>";
	$cont = 1;
	$sel = "SELECT vi.id, pr.idVisita, 
				vi.idCliente, upper(cl.nombreCliente)nombreCliente, cl.ruta, upper(cl.zona)zona, 
				upper(cl.direccion)direccion, cl.nro, 
				upper(cl.canal)canal, upper(cl.tipoLocal)tipoLocal, 
				vi.tipoVisita, upper(vi.tipoVenta)tipoVenta, 
				di.promotor, pr.producto, pr.cantidad,  
				DATE_ADD(vi.fechaHoraVisita, INTERVAL 2 HOUR) fechaHoraVisita, vi.longitud, vi.latitud  
			FROM preventa pr 
				JOIN visita vi ON pr.idVisita = vi.id
				JOIN cliente cl ON vi.idCliente = cl.id
				JOIN dispositivo di ON di.id = vi.idDevice ";

	
	if($idDevice=="0"){		
		$whe = "WHERE DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between '$fecha1' AND '$fecha2' AND upper(vi.tipoVenta) = 'PREVENTA' ";	
	}
	else{		
		$whe = "WHERE vi.idDevice = '$idDevice' AND 
					DATE_ADD(fechaHoraVisita, INTERVAL 2 HOUR) between '$fecha1' AND '$fecha2' AND upper(vi.tipoVenta) = 'PREVENTA' ";
	}
	$ord = "ORDER BY di.promotor, fechaHoraVisita";

        $total = 0;
	
	$sql = mysql_query($sel.$whe.$ord, $link);
	while($res = mysql_fetch_array($sql)){
		echo "<tr style='font-size:11'>";
			if($cont > 1){
				if ($contPromotor != $res[promotor]){
					$cont = 1;
				}
			}
			echo "<td bgcolor='#FFFFCC'>$cont</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[promotor]</td>";						
			//echo "<td bgcolor='#FFFFCC'><a href=punto.php?lat=$lat&lon=$lon>$res[fechaHoraVisita]</a></td>";
			echo "<td bgcolor='#FFFFCC'>$res[fechaHoraVisita]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[canal]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[tipoLocal]</td>";			
                        $lat = $res[longitud];
                        $lon = $res[latitud];
			echo "<td bgcolor='#FFFFCC'><a href=puntoPreventa.php?lat=$lat&lon=$lon>$res[nombreCliente]</a></td>";
                        echo "<td bgcolor='#FFFFCC'>$res[zona]</td>";
                        echo "<td bgcolor='#FFFFCC'>$res[direccion]</td>";
			echo "<td bgcolor='#FFFFCC' align='right'>$res[nro]</td>";
			echo "<td bgcolor='#FFFFCC'>$res[tipoVenta]</td>";			
			echo "<td bgcolor='#FFFFCC'>$res[producto]</td>";
			echo "<td bgcolor='#FFFFCC' align='right'>$res[cantidad]</td>";
                        echo "<td ></td>";

                        $total = $total + $res[cantidad];

		echo "</tr>";		
		$cont = $cont + 1;
		$contPromotor = $res[promotor];
	}
		echo "<tr bgcolor='#9999CC'>";
			echo "<td colspan='11' align='center'><strong>TOTAL</strong></td>";
			echo "<td align='right'><strong>$total</strong></td>";
                        echo "<td>...</td>";
		echo "</tr>";

	echo "</table>";	
echo "<form>";

?>