<?php

error_reporting(9);

include("{$_SERVER['DOCUMENT_ROOT']}/bk/lib/includes.php");

    // Envio para os visitantes no intervalo de 10 minutos
    $query = "select
                    a.*,
                    b.nome,
                    b.telefone
                from vendas a
                     left join clientes b on a.cliente = b.codigo
                where
                     data_pedido > DATE_SUB(NOW(), INTERVAL 5 MINUTE) and
                     valor = 0 and
                     a.cliente > 0 and
                     a.notificacoes->'$.n1' IS NULL
            ";
    $result = mysqli_query($con, $query);
    $msg = [];
    while($d = mysqli_fetch_object($result)){
        $mensagem = "*BK MANAUS* - Olá {$d->nome}, ficamos muito felizes com a sua visita em nossa aplicação bkmanaus.com.br. Criamos esta plataforma para lhe oferecer as mesmas vantagens nas lojas físicas e sem precisar sair do conforto de sua casa. *Estamos aguardando seu pedido*";
        echo "<br>{$d->telefone} - {$mensagem}";
        $msg[] = [
            'telefone' => '92991886570', //$d->telefone,
            'mensagem' => $mensagem
        ];
        mysqli_query($con, "update vendas set notificacoes = JSON_SET(if(notificacoes > 0,notificacoes,'{}'), '$.n1', '1') where codigo = '{$d->codigo}'");
    }

    foreach($msg as $ind => $val){
        EnviarWapp($val['telefone'], $val['mensagem']);
    }


    // Visitas que preencheram o carrinho de compras
    $query = "select
                    a.*,
                    b.nome,
                    b.telefone
                from vendas a
                     left join clientes b on a.cliente = b.codigo
                where
                     data_pedido > DATE_SUB(NOW(), INTERVAL 90 MINUTE) and
                     valor > 0 and
                     a.operadora_situacao != '' and
                     a.operadora_situacao != 'approved' and
                     a.cliente > 0 and
                     a.notificacoes->'$.n2' IS NULL
            ";
    $result = mysqli_query($con, $query);
    $msg = [];
    while($d = mysqli_fetch_object($result)){
        $mensagem = "*BK MANAUS* - Olá {$d->nome}, ficamos muito felizes com a sua visita em nossa aplicação bkmanaus.com.br. Criamos esta plataforma para lhe oferecer as mesmas vantagens nas lojas físicas e sem precisar sair do conforto de sua casa. Falta pouco para finalizar sua compra. *Aguardamos seu pedido*";
        echo "<br>{$d->telefone} - {$mensagem}";
        $msg[] = [
            'telefone' => '92991886570', //$d->telefone,
            'mensagem' => $mensagem
        ];
        mysqli_query($con, "update vendas set notificacoes = JSON_SET(if(notificacoes > 0,notificacoes,'{}'), '$.n2', '1') where codigo = '{$d->codigo}'");
    }

    foreach($msg as $ind => $val){
        EnviarWapp($val['telefone'], $val['mensagem']);
    }