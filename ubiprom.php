<?php

  include("conexion.php");
  $link = conexion();

  $idDevice = $_POST['idDevice'];

  $sql = "SELECT addtime(u.fechaHora, '1:00:00')fechaHora, u.idDevice, u.latitud, u.longitud, d.promotor
          FROM ubicacion u JOIN dispositivo d   ON u.idDevice = d.id
          WHERE latitud not in(0,1) and idDevice = '$idDevice'
          ORDER BY id DESC
          LIMIT 1";

  $ex_sql  = mysql_query($sql);
  $res_sql = mysql_fetch_array($ex_sql);

  $lat = $res_sql['latitud'];
  $lon = $res_sql['longitud'];
  $fechaHora = $res_sql['fechaHora'];
  $nombreCompleto = $res_sql['promotor'];
?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAigpbhagcfEzTt3hBQEogg-VEhkosF7OI&sensor=true">
    </script>
    <script type="text/javascript">

      function point(){


        var params = location.search.match(/[a-z_]\w*(?:=[^&]*)?/gi);
        var lat = params[0]; 
        var lon = params[1]; 


        initialize(lat, lon);
      }


      function initialize(_lat, _lon) {


        var myLatlng = new google.maps.LatLng(parseFloat(_lat), parseFloat(_lon));
        // var myLatlng = new google.maps.LatLng(-19.0396123705432, -65.267772115767);
        var mapOptions = {
          center: myLatlng,
          zoom: 18,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title:_lat + " "+ _lon
        });
      }  

    

    </script>
  </head>
  <body onload="initialize(<?= $lat?>,<?= $lon?>)">

    <header style="width:90%; height:10%">
      <form action='ubiprom.php' name='form2' method='post'>
        
        <select name='idDevice' id='idDevice'>
          <?php $sql_pro = mysql_query("SELECT promotor, id FROM dispositivo WHERE estado = 1;",$link);?>
              <option value='0'>PROMOTOR-SUPERVISOR</option>
          <?php
              while($res_pro = mysql_fetch_array($sql_pro)){
          ?>
              <option value='<?= $res_pro[id]?>'><?= $res_pro[promotor]?></option>
              <?php }  ?>
        </select>
        <input type='submit' name='enviar' id='enviar' value='enviar'/>
    
      </form> 

      <?=$nombreCompleto?>
      <?=$fechaHora?>
    </header>
    <div id="map_canvas" style="width:100%; height:90%"></div>

  </body>
</html> 