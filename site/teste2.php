<?php


    $cod_pedido = 33;

    $origem_rua = 'Rua Bruxelas';
    $origem_numero = '15';
    $origem_complemento = 'Em frente ao PAC';
    $origem_bairro = 'Planalto';
    $origem_cidade = 'Manaus';
    $origem_estado = 'AM';
    $origem_cep = '69045260';

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

    $h = [
            'c' => 'F74C23D9DF05489E9A5185EB5F7DEE28',
            'url' => 'https://integrations.mottu.cloud/delivery'
    ];


    $p = [
            'c' => '8C0CC3BEBE314FD1830520A2A09AC8F8',
            'url' => 'https://integrations.mottu.io/delivery'
    ];

    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'content' => $json,
            'header' => "Content-Type: application/json, x-api-token: {$h['c']}",
        )
    ));

    $result = file_get_contents($h['url'], null, $context);
    $result = json_decode($result);
    var_dump($result);
