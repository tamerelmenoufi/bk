<?php

    include("../../../lib/includes.php");

    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>

<h5>Retorno <?=date("d/m/Y H:i:s")?></h5>

<?php

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

<script>
    $(function(){

        $('p[entrega="<?=$d->codigo?>"]').timeline({

            data: [
                {
                    time: new Date(),
                    color: '#555',
                    css: 'success',
                    content: 'Item 1'
                }
            ]

        });
        //$('p[entrega="<?=$d->codigo?>"]').append('novo item<br>');

    })
</script>