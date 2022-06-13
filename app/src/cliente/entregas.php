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

<div style="position:relative; width:100%; height:auto; background-color:#eee; margin-left:10px; border-left:solid 3px green; ">
    <?php
        for($i=0;$i<10;$i++){
    ?>
    <div style="postion:relative; width:100%;">
            <i class="fa fa-user" style="postion:absolute; left:0px; top:5px; font-seize:25px;"></i>
            <div style="position:absolute; left:30px; top:5px; background-color:#ccc;">
                Informações da entrega
            </div>
    </div>
    <?php
        }
    ?>
</div>