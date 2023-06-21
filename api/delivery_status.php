<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = json_encode($_POST);

if($_POST['CodigoExterno']){

        $query = "insert into status_delivery set
                                    venda = '{$_POST['pedido']}',
                                    operadora = 'mottu',
                                    data = NOW(),
                                    retorno = '{$dados}'";

    mysqli_query($con, $query);

    EnviarWapp('92991886570',"VENDA - pedido *{$_POST['CodigoExterno']}* com alteração status *{$_POST['Situacao']}*.");
    //*/
    // SOLICITAÇÃO DA ENTREGA BEE
    //////////////////////////////////////////////////////////

}
