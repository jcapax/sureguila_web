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
?>
	<form action='maps/multimapaUbicacion.php' name='form2' method='post'>
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
		      <td colspan="2">
		      	<select name="idDevice" id="idDevice">
		      		<option value="0">PROMOTOR-SUPERVISOR</option>
			        <?php 
						$sql_pro = mysql_query("SELECT promotor, id FROM dispositivo;",$link);
		
						while($res_pro = mysql_fetch_array($sql_pro)){
					?>

					<option value="<?= $res_pro[id]?>"><?= $res_pro[promotor]?></option>

					<?php } ?>
	          </select></td>
	      </tr>
		    <tr>
		      <td><input type='submit' name='enviar' id='enviar' value='enviar' /></td>
		      <td>&nbsp;</td>
	      </tr>
		 </table>
	</form>	
	
