<?php

    include('classes.php');

    $PIX = new MercadoPago;

    $retorno = $PIX->ObterPagamento(22777629972);


      $dados = json_decode($retorno);

      echo "<hr>";

      echo "ID: ".$dados->id;
      echo "<br>";

      echo "STATUS: ".$dados->status;
      echo "<br>";

      echo "Metodo de pagamento: ".$dados->payment_method_id;
      echo "<br>";

      echo "Retorno: ";
      echo "<pre>{$retorno}</pre>";
      echo "<br>";