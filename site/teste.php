<?php
    include("../lib/includes.php");



    $cod_pedido = 33;
    echo $cod_pedido."<br>";

    $endereco_rua = 'Rua Monsenhor Coutinho';
    $endereco_numero = '600';
    $endereco_complemento = 'Edifício Maximino Correia, Apartamento 1302';
    $endereco_bairro = 'Centro';
    $endereco_cidade = 'Manaus';
    $endereco_estado = 'AM';
    $endereco_cep = '69010110';


    $json = "{
      \"previewDeliveryTime\": true,
      \"sortByBestRoute\": false,
      \"deliveries\": [
        {
          \"orderRoute\": {$cod_pedido},
          \"address\": {
            \"street\": \"{$endereco_rua}\",
            \"number\": \"{$endereco_numero}\",
            \"complement\": \"{$endereco_complemento}\",
            \"neighborhood\": \"{$endereco_bairro}\",
            \"city\": \"{$endereco_cidade}\",
            \"state\": \"{$endereco_estado}\",
            \"zipCode\": \"{$endereco_cep}\"
          },
          \"onlinePayment\": true
        }
      ]
    }";


      $mottu = new mottu;

      echo $retorno = $mottu->calculaFrete($json, '813416', $_GET['a']);


exit();

    $query1 = "select * from clientes_enderecos where cliente = '2' and deletado != '1' order by padrao desc limit 1";
    $result1 = mysqli_query($con, $query1);
    $d1 = mysqli_fetch_object($result1);


    list($lat, $lng) = explode(",", $coordenadas);
    // $q = "select * from lojas where situacao = '1' and online='1' and deletado != '1' and (time(NOW()) between hora_ini and hora_fim)";
    $q = "select *, mottu as id_mottu from lojas where codigo in(1,10)";
    $r = mysqli_query($con, $q);
    $vlopc = 0;
    if(mysqli_num_rows($r)){
        while($v = mysqli_fetch_object($r)){

            $json = "{
                \"previewDeliveryTime\": true,
                \"sortByBestRoute\": false,

                \"deliveries\": [
                    {
                    \"orderRoute\": 112233,
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

            // echo "<pre>{$json}</pre>";
            $mottu = new mottu;
            $valores = ($mottu->calculaFrete($json, $v->id_mottu, $_GET['a']));

            echo $valores;
        }
    }