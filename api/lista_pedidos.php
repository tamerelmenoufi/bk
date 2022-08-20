<?php

include("../lib/includes.php");

$query = "SELECT * FROM `vendas`";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[] = $d;
}

echo json_encode($dados);