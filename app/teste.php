<?php
    include("../lib/includes.php");

    // echo "Estou no teste!";
    // exit();


    // $venda = 13803;
    // $query = "select
    //                 a.*,
    //                 d.id as id_loja,
    //                 d.mottu as id_mottu,
    //                 b.nome,
    //                 b.cpf,
    //                 b.telefone,
    //                 b.email,
    //                 c.cep,
    //                 c.numero,
    //                 c.rua,
    //                 c.bairro,
    //                 c.referencia
    //             from vendas a
    //                 left join clientes b on a.cliente = b.codigo
    //                 left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
    //                 left join lojas d on a.loja = d.codigo
    //             where a.codigo = '{$venda}'";

    //             $result = mysqli_query($con, $query);
    //             $d = mysqli_fetch_object($result);

    //             echo $json = "{
    //                 \"code\": \"{$d->codigo}\",
    //                 \"fullCode\": \"bk-{$d->codigo}\",
    //                 \"preparationTime\": 0,
    //                 \"previewDeliveryTime\": false,
    //                 \"sortByBestRoute\": false,
    //                 \"deliveries\": [
    //                   {
    //                     \"code\": \"{$d->codigo}\",
    //                     \"confirmation\": {
    //                       \"mottu\": true
    //                     },
    //                     \"name\": \"{$d->nome}\",
    //                     \"phone\": \"".trim(str_replace(array(' ','-','(',')'), false, $d->telefone))."\",
    //                     \"observation\": \"{$d->observacoes}\",
    //                     \"address\": {
    //                       \"street\": \"{$d->rua}\",
    //                       \"number\": \"{$d->numeroxx}\",
    //                       \"complement\": \"{$d->referencia}\",
    //                       \"neighborhood\": \"{$d->bairro}\",
    //                       \"city\": \"Manaus\",
    //                       \"state\": \"AM\",
    //                       \"zipCode\": \"".trim(str_replace(array(' ','-'), false, $d->cep))."\"
    //                     },
    //                     \"onlinePayment\": true,
    //                     \"productValue\": {$d->total}
    //                   }
    //                 ]
    //               }";

    //             $mottu = new mottu;

    //             $retorno1 = $mottu->NovoPedido($json, $d->id_mottu);
    //             $retorno = json_decode($retorno1);

    //             print_r($retorno);

    //             if($retorno->id == 9999){
    //                 $query = "update vendas set
    //                                             deliveryId = '{$retorno->id}',
    //                                             situacao = 'p',
    //                                             GOING_TO_DESTINATION = NOW(),
    //                                             name = 'Unidade Djalma Batista',
    //                                             phone = '(92) 9843-87438'
    //                         where codigo = '{$venda}'";
    //                 mysqli_query($con, $query);
    //                 EnviarWapp('92991886570',"VENDA - Venda do pedido *{$venda}*");
    //             }else if($retorno->id){
    //                 $query = "update vendas set
    //                                             operadora = 'rede',
    //                                             operadora_situacao = 'Approved',
    //                                             data_finalizacao = NOW(),
    //                                             forma_pagamento = 'credito',
    //                                             deliveryId = '{$retorno->id}',
    //                                             situacao = 'p'
    //                             where codigo = '{$venda}'";
    //                 mysqli_query($con, $query);
    //                 EnviarWapp('92991886570',"VENDA - Venda do pedido *{$venda}*");
    //             }else{
    //                 EnviarWapp('92991886570',"VENDA - Venda do pedido *{$venda}* não gerou entrega.");
    //             }



    /////////////////////// consulta ///////////////////////////



    if($_GET['id']){
      echo "HC<br>";
      $mottu = new mottu;
      $retorno1 = $mottu->ConsultarPedido($_GET['id'],813416);
      $retorno = json_decode($retorno1);
      // echo "<pre>".var_dump($retorno)."</pre>";
      echo "codigo:".$retorno->code;

      if($retorno->code){
      $query = "update vendas set delivery_retorno = '{$retorno1}' where codigo = '{$retorno->code}'";
      mysqli_query($con,$query);
      }

      echo "<hr>";
      echo "DJ<br>";
      $mottu = new mottu;
      $retorno1 = $mottu->ConsultarPedido($_GET['id'],813383);
      $retorno = json_decode($retorno1);
      echo "<pre>".var_dump($retorno)."</pre>";

      echo "codigo:".$retorno->code;
      if($retorno->code){
      $query = "update vendas set delivery_retorno = '{$retorno1}' where codigo = '{$retorno->code}'";
      mysqli_query($con,$query);
      }
    }



?>