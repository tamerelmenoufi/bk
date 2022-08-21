<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT
                a.codigo,
                c.nome
        FROM vendas a
        left join clientes c on a.cliente = c.codigo
        where a.situacao in ('p','i') and a.operadora_situacao = 'Approved' and a.deletado != '1' and a.loja = '{$_POST['loja']}'";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $pedido = '#'.str_pad($d->codigo , 5 , '0' , STR_PAD_LEFT);
    $dados[] = ['codigo'=> $d->codigo, 'pedido' => $pedido, 'cliente' => $d->nome];
}

echo json_encode($dados);