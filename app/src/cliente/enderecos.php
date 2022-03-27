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
        z-index:0;
    }

</style>

    <div id="map"></div>

    <script>
        local = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas, Brasil";
        map = new google.maps.Map(document.getElementById("map"), {
            address: local,
            //center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });

        marker = new google.maps.Marker({
            position: { lat: -34.397, lng: 150.644 },
            map,
            title: "Hello World!",
            draggable:true,
        });


        google.maps.event.addListener(marker, 'dragend', function(marker) {
            var latLng = marker.latLng;
            alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
        });

    </script>

<script>


</script>