<?php

include("../lib/includes.php");


    $query = "select * from vendas where
                                        situacao = 'n' and
                                        forma_pagamento = 'pix' and
                                        operadora = 'mercadopago' and
                                        operadora_situacao = 'pending'
            ";
    $result = mysqli_query($con,$query);

    while($d = mysqli_fetch_object($result)){

        echo "<pre>";
        var_dump($d);
        echo "</pre>";
        echo "<hr>";
    }
