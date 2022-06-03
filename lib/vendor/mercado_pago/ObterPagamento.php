<?php

  if(!$_POST['id']) exit();

  include("../../includes.php");

    $PIX = new MercadoPago;

    $retorno = $PIX->ObterPagamento($_POST['id']);


      $dados = json_decode($retorno);

      // echo "<hr>";

      // echo "ID: ".$dados->id;
      // echo "<br>";

      // echo "STATUS: ".$dados->status;
      // echo "<br>";

      // echo "Metodo de pagamento: ".$dados->payment_method_id;
      // echo "<br>";

      // echo "Retorno: ";
      // echo "<pre>{$retorno}</pre>";
      // echo "<br>";


      $operadora_id = $dados->id;
      $forma_pagamento = $dados->payment_method_id;
      $operadora_situacao = $dados->status;
      $qrcode = $dados->point_of_interaction->transaction_data->qr_code;
      $qrcode_img = $dados->point_of_interaction->transaction_data->qr_code_base64;


    if($operadora_id){

        echo $q = "update vendas set
                                            forma_pagamento = '{$forma_pagamento}',
                                            operadora_situacao = '{$operadora_situacao}',
                                            operadora_retorno = '{$retorno}'
                            where operadora_id = '{$operadora_id}'
                ";
        mysqli_query($con, $q);

    }
