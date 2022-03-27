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
        map = new google.maps.Map(
            div: '#map',
        {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });
    </script>

<script>


</script>