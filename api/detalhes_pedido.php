<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT
                a.*,
                c.categoria as nome_categoria,
                v.situacao,
                v.SEARCHING,
                v.GOING_TO_ORIGIN,
                v.ARRIVED_AT_ORIGIN,
                v.GOING_TO_DESTINATION,
                v.ARRIVED_AT_DESTINATION
        FROM vendas_produtos a
            left join produtos b on a.produto = b.codigo
            left join vendas v on a.venda = v.codigo
            left join categorias c on b.categoria = c.codigo
        where a.venda = '{$_POST['pedido']}' and a.deletado != '1'";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){

    $status = "<table border='0' style='width:100%'>";

    if($d->SEARCHING > 0){
        $status .= "<tr><td>Confirmado Pelo estabelecimento</td><td>".($d->SEARCHING)."</td></tr>";
    }
    if($d->GOING_TO_ORIGIN > 0){
        $status .= "<tr><td>Seu pedido está em preparo</td><td>".($d->GOING_TO_ORIGIN)."</td></tr>";
    }
    if($d->ARRIVED_AT_ORIGIN > 0){
        $status .= "<tr><td>Pedido sendo embalado para entrega</td><td>".($d->ARRIVED_AT_ORIGIN)."</td></tr>";
    }
    if($d->GOING_TO_DESTINATION > 0){
        $status .= "<tr><td>A entrega está a caminho</td><td>".($d->GOING_TO_DESTINATION)."</td></tr>";
    }
    if($d->ARRIVED_AT_DESTINATION > 0){
        $status .= "<tr><td>Entrega realizada</td><td>".($d->ARRIVED_AT_DESTINATION)."</td></tr>";
    }

    $staus .= '</table>';

    $d->produto_descricao .= $status;

    $dados[] = $d;
}

echo json_encode($dados);