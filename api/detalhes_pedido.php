<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT a.*, c.categoria as nome_categoria, v.situacao, 'DESCRIÇÃO TESTE' as produto_descricao FROM vendas_produtos a left join produtos b on a.produto = b.codigo left join vendas v on a.venda = v.codigo left join categorias c on b.categoria = c.codigo where a.venda = '{$_POST['pedido']}' and a.deletado != '1'";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){

    $status = false;

    if($d->SEARCHING > 0){
        $status .= "<p>Confirmado Pelo estabelecimento <small>".dataBr($d->$d->SEARCHING)."</small></p>";
    }
    if($d->GOING_TO_ORIGIN > 0){
        $status .= "<p>Seu pedido está em preparo <small>".($d->$d->GOING_TO_ORIGIN)."</small></p>";
    }
    if($d->ARRIVED_AT_ORIGIN > 0){
        $status .= "<p>Pedido sendo embalado para entrega <small>".($d->$d->ARRIVED_AT_ORIGIN)."</small></p>";
    }
    if($d->GOING_TO_DESTINATION > 0){
        $status .= "<p>A entrega está a caminho <small>".($d->$d->GOING_TO_DESTINATION)."</small></p>";
    }
    if($d->ARRIVED_AT_DESTINATION > 0){
        $status .= "<p>Entrega realizada <small>".($d->$d->ARRIVED_AT_DESTINATION)."</small></p>";
    }

    $d->produto_descricao .= $status;

    $dados[] = $d;
}

echo json_encode($dados);