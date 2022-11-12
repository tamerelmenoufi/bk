<?php

    include("../lib/includes.php");

    $query = "SELECT *, date_add(ultima_conexao, interval 1 minute), if(NOW() > date_add(ultima_conexao, interval 1 minute) OR ultima_conexao = 0, '0', '1') as situacao2 FROM `lojas` where situacao = '1' and deletado != '1'";
    $result = mysqli_query($con, $query);
    $msg = false;
    while($d = mysqli_fetch_object($result)){
        $q1 = "UPDATE lojas set online = '{$d->situacao23}' where codigo = '{$d->codigo}'";
        $q2 = "INSERT INTO logs_conexoes set loja = '{$d->codigo}', data = NOW(), situacao = '{$d->situacao2}'";
        mysqli_query($con, $q1);
        mysqli_query($con, $q2);

        if(!$d->situacao2){
            $msg .= "\nLoja {$d->nome} encontra-se desconectada ao Delivery BKManaus.";
        }

    }

    $m = (date("i")*1);
    if($m%5 == 0 and $msg){
        $msg = "*ATENÇÃO* - Notificação BKManaus".$msg;
        EnviarWapp('92991886570',$msg);
    }