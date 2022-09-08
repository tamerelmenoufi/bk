<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "select a.*, (select count(*) from vendas_produtos where venda = a.codigo and deletado != '1') as qt from vendas a where a.deletado != '1' and a.situacao in ('p') and a.loja = '{$_POST['loja']}' and a.operadora_situacao = 'Approved'";
$result = mysqli_query($con, $query);
$p = 0;
while($d = mysqli_fetch_object($result)){
    if($d->qt > 0) $p++;
}

$dados = ['status' => ((mysqli_num_rows($result) and $p > 0)?true:false), 'loja' => $_POST['loja']];

echo json_encode($dados);