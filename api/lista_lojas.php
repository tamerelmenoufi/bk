<?php

include("./lib/includes.php");

$query = "select * from lojas where situacao = '1' order by loja";
$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[] = $d;
}

echo json_encode($dados);