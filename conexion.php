<?php
	function conexion()
	{

		if (!($link = mysql_connect("192.168.1.201","root",""))) 
  		 { 
     		echo "Error conectando a la base de datos."; 
	      	exit(); 
	   	 }	 
	   if (!mysql_select_db("sidssucr_sureguila",$link)) 	   
   		{	 
      		echo "Error seleccionando la base de datos."; 
		    exit(); 
	    } 
	   return $link; 
	} 
?> 
