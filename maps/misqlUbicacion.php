<?php  

require("phpsqlajax_dbinfo.php"); 

$idDevice = $_GET["idDevice"];
//$idDevice = '%'.$_GET["idDevice"].'%';
//$fecha1   = $_GET["fecha1"];
//$fecha2   = $_GET["fecha2"];

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

// Opens a connection to a MySQL server

$connection=mysql_connect ('192.168.1.201', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// Select all the rows in the markers table

$query = "select u.idDevice, d.promotor, u.fechaHora, u.latitud, u.longitud
          from ubicacion u 
            join dispositivo d on u.idDevice = d.id
          where u.idDevice = $idDevice          
          LIMIT 30";  
          
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
} 

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

$cont = 0;

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("pointsGPS");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("promotor",$row['promotor']);
  $newnode->setAttribute("fechaHora", $row['fechaHora']);  
  $newnode->setAttribute("latitud", $row['latitud']);
  $newnode->setAttribute("longitud", $row['longitud']);
  if($cont == 0){
    $newnode->setAttribute("ultimo", 1);    
  }
  else{
    $newnode->setAttribute("ultimo", 0);     
  }
} 

echo $dom->saveXML();

?>