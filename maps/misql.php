<?php  

require("phpsqlajax_dbinfo.php"); 

$idDevice = $_GET["idDevice"];
//$idDevice = '%'.$_GET["idDevice"].'%';
$fecha1   = $_GET["fecha1"];
$fecha2   = $_GET["fecha2"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// Select all the rows in the markers table
$aux = intval($idDevice);

if($aux == 0){
  $query = "SELECT v.id, v.idDevice, idCliente, tipoVenta, 
            if(tipoVisita='0',tipoVenta,TipoVisita) as tipoVisita, 
            latitud, longitud, 
            DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) as fechaHoraVisita, promotor, 
            nombreCliente, zona, direccion, c.nro, canal, tipoLocal  
          FROM visita v JOIN dispositivo d ON d.id = v.idDevice JOIN cliente c ON v.idCliente = c.id          
            AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between $fecha1 AND $fecha2";  
}
else{
  $query = "SELECT v.id, v.idDevice, idCliente, tipoVenta, 
            if(tipoVisita='0',tipoVenta,TipoVisita) as tipoVisita, 
            latitud, longitud, 
            DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) as fechaHoraVisita, promotor, 
            nombreCliente, zona, direccion, c.nro, canal, tipoLocal  
          FROM visita v JOIN dispositivo d ON d.id = v.idDevice JOIN cliente c ON v.idCliente = c.id
          WHERE v.idDevice = $idDevice
            AND DATE_ADD(fechaHoraVisita, INTERVAL 1 HOUR) between $fecha1 AND $fecha2";
}

          
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
} 

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("nombreCliente",$row['nombreCliente']);
  $newnode->setAttribute("direccion", $row['direccion']);  
  $newnode->setAttribute("latitud", $row['latitud']);  
  $newnode->setAttribute("longitud", $row['longitud']);  
  $newnode->setAttribute("tipoLocal", $row['tipoLocal']);  
  $newnode->setAttribute("fechaHoraVisita", $row['fechaHoraVisita']);
  $newnode->setAttribute("promotor", $row['promotor']);
  $newnode->setAttribute("tipoVisita", $row['tipoVisita']);
  $newnode->setAttribute("tipoVenta", $row['tipoVenta']);
} 

echo $dom->saveXML();

?>