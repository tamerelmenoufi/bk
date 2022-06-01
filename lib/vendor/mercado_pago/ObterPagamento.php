<?php

    include('classes.php');

    $PIX = new MercadoPago;

    $retorno = $PIX->ObterPagamento(22777629972);


      $dados = json_decode($retorno);
        echo "<pre>";
      print_r($dados);
      echo "</pre>";


      echo "<hr>";

      echo "STATUS: ".$dados->status;
      echo "<br>";

      echo "Metodo de pagamento: ".$dados->payment_method_id;
      echo "<br>";

      echo "Operadora: mercadopago";
      echo "<br>";

