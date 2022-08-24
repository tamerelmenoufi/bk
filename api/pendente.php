<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "select * from vendas where data_pedido = '%".date("Y-m-d")."%' and deletado != '1' and situacao = 'n'";
$result = mysqli_query($con, $query);

$dados = ['status' => ((mysqli_num_rows($result))?true:false), 'loja' => $_POST['loja']];

echo json_encode($dados);