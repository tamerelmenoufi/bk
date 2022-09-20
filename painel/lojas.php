<?php
include("../lib/includes.php");

$query = "select * from lojas";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[$d->codigo] = [
        "situacao" => 1
    ];
}

echo json_encode($dados);

// -- update `produtos` set lojas = JSON_SET(lojas,'$."3".situacao',0) where codigo = 1;
// select json_extract(lojas, '$."3".situacao') from produtos;