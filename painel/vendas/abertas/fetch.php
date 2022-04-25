<?php
include("../../../lib/includes.php");

$situacao = "n";

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

    $forma_pagamento = "";

    switch ($row["forma_pagamento"]) {
        case "pix":
            $forma_pagamento = '<i class="fa-brands fa-pix"></i> ' . getFormaPagamentoOptions("pix");
            break;
        case "credito":
            $forma_pagamento = '<i class="fa-solid fa-credit-card"></i> ' . getFormaPagamentoOptions("credito");
            break;
        case "debito":
            $forma_pagamento = '<i class="fa-solid fa-credit-card"></i> ' . getFormaPagamentoOptions("debito");
            break;
        default:
            $forma_pagamento = "(Não informado)";
            break;
    }

    $botao_visualizar = '<button visualizar type="button" class="btn btn-link btn-sm" data-codigo="' . $row["codigo"] . '">';
    $botao_visualizar .= '<i class="fa fa-eye text-info"></i>';
    $botao_visualizar .= '</button>';

    $sub_array[] = $row["codigo"];
    $sub_array[] = $row["nome"] ?: $row["telefone"];
    $sub_array[] = formata_datahora($row['data_pedido'], DATA_HM);
    $sub_array[] = $forma_pagamento;
    $sub_array[] = $botao_visualizar;

    $data[] = $sub_array;
}

function count_all_data()
{
    global $con;
    global $situacao;

    $query = "SELECT COUNT(codigo) FROM vendas WHERE deletado != '1' and situacao = '{$situacao}'";
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