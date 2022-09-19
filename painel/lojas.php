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