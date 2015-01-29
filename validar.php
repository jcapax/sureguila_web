<?php
   ob_start();
?> 

<?	
    session_start();    

    include("conexion.php");
    $link = conexion();	
	
    $contrasena = $_POST['contrasena'];
    $login = $_POST['login'];
	
    $sql_login = "SELECT DISTINCT codigoUsuario, login FROM usuario  
                    WHERE login = '$login' AND contrasena = md5('$contrasena');";
    $reg_login = mysql_query($sql_login,$link);
    if (mysql_num_rows($reg_login)<>0){
        $fil_login = mysql_fetch_array($reg_login);
        $_SESSION["codigo_usuario"] = $fil_login[0];    
        $_SESSION["login"]          = $fil_login[1];        
    }    
    
    $contador = mysql_num_rows();
    
    if($contador<>0){        
        $_SESSION["autenticado"] = 1; 
        header("Location: menu.php");
    }
    else{
        header("Location: index.php?error=1"); 
    }
?>
<?php
ob_end_flush();
?> 