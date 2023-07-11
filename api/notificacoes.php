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
                     data_pedido > DATE_SUB(NOW(), INTERVAL 20 MINUTE) and
                     valor = 0 and
                     a.cliente > 0 and
                     a.notificacoes->'$.n1' IS NULL
            ";
    $result = mysqli_query($con, $query);
    $msg = [];
    while($d = mysqli_fetch_object($result)){
        $mensagem = "*BK MANAUS* - Olá {$d->nome}, ficamos muito felizes com a sua visita em nossa aplicação bkmanaus.com.br. Criamos esta plataforma para lhe oferecer a mesmas vantagens da loja física e sem precisar sair do conforto de sua casa. *Estamos aguardando seu pedido*";
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