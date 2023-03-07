<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = [];

if($_POST['pedido']){
    // $query = "UPDATE vendas set situacao = 'i' where codigo = '{$_POST['pedido']}'";
    // $result = mysqli_query($con, $query);
    //ESSAS DUAS LINHAS SÃO PARA A SOLICITAÇÃO DA ENTREGA BEE
    $BEE = new Bee;
    $retorno = $BEE->NovaEntrega($_POST['pedido']);
    $retorno = json_decode($retorno);
    file_put_contents("log.txt", "TESTE2: ".$retorno->deliveryId);
    if($retorno->deliveryId == 9999){
        $query = "update vendas set
                                    deliveryId = '{$retorno->deliveryId}',
                                    situacao = 'i'
                                    ARRIVED_AT_DESTINATION = NOW(),
                                    name = 'Unidade Djalma Batista',
                                    phone = '(92) 9843-87438'
                where codigo = '{$_POST['pedido']}'";
        mysqli_query($con, $query);
    }else if($retorno->deliveryId){
        $query = "update vendas set deliveryId = '{$retorno->deliveryId}', situacao = 'i' where codigo = '{$_POST['pedido']}'";
        mysqli_query($con, $query);
    }

    //////////////////////////////////////////////////////////

    $dados = ['status' => true];
}
echo json_encode($dados);