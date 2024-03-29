<?php
include("../../../lib/includes.php");

$situacao = "p";

$column = [
    "codigo",
    "nome",
    "data_pedido",
    "forma_pagamento",
    "total"
];

$query = "SELECT v.*, c.nome, c.telefone FROM vendas v "
    . "INNER JOIN clientes c ON c.codigo = v.cliente "
    . "WHERE v.deletado != '1' AND v.situacao = '{$situacao}' ";

if (isset($_POST["search"]["value"])) {
    $valor = trim($_POST["search"]["value"]);

    $query .= "AND (c.nome LIKE '%{$valor}%' "
        . "OR c.telefone LIKE '%{$valor}%' "
        . "OR v.data_pedido LIKE '%{$valor}%' "
        . "OR v.forma_pagamento LIKE '%{$valor}%' "
        . "OR v.valor LIKE '%{$valor}%')";
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY v.codigo DESC ';
}

$query1 = '';

if ($_POST['length'] != -1) $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$result = mysqli_query($con, $query);

$number_filter_row = mysqli_num_rows($result);

$result1 = mysqli_query($con, $query . $query1);

$data = [];

$i = $_POST["start"] + 1;

foreach ($result1 as $row) {
    $sub_array = array();

    #$sub_array[] = $i++;
    $sub_array[] = $row['codigo'];
    $sub_array[] = $row['nome'] ?: $row['telefone'];
    $sub_array[] = formata_datahora($row['data_pedido'], DATA_HM);
    $sub_array[] = getFormaPagamentoOptions($row['forma_pagamento']) ?: "(Não definido)";
    $sub_array[] = '<button visualizar type="button" class="btn btn-link btn-sm" data-codigo="' . $row["codigo"] . '"><i class="fa fa-eye text-info"></i></button>';

    $data[] = $sub_array;
}

function count_all_data()
{
    global $con;
    global $situacao;

    $query = "SELECT COUNT(codigo) FROM vendas WHERE deletado != '1' AND situacao = '{$situacao}'";
    $result = mysqli_query($con, $query);
    list($qtd) = mysqli_fetch_row($result);

    return $qtd;
}

// @formatter:off
$output = [
    "draw"            => intval($_POST["draw"]),
    "recordsTotal"    => count_all_data(),
    "recordsFiltered" => $number_filter_row,
    "data"            => $data
];
// @formatter:on

echo json_encode($output);
exit();