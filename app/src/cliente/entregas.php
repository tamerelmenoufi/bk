<?php

    include("../../../lib/includes.php");


    function EventoEntrega(){
        return '<div style="position:relative; width:100%; min-height:90px; padding:10px; clear:both;">

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
                        Pedido Entregue
                    </div>

                </div>';
    }


    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $retorno_situacao = [];


?>

<div style="position:relative; height:auto; margin-left:70px; border-left:solid 3px green; ">
    <?php

        echo date("d/m/Y H:i:s");

        if($d->CANCELED > 0){
            echo EventoEntrega();
        }else{

            if($d->SEARCHING > 0){
                echo EventoEntrega();
                $retorno_situacao['SEARCHING'] = "<p>Buscando</p>";
            }
            if($d->GOING_TO_ORIGIN > 0){
                echo EventoEntrega();
                $retorno_situacao['GOING_TO_ORIGIN'] = "<p>A Caminho do estabelecimento</p>";
            }
            if($d->ARRIVED_AT_ORIGIN > 0){
                echo EventoEntrega();
                $retorno_situacao['ARRIVED_AT_ORIGIN'] = "<p>Entregador no estabelecimento</p>";
            }
            if($d->GOING_TO_DESTINATION > 0){
                echo EventoEntrega();
                $retorno_situacao['GOING_TO_DESTINATION'] = "<p>A entrga está a caminho</p>";
            }
            if($d->ARRIVED_AT_DESTINATION > 0){
                echo EventoEntrega();
                $retorno_situacao['ARRIVED_AT_DESTINATION'] = "<p>Entrega realizada</p>";
            }
            if($d->RETURNING > 0){
                echo EventoEntrega();
                $retorno_situacao['RETURNING'] = "<p>Entregador retornando</p>";
            }
            if($d->COMPLETED > 0){
                echo EventoEntrega();
                $retorno_situacao['COMPLETED'] = "<p>Entrega Concluída</p>";
            }

        }
    ?>

</div>

<script>

    $(function(){
        setTimeout(() => {
            $.ajax({
                url:"src/cliente/entregas.php",
                type:"POST",
                data:{
                    cod:'<?=$_POST['cod']?>'
                },
                success:function(dados){
                    $('p[entrega="<?=$_POST['cod']?>"]').html(dados);
                },
                error:function(){
                    alert('erro');
                }
            });
        }, 10000);
    })

</script>