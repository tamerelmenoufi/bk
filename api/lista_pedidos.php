<?php

include("../lib/includes.php");

$query = "SELECT a.codigo, c.nome FROM vendas a left join clientes c on a.cliente = c.codigo";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $pedido = '#'.str_pad($d->codigo , 5 , '0' , STR_PAD_LEFT);
    $dados[] = ['codigo'=> $d->codigo, 'pedido' => $pedido, 'cliente' => $d->nome];
}

echo json_encode($dados);