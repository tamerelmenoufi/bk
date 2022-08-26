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

    $status = "<table border='1' style='width:100%'>";

    if($d->SEARCHING > 0){
        $status .= "<tr><td>Pedido Confirmado</td><td style='text-align:right'>".($d->SEARCHING)."</td></tr>";
    }
    if($d->GOING_TO_ORIGIN > 0){
        $status .= "<tr><td>Pedido em preparo</td><td style='text-align:right'>".($d->GOING_TO_ORIGIN)."</td></tr>";
    }
    if($d->ARRIVED_AT_ORIGIN > 0){
        $status .= "<tr><td>Entregador no estabelecimento</td><td style='text-align:right'>".($d->ARRIVED_AT_ORIGIN)."</td></tr>";
    }
    if($d->GOING_TO_DESTINATION > 0){
        $status .= "<tr><td>A entrega está a caminho</td><td style='text-align:right'>".($d->GOING_TO_DESTINATION)."</td></tr>";
    }
    if($d->ARRIVED_AT_DESTINATION > 0){
        $status .= "<tr><td>Entrega realizada</td><td style='text-align:right'>".($d->ARRIVED_AT_DESTINATION)."</td></tr>";
    }

    $staus .= '</table>';

    $d->produto_descricao .= $status;

    $dados[] = $d;
}

echo json_encode($dados);