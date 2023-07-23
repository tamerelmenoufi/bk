<?php 

    include("../lib/includes.php");
    
    $query = "select a.codigo as venda, b.nome, b.telefone, a.data_pedido, a.forma_pagamento, a.operadora_situacao  from vendas a left join clientes b on a.cliente = b.codigo order by data_pedido desc limit 200";
?>


<table width="100%">

<tr>
    <td>VENDA</td>
    <td>NOME</td>
    <td>TELEFONE</td>
    <td>DATA</td>
    <td>PAGAMENTO</td>
    <td>SITUACAO</td>
</tr>

<?php


    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>
<tr>
    <td><?=$d->venda?></td>
    <td><?=$d->nome?></td>
    <td><?=$d->telefone?></td>
    <td><?=$d->data_pedido?></td>
    <td><?=$d->forma_pagamento?></td>
    <td><?=$d->operadora_situacao?></td>
</tr>
<?php

    }
?>

</table>