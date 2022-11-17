<?php
    include("../../lib/includes.php");

    $query = "select
                    a.*,
                    b.nome,
                    b.telefone,
                    if(a.data_pedido >= '2022-11-10 00:00:00', 'green','red') as cor
                from vendas a
                    left join clientes b on a.cliente = b.codigo
                where   a.deletado != '1' and
                        (a.operadora_situacao = 'approved' or a.operadora_situacao != 'Approved')
                order by a.data_pedido desc";
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
                <th>Telefone</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
<?php
    $valor = $taxa = $total = 0;
    while($d = mysqli_fetch_object($result)){

        if($d->cor == 'red'){
            $style = 'style = "color:red; text-decoration:line-through;"';
        }else{
            $style = 'style = "color:green;"';
            $valor = $valor + $d->valor;
            $taxa = $taxa + $d->taxa_entrega;
            $total = $total + $d->total;
        }

?>
            <tr <?=$style?>>
                <td><?=$d->nome?></td>
                <td><?=$d->telefone?></td>
                <td><?=$d->data_pedido?></td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</div>
