<?php

    include('classes.php');

    $PIX = new MercadoPago;
    $retorno = $PIX->Transacao('{
        "transaction_amount": 100,
        "description": "Combo Da Felicidade",
        "payment_method_id": "pix",
        "payer": {
          "email": "tamer.menoufi@gmail.com",
          "first_name": "Tamer",
          "last_name": "Elmenoufi",
          "identification": {
              "type": "CPF",
              "number": "60110970225"
          },
          "address": {
              "zip_code": "69010110",
              "street_name": "Rua Monsehor Coutinho",
              "street_number": "600",
              "neighborhood": "Centro",
              "city": "Manaus",
              "federal_unit": "AM"
          }
        }
      }');


      echo $retorno;