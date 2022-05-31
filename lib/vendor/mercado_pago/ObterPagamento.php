<?php

    include('classes.php');

    $PIX = new MercadoPago;

    $retorno = $PIX->ObterPagamento(22777629972);


      $dados = json_decode($retorno);
        echo "<pre>";
      print_r($dados);
      echo "</pre>";

