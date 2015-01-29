<?
  include("../conexion.php");
  $link = conexion();

  $tipoLocal = $_POST["tipoLocal"];

  $fecha1 = $_POST["fecha1"];
  $fecha2 = $_POST["fecha2"];
/*
  $sql = "Select promotor From dispositivo Where id = '$idDevice'";  
  $res = mysql_query($sql, $link);
  $prom = mysql_fetch_array($res);
*/
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
      TIENDA:{
                icon:'icons/tienda.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      BAR:{
                icon:'icons/Directa.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      AGENCIA:{
                icon:'icons/agencia.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      CHORICERIA:{
                icon:'icons/choriceria.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      LICORERIA:{
                icon:'icons/licoreria.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      PENSION:{
                icon:'icons/pension.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      CHICHARRONERIA:{
                icon:'icons/chicharroneria.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      KARAOQUE:{
                icon:'icons/karaoke.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
              },
      VISITA:{
                icon:'icons/visitante.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      SinDecision:{
                icon:'icons/sinDecision.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      Supervisado:{
                icon:'icons/supervisado.png',
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

      downloadUrl("misql_ubicacionClientes.php?tipoLocal=<? echo $tipoLocal?>&fecha1=<? echo $fecha1?>&fecha2=<? echo $fecha2?>", function(data) {
        var xml = data.responseXML;

        var markers = xml.documentElement.getElementsByTagName("marker");
        alert("Puntos encontrados: "+markers.length);
        for (var i = 0; i < markers.length; i++) {          
          
          var nombreCliente = markers[i].getAttribute("nombreCliente");
          var direccion = markers[i].getAttribute("direccion");
          var tipoLocal = markers[i].getAttribute("tipoLocal");
         // var fechaHoraRegistro = markers[i].getAttribute("fechaHoraRegistro");          
         // var canal = markers[i].getAttribute("canal");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("longitud")),
              parseFloat(markers[i].getAttribute("latitud")));   

          var html = "<b>" + nombreCliente + "</b> <br/>" + tipoLocal+ "</b> <br/>" + direccion;
          //var html = "<b>" + nombreCliente + "</b> <br/>" + direccion+ "</b> <br/>" + tipoLocal
          //      + "</b> <br/>" + canal
          //      + "</b> <br/>" + fechaHoraRegistro;
          
          var icon = customIcons[tipoLocal] || {};

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