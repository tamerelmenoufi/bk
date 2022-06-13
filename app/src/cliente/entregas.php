<?php

    include("../../../lib/includes.php");

    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $retorno_situacao = [];

    if($d->CANCELED > 0){
        $retorno_situacao['CANCELED'] =  "<p>Cancelado</p>";
    }else{

        if($d->SEARCHING > 0){
            $retorno_situacao['SEARCHING'] = "<p>Buscando</p>";
        }
        if($d->GOING_TO_ORIGIN > 0){
            $retorno_situacao['GOING_TO_ORIGIN'] = "<p>A Caminho do estabelecimento</p>";
        }
        if($d->ARRIVED_AT_ORIGIN > 0){
            $retorno_situacao['ARRIVED_AT_ORIGIN'] = "<p>Entregador no estabelecimento</p>";
        }
        if($d->GOING_TO_DESTINATION > 0){
            $retorno_situacao['GOING_TO_DESTINATION'] = "<p>A entrga está a caminho</p>";
        }
        if($d->ARRIVED_AT_DESTINATION > 0){
            $retorno_situacao['ARRIVED_AT_DESTINATION'] = "<p>Entrega realizada</p>";
        }
        if($d->RETURNING > 0){
            $retorno_situacao['RETURNING'] = "<p>Entregador retornando</p>";
        }
        if($d->COMPLETED > 0){
            $retorno_situacao['COMPLETED'] = "<p>Entrega Concluída</p>";
        }

    }
?>

<div style="position:relative; width:100%; height:auto; background-color:yellow">
    <div style="postion:absolute; width:5px; top:0px; bottom:0px; left:20px; background-color:green; height:100%;"></div>

    <br><br><br><br><br><br><br><br><br><br><br>

</div>