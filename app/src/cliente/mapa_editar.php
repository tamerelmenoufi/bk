<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'coordenadas'){
        mysqli_query($con, "update clientes_enderecos set coordenadas = '{$_POST['latLng']}' where codigo = '{$_POST['codigo']}'");
        exit();
    }


    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $endereco =  "{$d->rua}, {$d->numero}, {$d->bairro}";

?>

<style>

    #map<?=$md5?> {
        position:absolute;
        left:0;
        top:0;
        height: 100%;
        width:100%;
        z-index:0;
    }

</style>

    <div id="map<?=$md5?>"></div>

    <script>

        //endereco = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas";
        endereco<?=$md5?> = "<?=$endereco?>";
        geocoder<?=$md5?> = new google.maps.Geocoder();
        map<?=$md5?> = new google.maps.Map(document.getElementById("map<?=$md5?>"), {
            zoomControl: false,
            mapTypeControl: false,
            draggable: true,
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
            draggable:true,
        });

        google.maps.event.addListener(marker<?=$md5?>, 'dragend', function(marker) {
            var latLng = marker.latLng;
            //alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)

            $.ajax({
                url:"src/cliente/mapa_editar.php",
                data:{
                    latLng,
                    codigo:'<?=$d->codigo?>',
                    acao:'coordenadas'
                },
                success:function(){

                }
            });
        });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Manaus, Amazonas, Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {

                    var latitude<?=$md5?> = results[0].geometry.location.lat();
                    var longitude<?=$md5?> = results[0].geometry.location.lng();

                    //$('Endereco').val(results[0].formatted_address);

                    var location<?=$md5?> = new google.maps.LatLng(latitude<?=$md5?>, longitude<?=$md5?>);
                    marker<?=$md5?>.setPosition(location<?=$md5?>);
                    map<?=$md5?>.setCenter(location<?=$md5?>);
                    map<?=$md5?>.setZoom(16);
                }
            }
        });


</script>