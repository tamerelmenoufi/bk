<?php
    include("../../../lib/includes.php");

    $query1 = "select * from clientes_enderecos where cliente = '2' and deletado != '1' order by padrao desc limit 1";
    $result1 = mysqli_query($con, $query1);
    $d1 = mysqli_fetch_object($result1);

    $mottu = new mottu;
    list($lat, $lng) = explode(",", $coordenadas);
    // $q = "select * from lojas where situacao = '1' and online='1' and deletado != '1' and (time(NOW()) between hora_ini and hora_fim)";
    echo $q = "select * from lojas where situacao = '1' and deletado != '1'";
    $r = mysqli_query($con, $q);
    $vlopc = 0;
    if(mysqli_num_rows($r)){
        while($v = mysqli_fetch_object($r)){

            echo $json = "{
                \"previewDeliveryTime\": true,
                \"sortByBestRoute\": false,

                \"deliveries\": [
                    {
                    \"orderRoute\": {$_SESSION['AppVenda']},
                    \"address\": {
                        \"street\": \"{$d1->rua}\",
                        \"number\": \"{$d1->numero}\",
                        \"complement\": \"{$d1->complemento}\",
                        \"neighborhood\": \"{$d1->bairro}\",
                        \"city\": \"Manaus\",
                        \"state\": \"AM\",
                        \"zipCode\": \"".str_replace(array(' ','-'), false, $d1->cep)."\"
                    },
                    \"onlinePayment\": true
                    }
                ]
                }";


            $valores = json_decode($mottu->calculaFrete($json, $v->mottu));

            var_dump($valores);
        }
    }