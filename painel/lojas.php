<?php
include("../lib/includes.php");

$query = "select * from lojas";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[$d->codigo] = [
        "loja" => $d->nome,
        "situacao" => $d->situacao
    ];
}

echo json_encode($dados);