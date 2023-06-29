<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = json_encode($_POST);

if($_POST['CodigoExterno']){

        $query = "insert into status_delivery set
                                    venda = '{$_POST['CodigoExterno']}',
                                    operadora = 'mottu',
                                    tipo = '{$_POST['Tipo']}',
                                    data = NOW(),
                                    retorno = '{$dados}'";

    mysqli_query($con, $query);

    if($_POST['Tipo'] == 'bkmanaus'){
        $status = mysqli_fetch_object(mysqli_query($con, "select * from status_mottu where cod = '{$_POST['Situacao']}'"));
        if($status->campo == 'reset'){
            $query = "update vendas set
                                    SEARCHING = NOW(),
                                    GOING_TO_ORIGIN = 0,
                                    ARRIVED_AT_ORIGIN = 0,
                                    GOING_TO_DESTINATION = 0,
                                    ARRIVED_AT_DESTINATION = 0,
                                    RETURNING = 0,
                                    COMPLETED = 0,
                                    CANCELED = 0,
                                    name = '',
                                    phone = ''
                where codigo = '{$_POST['CodigoExterno']}'
            ";
        }else if($status->campo){
            $query = "update vendas set $status->campo = NOW()".(($_POST['Situacao'] == 30)?", situacao = 'c'":false)." where codigo = '{$_POST['CodigoExterno']}'";
        }

        if($query){
            mysqli_query($con, $query);
            // if($_POST['CodigoExterno'] = 13755 ){
            //     EnviarWapp('92991886570',"VENDA - pedido *{$_POST['CodigoExterno']}* com alteração status *{$_POST['Situacao']}*.");
            // }
        }

    }

    // EnviarWapp('92991886570',"VENDA - pedido *{$_POST['CodigoExterno']}* com alteração status *{$_POST['Situacao']}*.");
    //*/
    // SOLICITAÇÃO DA ENTREGA BEE
    //////////////////////////////////////////////////////////

}
