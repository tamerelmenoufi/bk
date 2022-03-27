<?php
    include("../../../lib/includes.php");
?>

<style>

    #map {
        position:absolute;
        left:0;
        top:0;
        height: 100%;
        width:100%;
    }
    #menu{
        position: fixed;
        left:0;
        bottom:0;
        width:100%;
        padding:10px;
        background-color:#fff;
    }
</style>

<div id="map">MAPA NO AR Versão 2</div>


<div id="menu">
    <input type="text" id="adress" name="adress">
    <input type="submit" id="submit" class="btn" value="Search">
</div>

<script>


  const cairo = { lat: 30.064742, lng: 31.249509 };
  const map = new google.maps.Map(document.getElementById("map"), {
    scaleControl: true,
    center: cairo,
    zoom: 10,
  });
  const infowindow = new google.maps.InfoWindow();

  infowindow.setContent("<b>القاهرة</b>");

  const marker = new google.maps.Marker({ map, position: cairo });

  marker.addListener("click", () => {
    infowindow.open(map, marker);
  });


  $("#submit").click(function(){
    endereco = $('#adress').val();
    alert(status);

    GMaps.geocode({
        address: $('#adress').val(),
        callback: function(results, status) {

            if (status == 'OK') {
                var latlng = results[0].geometry.location;
                map.setCenter(latlng.lat(), latlng.lng());
            }
        }
    });

  });




</script>