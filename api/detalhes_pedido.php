<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

if($_GET) $_POST = $_GET;

$query = "SELECT
                a.*,
                concat( a.produto_nome, ' [', a.quantidade ,' x R$', a.valor_unitario , ' = R$' , a.valor_total, '] ' ) as produto_nome,
                b.categoria,
                b.descricao,
                concat(c.prefixo,' ',c.categoria) as nome_categoria,
                v.situacao,
                v.SEARCHING,
                v.GOING_TO_ORIGIN,
                v.ARRIVED_AT_ORIGIN,
                v.GOING_TO_DESTINATION,
                v.ARRIVED_AT_DESTINATION,
                v.name,
                v.phone,
                v.loja,
                v.retirada_local,
                e.entrega_gratis,
                cl.nome as cliente_nome,
                cl.telefone as cliente_telefone,
                concat(trim(e.rua), ', ',  trim(e.numero), ', ', trim(e.bairro), ', ', trim(e.complemento), ', ', trim(e.referencia)) as endereco
        FROM vendas_produtos a
            left join produtos b on a.produto = b.codigo
            left join vendas v on a.venda = v.codigo
            left join categorias c on b.categoria = c.codigo
            left join clientes cl on v.cliente = cl.codigo
            left join clientes_enderecos e on v.cliente = e.cliente and e.padrao = '1'
        where a.venda = '{$_POST['pedido']}' and a.deletado != '1'";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){

    $descricao = [];
    if($d->categoria == 8){
        $q = "select * from produtos where codigo in ({$d->descricao})";
        $r = mysqli_query($con, $q);
        while($d1 = mysqli_fetch_object($r)){
            $descricao[] = "{$d1->produto}";
        }
        if($descricao) $descricao = implode(", ",$descricao);
    }


    $status = "<table border='1' style='width:100%'>";

    if($d->SEARCHING > 0){
        // $status .= "<tr><td>Pedido Confirmado</td><td style='text-align:right'>".formata_datahora($d->SEARCHING)."</td></tr>";
    }
    if($d->GOING_TO_ORIGIN > 0){
        // $status .= "<tr><td>Pedido em preparo</td><td style='text-align:right'>".formata_datahora($d->GOING_TO_ORIGIN)."</td></tr>";
    }
    if($d->ARRIVED_AT_ORIGIN > 0){
        // $status .= "<tr><td>Entregador no estabelecimento</td><td style='text-align:right'>".formata_datahora($d->ARRIVED_AT_ORIGIN)."</td></tr>";
    }
    if($d->GOING_TO_DESTINATION > 0){
        // $status .= "<tr><td>A entrega está a caminho</td><td style='text-align:right'>".formata_datahora($d->GOING_TO_DESTINATION)."</td></tr>";
    }
    if($d->ARRIVED_AT_DESTINATION > 0){
        // $status .= "<tr><td>Entrega realizada</td><td style='text-align:right'>".formata_datahora($d->ARRIVED_AT_DESTINATION)."</td></tr>";
    }

    if($d->name and $d->phone){
        $status .= "<tr style='margin-top:10px;'><td><b>Entregador<b></td><td style='text-align:right; padding-right:55px;'><b>Telefone</b></td></tr>";
        $status .= "<tr><td>".$d->name."</td><td style='text-align:right'>".($d->phone)."</td></tr>";
    }

    // $status .= "<tr><td colspan = '2' style='margin-top:10px; margin-bottom:5px; background-color:green; color:#fff;'><b>Cliente:</b> ".$d->cliente_nome." - ".$d->cliente_telefone."</td></tr>";

    if($d->entrega_gratis){
        $status .= "<tr><td colspan = '2' style='margin-top:10px; margin-bottom:5px; background-color:green; color:#fff;'><b>Entrega Grátis para o Endereço:</b><br style='margin-bottom:5px;'>".$d->endereco."</td></tr>";

    }

    if($d->retirada_local){
        $status .= "<tr><td colspan = '2' style='margin-top:10px; margin-bottom:5px; background-color:green; color:#fff; text-align:center'><b>PEDIDO SERÁ RETIRADO PELO CLIENTE</b></td></tr>";

    }

        // $status .= "<tr><td colspan = '2' style='margin-top:20px; margin-bottom:5px; text-align:center;'>
        // <a href='https://app.bkmanaus.com.br/app.php?l={$d->loja}' target='_blank' style='background-color:green; padding:10px; color:#fff; text-align:center; border-radius:20px;'>CONCLUIR PEDIDO</a>
        // </td></tr>";
    $status .= '</table>';

    $d->status_pedido = $status;
    if($descricao) $d->produto_nome = $d->produto_nome." (".$descricao.")";


    $dados[] = $d;
}


// $novo = [
// 'codigo' => '',
// 'venda' => '',
// 'cliente' => '',
// 'mesa' => '',
// 'produto_nome' => '',
// 'produto_descricao' => '',
// 'valor_unitario' => '',
// 'quantidade' => '',
// 'valor_total' => '',
// 'produto' => '',
// 'data' => '',
// 'ordem' => '',
// 'situacao' => '',
// 'deletado' => '',
// 'produto_nome' => '',
// 'categoria' => '',
// 'descricao' => '',
// 'nome_categoria' => '',
// 'situacao' => '',
// 'SEARCHING' => '',
// 'GOING_TO_ORIGIN' => '',
// 'ARRIVED_AT_ORIGIN' => '',
// 'GOING_TO_DESTINATION' => '',
// 'ARRIVED_AT_DESTINATION' => '',
// 'name' => '',
// 'phone'	=> '',
// 'loja' => '',
// 'retirada_local' => '',
// 'entrega_gratis' => '',
// 'cliente_nome' => '',
// 'cliente_telefone' => '',
// 'endereco' => '',
// ];

echo json_encode($dados);