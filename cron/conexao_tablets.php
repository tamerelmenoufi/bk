<?php

    include("../lib/includes.php");

    $query = "SELECT *, date_add(ultima_conexao, interval 1 minute), if(NOW() > date_add(ultima_conexao, interval 1 minute) OR ultima_conexao = 0, '0', '1') as situacao2 FROM `lojas` where situacao = '1' and deletado != '1'";
    $result = mysqli_query($con, $query);
    $msg = [];
    $numeros = [];
    $numerosp = [];
    while($d = mysqli_fetch_object($result)){
        $q1 = "UPDATE lojas set online = '{$d->situacao2}' where codigo = '{$d->codigo}'";
        $q2 = "INSERT INTO logs_conexoes set loja = '{$d->codigo}', data = NOW(), situacao = '{$d->situacao2}'";
        mysqli_query($con, $q1);
        mysqli_query($con, $q2);

        if(!$d->situacao2){
            $msg[] = " *{$d->nome}* ";
            $numerosp[] = $d->telefone;
        }
    }

    $m = (date("i")*1);
    $h = (date("H")*1);

    $numeros[] = '92991886570';
    $numeros[] = '92988020814';
    $numeros[] = '92984124929';

    // print_r($numeros);
    // echo "<br>".$msg = "*ATENÇÃO* - Notificação BKManaus. As lojas a seguir encontram-se desconectadas: ".implode(", ",$msg);

    if($m%15 == 0 and 11 <= $h and $h <= 23 and $msg){

        $msgp = "*ATENÇÃO* - Notificação BKManaus. A loja [loja] encontra-se desconectada do Delivery. Favor ativar o Tablet!";
        // $numerosp[] = '92991886570';
        for($i=0;$i<count($numerosp);$i++){
            $m = str_replace('[loja]', $msg[$i], $msgp );
            EnviarWapp($numerosp[$i], $m);
        }

        $msg = "*ATENÇÃO* - Notificação BKManaus. As lojas a seguir encontram-se desconectadas: ".implode(", ",$msg);
        for($i=0;$i<count($numeros);$i++){
            EnviarWapp($numeros[$i], $msg);
        }

    }