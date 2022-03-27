<?php
    include("../../../lib/includes.php");
?>

<style>

    #googleMap {
        position:absolute;
        left:0;
        top:0;
        height: 100%;
        width:100%;
        z-index:0;
    }
    #menu{
        position:fixed;
        bottom:0;
        width:100%;
        background:#333;
        opacity:0.5;
    }

</style>

<div id="googleMap"></div>
<div id="menu">
    <input type="text" id="adress" name="adress">
    <input type="submit" class="btn" value="Search">
</div>

<script>

function initialize()
{
var mapProp = {
  center:new google.maps.LatLng(51.508742,-0.120850),
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
var map=new google.maps.Map(document.getElementById("googleMap")
  ,mapProp);
}

google.maps.event.addDomListener(window, 'load', initialize);


GMaps.geocode({
  address: $('#adress').val(),
  callback: function(results, status) {
    if (status == 'OK') {
      var latlng = results[0].geometry.location;
      map.setCenter(latlng.lat(), latlng.lng());
      map.addMarker({
        lat: latlng.lat(),
        lng: latlng.lng()
      });
    }
  }
});


</script>
