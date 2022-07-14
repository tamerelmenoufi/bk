<?php

    include("../../../lib/includes.php");

    function DadosStatus($data, $msg){
        list($d, $h) = explode(" ", $data);
        $h = substr($h, 0, -3);

        return [
            data => $d,
            hora => $h,
            status => $msg
        ];
    }

    function EventoEntrega($data = false, $msg = false){
        $obj = DadosStatus($data, $msg);
        return '<div style="position:relative; width:100%; min-height:90px; padding:10px; clear:both;">

                    <div style="position:absolute; left:-80px; top:10px; font-size:10px; text-align:right;">
                        '.$obj['data'].'<br>
                        '.$obj['hora'].'
                    </div>

                    <div style="position:absolute; left:-12px; top:5px; font-size:25px;">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div style="position:absolute; left:30px; top:0px; right:5px; border-radius:5px; background-color:#eee; padding:5px;">
                        <div style="position:absolute; left:-7px; top:0px; font-size:25px; color:#eee;">
                            <i class="fa-solid fa-caret-left"></i>
                        </div>
                        '.$obj['status'].'
                    </div>

                </div>';
    }


    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>

<div style="position:relative; height:auto; margin-left:70px; border-left:solid 3px green; ">
    <?php

        echo date("d/m/Y H:i:s");

        if($d->CANCELED > 0){
            echo EventoEntrega();
        }else{

            if($d->SEARCHING > 0){
                echo EventoEntrega($d->SEARCHING, 'Buscando Motoqueiro');
            }
            if($d->GOING_TO_ORIGIN > 0){
                echo EventoEntrega($d->GOING_TO_ORIGIN,'A Caminho do estabelecimento');
            }
            if($d->ARRIVED_AT_ORIGIN > 0){
                echo EventoEntrega($d->ARRIVED_AT_ORIGIN,'Entregador no estabelecimento');
            }
            if($d->GOING_TO_DESTINATION > 0){
                echo EventoEntrega($d->GOING_TO_DESTINATION,'A entrga está a caminho');
            }
            if($d->ARRIVED_AT_DESTINATION > 0){
                echo EventoEntrega($d->ARRIVED_AT_DESTINATION,'Entrega realizada');
            }
            if($d->RETURNING > 0){
                echo EventoEntrega($d->RETURNING, 'Entregador retornando');
            }
            if($d->COMPLETED > 0){
                echo EventoEntrega($d->COMPLETED,'Entrega Concluída');
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