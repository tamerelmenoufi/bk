<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT a.*, c.categoria as nome_categoria FROM vendas_produtos a left join produtos b on a.produto = b.codigo left join categorias c on b.categoria = c.codigo where a.venda = '{$_POST['pedido']}'";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[] = $d;
}

echo json_encode($dados);