<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'coordenadas'){
        $query = "update clientes_enderecos set coordenadas = '{$_POST['coordenadas']}' where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        exit();
    }


    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $endereco =  "{$d->rua}, {$d->numero}, {$d->bairro}";

    $coordenadas = explode(',', $d->coordenadas);

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

    <div id="map<?=$md5?>"><?php echo $d->coordenadas; ?></div>

    <script>

        //endereco = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas";
        coordenadas<?=$md5?> = '<?=$d->coordenadas?>';
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
            <?php
            if($d->coordenadas){
            ?>
            center: { lat: <?=$coordenadas[0]?>, lng: <?=$coordenadas[1]?> },
            zoom: 16,

            <?php
            }
            ?>
        }
        /*{
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        }*/
        );

        marker<?=$md5?> = new google.maps.Marker({
            position: { lat: <?=$coordenadas[0]?>, lng: <?=$coordenadas[1]?> },
            map:map<?=$md5?>,
            title: "Hello World!",
            draggable:true,
        });

        google.maps.event.addListener(marker<?=$md5?>, 'dragend', function(marker) {
            var latLng = marker.latLng;
            //alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
            coordenadas = `{${latLng.lat()},${latLng.lng()}}`;
            $.ajax({
                url:"src/cliente/mapa_editar.php",
                type:"POST",
                data:{
                    coordenadas,
                    codigo:'<?=$d->codigo?>',
                    acao:'coordenadas'
                },
                success:function(dados){

                }
            });
        });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Manaus, Amazonas, Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                alert(coordenadas<?=$md5?>);
                if (results[0] && !coordenadas<?=$md5?>) {

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