<?php

    include('classes.php');

    $PIX = new MercadoPago;
    // 22777629972
    $retorno = $PIX->ObterPagamento(101770366370);


      $dados = json_decode($retorno);

      print_r($dados);


