<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = [];
if($_POST['pedido']){
    $query = "UPDATE vendas set status = 'i' where codigo = '{$_POST['pedido']}'";
    $result = mysqli_query($con, $query);
    $dados = ['status' => $query];
}
echo json_encode($dados);