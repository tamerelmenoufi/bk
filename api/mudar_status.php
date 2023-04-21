<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = [];

if($_POST['pedido']){
    //PRODUÇÃO SEM SOLICITAÇÂO DE ENTREGA
    //*
    // $query = "UPDATE vendas set situacao = 'i' where codigo = '{$_POST['pedido']}'";
    // $result = mysqli_query($con, $query);

    EnviarWapp('92991886570',"VENDA - pedido *{$_POST['pedido']}* em produção.");
    //*/
    //PRODUÇÃO SEM SOLICITAÇÂO DE ENTREGA

    //SOLICITAÇÃO DA ENTREGA BEE
    //*
    $BEE = new Bee;
    $retorno = $BEE->NovaEntrega($_POST['pedido']);
    $retorno = json_decode($retorno);
    file_put_contents("log.txt", "TESTE Novo: ".$retorno);

    if($retorno->deliveryId == 9999){
        $query = "update vendas set
                                    deliveryId = '{$retorno->deliveryId}',
                                    situacao = 'i',
                                    GOING_TO_DESTINATION = NOW(),
                                    name = 'Unidade Djalma Batista',
                                    phone = '(92) 9843-87438'
                where codigo = '{$_POST['pedido']}'";
        file_put_contents("log.txt", "TESTE3: ".$query);
        mysqli_query($con, $query);
        EnviarWapp('92991886570',"VENDA - pedido *{$_POST['pedido']}* em produção.");
    }else if($retorno->deliveryId){
        $query = "update vendas set deliveryId = '{$retorno->deliveryId}', situacao = 'i' where codigo = '{$_POST['pedido']}'";
        mysqli_query($con, $query);
        EnviarWapp('92991886570',"VENDA - pedido *{$_POST['pedido']}* em produção.");
    }else{
        EnviarWapp('92991886570',"VENDA - pedido *{$_POST['pedido']}* não gerou entrega 3.");
    }
    //*/
    // SOLICITAÇÃO DA ENTREGA BEE
    //////////////////////////////////////////////////////////

    $dados = ['status' => true];
}
echo json_encode($dados);