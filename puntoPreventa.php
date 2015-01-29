<?php

  $lat = $_GET['lat'];
  $lon = $_GET['lon'];
  
?>

  <!DOCTYPE html>
<html>
  <head>

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

//        alert(lat);
//        alert(lon);

        initialize(lat, lon);
      }


      function initialize(_lat, _lon) {
//      function initialize() {

        // var params = location.search.match(/[a-z_]\w*(?:=[^&]*)?/gi);
        // var _lat = params[0]; 
        // var _lon = params[1]; 


        var myLatlng = new google.maps.LatLng(parseFloat(_lat), parseFloat(_lon));
//        var myLatlng = new google.maps.LatLng(-19.0396123705432, -65.267772115767);
        var mapOptions = {
          center: myLatlng,
          zoom: 18,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title:"punto encontrado!"

        });
      }  

    

    </script>
  </head>
  <body onload="initialize(<? echo $lat?>,<? echo $lon?>)">

      <?php // echo $lat.' ----------- '.$lon; ?>

      <? //echo "<input type='button' name='enviar' id='enviar' onclick='initialize($lat, $lon);' value='enviar' >";?>

    

    

    <div id="map_canvas" style="width:100%; height:100%"></div>

  </body>
</html> 