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


  map = new GMaps({
            div: '#map',
            zoom: 16,
            lat: -3.098170162749315,
            lng: -60.010407004276466,
        });


  $("#submit").click(function(){
    endereco = $('#adress').val();
    alert(endereco);

    GMaps.geocode({
        address: $('#adress').val(),
        callback: function(results, status) {

            if (status == 'OK') {
                var latlng = results[0].geometry.location;
                map.setCenter(latlng.lat(), latlng.lng());

                map.addMarker({ // Função para adicionar o marcador
                    lat: latlng.lat(),
                    lng: latlng.lng(),
                });

            }
        }
    });

  });




</script>