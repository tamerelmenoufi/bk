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

        endereco = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas";
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -34.397, lng: 150.644 },
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


        geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, (results, status) => {
            alert('STATUS:' + status);
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    $('Endereco').val(results[0].formatted_address);

                    var location = new google.maps.LatLng(latitude, longitude);
                    marker.setPosition(location);
                    map.setCenter(location);
                    map.setZoom(16);
                }
            }
        });


</script>