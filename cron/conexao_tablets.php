<?php

    include("../lib/includes.php");


    echo $query = "SELECT *, date_add(ultima_conexao, interval 1 minute), if(NOW() > date_add(ultima_conexao, interval 1 minute) OR ultima_conexao = 0, '0', '1') as situacao2 FROM `lojas` where situacao = '1' and deletado != '1'";
    $result = mysqli_query($con, $query);
    echo "<br><br><br><br>";
    while($d = mysqli_fetch_object($result)){

        echo $q1 = "UPDATE lojas set online = '{$d->online}' where codigo = '{$d->codigo}'";
        echo "<hr>";
        echo $q2 = "INSERT INTO logs_conexoes set loja = '{$d->codigo}', data = NOW(), situacao = '{$d->situacao2}'";
        mysqli_query($con, $q1);
        mysqli_query($con, $q2);

    }