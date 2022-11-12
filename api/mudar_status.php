<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = [];

$_POST['pedido'] = 12624;

if($_POST['pedido']){
    // $query = "UPDATE vendas set situacao = 'i' where codigo = '{$_POST['pedido']}'";
    // $result = mysqli_query($con, $query);

    //ESSAS DUAS LINHAS SÃO PARA A SOLICITAÇÃO DA ENTREGA BEE

    $BEE = new Bee;
    $retorno = $BEE->NovaEntrega($_POST['pedido']);
    $retorno = json_decode($retorno);
    file_put_contents("log.txt", $retorno);
    if($retorno->deliveryId){
        $query = "update vendas set deliveryId = '{$retorno->deliveryId}', situacao = 'i' where codigo = '{$_POST['pedido']}'";
        mysqli_query($con, $query);
    }

    //////////////////////////////////////////////////////////

    $dados = ['status' => $query];
}
echo json_encode($dados);