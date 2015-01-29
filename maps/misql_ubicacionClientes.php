<?php  

require("phpsqlajax_dbinfo.php"); 

$tipoLocal = $_GET["tipoLocal"];
$fecha1 = $_GET["fecha1"];
$fecha2 = $_GET["fecha2"];


// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

// Opens a connection to a MySQL server

//$connection=mysql_connect ('localhost', $username, $password);
$connection=mysql_connect ('192.168.1.201', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// Select all the rows in the markers table
$aux = intval($idDevice);

if($tipoLocal == '0'){
//  $query = "SELECT latitud, longitud, nombreCliente, direccion, nro, canal, tipoLocal, fechaHoraRegistro 
//          FROM vposicioncliente;

  $query = "SELECT idDevice, latitud, longitud, fechaHoraVisita, nombreCliente, direccion, nro, tipoLocal
          FROM vPosicionCliente
          UNION 
          SELECT idDevice, latitud, longitud, fechaHoraVisita, nombreCliente, direccion, nro, 'VISITA'
          FROM visita v
              JOIN cliente c ON v.idCliente = c.id
          WHERE fechaHoraVisita BETWEEN '$fecha1' AND '$fecha2';";          

}
else{
//  $query = "SELECT latitud, longitud, nombreCliente, direccion, nro, canal, tipoLocal, fechaHoraRegistro 
//          FROM vPosicionCliente WHERE tipoLocal = '$tipoLocal';";   

  $query = "SELECT idDevice, latitud, longitud, fechaHoraVisita, nombreCliente, direccion, nro, tipoLocal
            FROM vPosicionCliente
            WHERE tipoLocal = '$tipoLocal'
            UNION 
            SELECT idDevice, latitud, longitud, fechaHoraVisita, nombreCliente, direccion, nro, 'VISITA'
            FROM visita v
              JOIN cliente c ON v.idCliente = c.id
            WHERE fechaHoraVisita BETWEEN '$fecha1' AND '$fecha2';";         

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
  $newnode->setAttribute("direccion",    $row['direccion']);  
  $newnode->setAttribute("latitud",      $row['latitud']);    
  $newnode->setAttribute("longitud",     $row['longitud']); 
   
  //$newnode->setAttribute("canal",        $row['canal']);  
  $newnode->setAttribute("tipoLocal",    $row['tipoLocal']);  
  //$newnode->setAttribute("fechaHoraRegistro", $row['fechahoraRegistro']);
  
} 
echo $dom->saveXML();

?>