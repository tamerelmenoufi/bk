<?php
    include("../../../lib/includes.php");

    $md5 = md5($md5.$_GET['p']);
?>

<style>

    #map<?=$md5?> {
        position:relative;
        height: 100%;
        width:100%;
        z-index:0;
    }

</style>

    <div id="map<?=$md5?>"></div>

    <script>

        endereco<?=$md5?> = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas";
        geocoder<?=$md5?> = new google.maps.Geocoder();
        map<?=$md5?> = new google.maps.Map(document.getElementById("map<?=$md5?>"), {
            zoomControl: false,
            mapTypeControl: false,
            draggable: false,
            scaleControl: false,
            scrollwheel: false,
            navigationControl: false,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            fullscreenControl: false,
        }
        /*{
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        }*/
        );

        // marker<?=$md5?> = new google.maps.Marker({
        //     position: { lat: -34.397, lng: 150.644 },
        //     map<?=$md5?>,
        //     title: "Hello World!",
        //     draggable:false,
        // });

        // google.maps.event.addListener(marker, 'dragend', function(marker) {
        //     var latLng = marker.latLng;
        //     alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
        // });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {

                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    //$('Endereco').val(results[0].formatted_address);

                    marker<?=$md5?> = new google.maps.Marker();

                    var location = new google.maps.LatLng(latitude, longitude);
                    marker<?=$md5?>.setPosition(location);
                    map<?=$md5?>.setCenter(location);
                    map<?=$md5?>.setZoom(16);
                }
            }
        });


</script>