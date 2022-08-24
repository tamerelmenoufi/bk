<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT
                a.codigo,
                a.situacao,
                c.nome
        FROM vendas a
        left join clientes c on a.cliente = c.codigo
        where a.situacao in ('p','i') and a.operadora_situacao = 'Approved' and a.deletado != '1' and a.loja = '{$_POST['loja']}'";

$query = "SELECT
                a.codigo,
                a.situacao,
                c.nome
                FROM vendas a
                left join clientes c on a.cliente = c.codigo
        where a.data_pedido LIKE '%".date("Y-m-d")."%' and a.deletado != '1' and a.situacao = 'n'";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $pedido = '#'.str_pad($d->codigo , 5 , '0' , STR_PAD_LEFT);
    $dados[] = ['codigo'=> $d->codigo, 'pedido' => $pedido, 'cliente' => $d->nome, 'situacao' => $d->situacao];
}

echo json_encode($dados);