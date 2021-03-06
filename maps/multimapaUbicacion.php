<?
  include("../conexion.php");
  $link = conexion();

  $idDevice = $_POST["idDevice"];
  $fecha1 = $_POST["fecha1"];
  $fecha2 = $_POST["fecha2"];

  $sql = "Select promotor From dispositivo Where id = '$idDevice'";  
  $res = mysql_query($sql, $link);
  $prom = mysql_fetch_array($res);

  echo $prom[promotor].' ** '.$fecha1.' ** '.$fecha2;

  $fecha2 = $fecha2.' 23:59:59'
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Lista de Puntos en Visita SIDS S.A.</title>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAigpbhagcfEzTt3hBQEogg-VEhkosF7OI&sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      1:{
          icon:'icons/ultimo_punto.png',
          shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        },
      0:{
          icon:'icons/otros_punto.png',
          shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-19.14, -65.268),
        zoom: 12,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file


      
      downloadUrl("misqlUbicacion.php?idDevice=<?= $idDevice?>", function(data) {
      


        var xml = data.responseXML;

        var markers = xml.documentElement.getElementsByTagName("pointsGPS");

        alert("Puntos encontrados: "+markers.length);
        for (var i = 0; i < markers.length; i++) {          
          
          var promotor  = markers[i].getAttribute("promotor");
          var fechaHora = markers[i].getAttribute("fechaHora");
          var ultimo    = markers[i].getAttribute("ultimo");


          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("latitud")),
              parseFloat(markers[i].getAttribute("longitud")));   

          var html = "<b>" + promotor + "</b> <br/>" + fechaHora;
          
          var icon = customIcons[ultimo] || {};

          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            shadow: icon.shadow
          });
          bindInfoWindow(marker, map, infoWindow, html);


        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>
  </script>
  </head>

  <body onload="load()">
    <div id="map" style="width: 1500px; height: 1300px"></div>
  </body>
</html>