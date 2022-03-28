<?php
    include("../../../lib/includes.php");

    $md5 = md5($md5.$_POST['p']);
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

        endereco<?=$md5?> = "<?=base64_decode($_POST['e'])?>";
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

        marker<?=$md5?> = new google.maps.Marker({
            position: { lat: -34.397, lng: 150.644 },
            map:map<?=$md5?>,
            title: "Hello World!",
            draggable:false,
        });

        // google.maps.event.addListener(marker<?=$md5?>, 'dragend', function(marker) {
        //     var latLng = marker.latLng;
        //     alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
        // });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Manaus, Amazonas, Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {

                    var latitude<?=$md5?> = results[0].geometry.location.lat();
                    var longitude<?=$md5?> = results[0].geometry.location.lng();

                    var location<?=$md5?> = new google.maps.LatLng(latitude<?=$md5?>, longitude<?=$md5?>);
                    marker<?=$md5?>.setPosition(location<?=$md5?>);
                    map<?=$md5?>.setCenter(location<?=$md5?>);
                    map<?=$md5?>.setZoom(16);
                }
            }
        });


</script>