<?php
include("../../../lib/includes.php");

$column = array("nome", "data_pedido", "forma_pagamento", "total");

$query = "SELECT * FROM vendas v "
    . "INNER JOIN clientes c ON c.codigo = v.cliente "
    . "WHERE v.deletado != '1' ";

if (isset($_POST["search"]["value"])) {

    $query .= '
	AND c.nome LIKE "%' . $_POST["search"]["value"] . '%" 
	OR v.data_pedido LIKE "%' . $_POST["search"]["value"] . '%" 
	OR v.forma_pagamento LIKE "%' . $_POST["search"]["value"] . '%" 
	OR v.valor LIKE "%' . $_POST["search"]["value"] . '%" 
	';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY c.codigo DESC ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$result = mysqli_query($con, $query);

$number_filter_row = mysqli_num_rows($result);

$result1 = mysqli_query($con, $query . $query1);

file_put_contents("debug.txt", $query . $query1);
$data = array();

foreach ($result1 as $row) {
    $sub_array = array();

    $sub_array[] = $row['nome'];

    $sub_array[] = $row['data_pedido'];

    $sub_array[] = $row['forma_pagamento'];

    $sub_array[] = $row['valor'];

    $data[] = $sub_array;
}

function count_all_data()
{
    global $con;

    $query = "SELECT * FROM vendas WHERE deletado != '1'";

    $result = mysqli_query($con, $query);

    return mysqli_num_rows($result);
}

$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => count_all_data(),
    "recordsFiltered" => $number_filter_row,
    "data" => $data
);

echo json_encode($output);