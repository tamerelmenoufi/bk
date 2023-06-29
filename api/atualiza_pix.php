<?php

error_reporting(9);

include("{$_SERVER['DOCUMENT_ROOT']}/bk/lib/includes.php");

    echo $query = "select
                    a.*,
                    d.id as id_loja,
                    d.mottu as id_mottu,
                    b.nome,
                    b.cpf,
                    b.telefone,
                    b.email,
                    c.cep,
                    c.numero,
                    c.rua,
                    c.bairro,
                    c.referencia
                from vendas a
                    left join clientes b on a.cliente = b.codigo
                    left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
                    left join lojas d on a.loja = d.codigo
                where
                    (a.situacao = 'n' and
                    a.forma_pagamento = 'pix' and
                    a.operadora = 'mercadopago' and
                    a.operadora_id != '' and
                    a.operadora_situacao = 'pending')
            ";
    $result = mysqli_query($con, $query);

    while($d = mysqli_fetch_object($result)){

        echo "<pre>";
        var_dump($d);
        echo "</pre>";
        echo "<hr>";

        $PIX = new MercadoPago;
        $retorno = $PIX->ObterPagamento($d->operadora_id);
        $operadora_retorno = $retorno;
        $retorno = json_decode($retorno);

        echo "<p>".date("d/m/Y H:i:s")."<br>Pagamento: ".$retorno->status."</p>";

        if($retorno->status == 'approved'){
            //Aqui entra a solicitação da Bee
            // e tbm a mudança de status para pedido em produção

            mysqli_query($con, "update vendas set
                                operadora_situacao = '{$retorno->status}',
                                operadora_retorno = '{$operadora_retorno}',
                                situacao = 'p'
                            where codigo = '{$d->codigo}'
                        ");

            $json = '{
                "code": "'.$d->codigo.'",
                "fullCode": "bk-{'.$d->codigo.'",
                "preparationTime": 0,
                "previewDeliveryTime": false,
                "sortByBestRoute": false,
                "deliveries": [
                  {
                    "code": "'.$d->codigo.'",
                    "confirmation": {
                      "mottu": true
                    },
                    "name": "'.$d->nome.'",
                    "phone": "'.trim(str_replace(array(' ','-','(',')'), false, $d->telefone)).'",
                    "observation": "'.$d->observacoes.'",
                    "address": {
                      "street": "'.$d->rua.'",
                      "number": "'.$d->numero.'",
                      "complement": "'.$d->referencia.'",
                      "neighborhood": "'.$d->bairro.'",
                      "city": "Manaus",
                      "state": "AM",
                      "zipCode": "'.trim(str_replace(array(' ','-'), false, $d->cep)).'"
                    },
                    "onlinePayment": true,
                    "productValue": '.$d->total.'
                  }
                ]
              }';


              echo 'json';
            $mottu = new mottu;

            $retorno1 = $mottu->NovoPedido($json, $d->id_mottu);
            $retorno = json_decode($retorno1);

            var_dump($retorno1);

            $query = "update vendas set deliveryId = '{$retorno->id}', situacao = 'p', data_finalizacao = NOW() where codigo = '{$d->codigo}'";
            mysqli_query($con, $query);

            EnviarWapp('92991886570',"VENDA - Código do pedido (CRON) *{$d->codigo}*");
            //*/
            // DADOS DE SOLICITAÇÃO DA ENTREGA

        }else{
            mysqli_query($con, "update vendas set
                operadora_situacao = '{$retorno->status}',
                operadora_retorno = '{$operadora_retorno}'
                where codigo = '{$d->codigo}'
            ");
            EnviarWapp('92991886570',"VENDA - Código do pedido (CRON) *{$d->codigo}* status *{$retorno->status}*");
        }

    }
