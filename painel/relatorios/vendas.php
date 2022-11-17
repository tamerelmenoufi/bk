<?php
    include("../../lib/includes.php");

    $query = "select
                    a.*,
                    b.nome,
                    c.nome as loja,
                    if(data_pedido >= '2022-11-10 00:00:00', 'green','red') as cor
                from vendas a
                    left join clientes b on a.cliente = b.codigo
                    left join lojas c on a.loja = c.codigo
                where   a.deletado != '1' and
                        (operadora_situacao = 'approved' or operadora_situacao = 'Approved')
                order by data_pedido desc";
    $result = mysqli_query($con, $query);
?>
<style>
    .relatorio_vendas td, .relatorio_vendas th{
        font-size:12px;
        white-space:nowrap;
    }
</style>
<div class="col">
    <table class="relatorio_vendas table table-hover">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Loja</th>
                <th>Valor</th>
                <th>Taxa Entrega</th>
                <th>Total</th>
                <th>Forma de pagamento</th>
                <th>Data do pedido</th>
            </tr>
        </thead>
        <tbody>
<?php
    while($d = mysqli_fetch_object($result)){

        if($d->cor == 'red'){
            $style = 'style = "color:red; text-decoration:line-through;"';
        }else{
            $style = 'style = "color:green;"';
        }

?>
            <tr <?=$style?>>
                <td><?=$d->nome?></td>
                <td><?=$d->loja?></td>
                <td><?=$d->valor?></td>
                <td><?=$d->taxa_entrega?></td>
                <td><?=$d->total?></td>
                <td><?=$d->forma_pagamento?></td>
                <td><?=$d->data_pedido?></td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</div>
