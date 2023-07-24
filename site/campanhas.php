<?php 

    include("../lib/includes.php");
    
    $query = "select a.codigo as venda, b.nome, b.telefone, a.valor, a.data_pedido, a.forma_pagamento, a.operadora_situacao  from vendas a left join clientes b on a.cliente = b.codigo where b.telefone != '' order by data_pedido desc limit 200";
?>


<table width="100%">

<tr>
    <td>VENDA</td>
    <td>NOME</td>
    <td>TELEFONE</td>
    <td>DATA</td>
    <td>VALOR</td>
    <td>PAGAMENTO</td>
    <td>SITUAÇÃO</td>
</tr>

<?php


    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

        $nome = explode(" ",trim($d->nome));
        $fone = str_replace(array(' ','(',')','-'), false, $d->telefone);
?>
<tr>
    <td><?=$d->venda?></td>
    <td><?=$d->nome?></td>
    <td><a href="https://api.whatsapp.com/send?phone=55<?=$fone?>&text=Olá <?=$nome[0]?>,\nÉ da equipe Burguer King Manaus\nPodemos ajudar na finalização do seu pedido?"><?=$d->telefone?></a></td>
    <td><?=$d->data_pedido?></td>
    <td><?=$d->valor?></td>
    <td><?=$d->forma_pagamento?></td>
    <td><?=$d->operadora_situacao?></td>
</tr>
<?php

    }
?>

</table>