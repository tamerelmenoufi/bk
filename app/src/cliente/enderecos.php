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

</style>

<div id="map"></div>

<script>

function initMap() {
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
}

</script>
