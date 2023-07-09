<?php

error_reporting(9);

include("{$_SERVER['DOCUMENT_ROOT']}/bk/lib/includes.php");

    $query = "select
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

        // Verificar o tempo
        // list($dpData, $dpHora) = explode(" ",$d->data_pedido);
        // list($dpY,$dpM, $dpD) = explode("")
        // list($dpY,$dpM, $dpD, $dpH, $dpI, $dpS)
        $agora = mktime();
        $limite = mktime(
                        date("H",$data_pedido),
                        date("i",$data_pedido) + 30,
                        date("s",$data_pedido),
                        date("m",$data_pedido),
                        date("d",$data_pedido),
                        date("Y",$data_pedido)
                      );
        echo "$agora > $limite<br>";
        if($agora > $limite){
          echo $d->codigo."<br>";
        }else{

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
                                operadora_retorno = '{$operadora_retorno}'
                            where codigo = '{$d->codigo}'
                        ");

            $json = '{
                "code": "'.$d->codigo.'",
                "fullCode": "bk-'.$d->codigo.'",
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


            $mottu = new mottu;

            $retorno1 = $mottu->NovoPedido($json, $d->id_mottu);
            $retorno = json_decode($retorno1);

            // var_dump($retorno1);

            if($retorno->id){
              $query = "update vendas set deliveryId = '{$retorno->id}', situacao = 'p', data_finalizacao = NOW(), SEARCHING = NOW() where codigo = '{$d->codigo}'";
              mysqli_query($con, $query);
              EnviarWapp('92991886570',"VENDA - Código do pedido (CRON) *{$d->codigo}* ID: {$retorno->id}");
            }else{
              EnviarWapp('92991886570',"VENDA - Código do pedido (CRON) *{$d->codigo}* ID não foi gerado");
            }

            //*/
            // DADOS DE SOLICITAÇÃO DA ENTREGA

        }else{
          if($d->tentativas_pagamento <= 4){
            mysqli_query($con, "update vendas set
                operadora_situacao = '{$retorno->status}',
                operadora_retorno = '{$operadora_retorno}',
                tentativas_pagamento = (tentativas_pagamento + 1)
                where codigo = '{$d->codigo}'
            ");
            EnviarWapp('92991886570',"VENDA - Código do pedido (CRON) *{$d->codigo}* status *{$retorno->status}*");
          }
        }
      }

    }
