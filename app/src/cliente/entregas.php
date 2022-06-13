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

<div style="position:relative; height:auto; margin-left:70px; border-left:solid 3px green; ">
    <?php
        for($i=0;$i<10;$i++){
    ?>
    <div style="position:relative; width:100%; min-height:90px; padding:10px; clear:both;">

        <div style="position:absolute; left:-80px; top:10px; font-size:10px; text-align:right;">
            23/06/2022<br>
            08:16
        </div>

        <div style="position:absolute; left:-12px; top:5px; font-size:25px;">
            <i class="fa-solid fa-clock"></i>
        </div>

        <div style="position:absolute; left:30px; top:0px; right:5px; border-radius:5px; background-color:#eee; padding:5px;">
            <div style="position:absolute; left:-7px; top:0px; font-size:25px; color:#eee;">
                <i class="fa-solid fa-caret-left"></i>
            </div>
            Informações da entrega
        </div>
    </div>
    <?php
        }
    ?>
</div>