<?php

error_reporting(9);

include("{$_SERVER['DOCUMENT_ROOT']}/bk/lib/includes.php");

    $query = "select
                    a.*,
                    b.nome,
                    b.telefone
                from vendas a
                     left join clientes b on a.cliente = b.codigo
                where
                     (NOW() between data_pedido and DATE_ADD(data_pedido, INTERVAL 20 minutes)) and
                     valor = 0
            ";
    $result = mysqli_query($con, $query);
    while($d = mysql_fetch_object($result)){
        $mensagem = "*BK MANAUS* - Olá {$d->nome}, ficamos muito felizes com a sua visita em nossa aplicação bkmanaus.com.br. Criamos esta plataforma para lhe oferecer a mesmas vantagens da loja física e sem precisar sair do conforto de sua casa. *Estamos aguardando seu pedido*";
        echo "{$d->telefone} - {$mensagem}<br>";
    }
