<?php
    include("../conf.php");


    if($_GET['Ini']){
        mysqli_query($con, "update vendas set situacao = 'i' where codigo = '{$_GET['Ini']}'");

        //ESSAS DUAS LINHAS SÃO PARA A SOLICITAÇÃO DA ENTREGA BEE
        $BEE = new Bee;
        $retorno = $BEE->NovaEntrega($_GET['Ini']);
        $retorno = json_decode($retorno);
        file_put_contents("log.txt", $retorno);
        if($retorno->deliveryId){
            mysqli_query($con, "update vendas set deliveryId = '{$retorno->deliveryId}' where codigo = '{$_GET['Ini']}'");
        }
        //////////////////////////////////////////////////////////


        exit();
    }

    $StDescricao = [
        'n' => 'Novo',
        'p' => 'Produção',
        'i' => 'Iniciado',
        'c' => 'Concluído',
        'e' => 'Entregue'
    ];

?>

<style>
    .stOn{
        font-size:30px;
        color:green;
    }
    .stOff{
        font-size:30px;
        color:#eee;
    }
    .StDesc{
        font-size:25px;
        margin-left:10px;
    }
    .titulo{
        font-size:10px;
        color:#a1a1a1;
    }
</style>

<div class="col">
    <?php
        $query = "select
                        a.*,
                        b.nome as cliente,
                        b.telefone as telefone
                    from vendas a
                    left join clientes b on a.cliente = b.codigo

                    where
                        a.loja = '{$_GET['loja']}'
                        and a.loja > '0'
                        and a.operadora_situacao = 'approved'
                        and a.COMPLETED = 0 and a.CANCELED = 0 order by a.data_pedido desc";

        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
    ?>
    <div class="card m-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <title class="titulo">Cliente</title>
                <p><?="{$d->cliente} ({$d->telefone})"?></p>
            </li>
            <li class="list-group-item">
                <title class="titulo">Valor do Pedido</title>
                <p><?=$d->valor?></p>
            </li>
            <li class="list-group-item">
                <title class="titulo">Taxa de Entrega</title>
                <p><?=$d->taxa_entrega?></p>
            </li>
            <li class="list-group-item">
                <title class="titulo">Valor a Pagar</title>
                <p><?=$d->total?></p>
            </li>
            <li class="list-group-item">
                <title class="titulo">Data do Pedido</title>
                <p><?=$d->data_pedido?></p>
            </li>

            <li class="list-group-item">

            <?php

                if($d->CANCELED > 0){
                    echo 'Pedido Cancelado<br>';
                }else if($d->COMPLETED > 0){
                    echo 'Entrega Concluída<br>';
                }else{

                    if($d->SEARCHING > 0){
                        echo 'Buscando Motoqueiro<br>';
                    }if($d->GOING_TO_ORIGIN > 0){
                        echo 'A Caminho do estabelecimento<br>';
                    }if($d->ARRIVED_AT_ORIGIN > 0){
                        echo 'Entregador no estabelecimento<br>';
                    }if($d->GOING_TO_DESTINATION > 0){
                        echo 'A entrga está a caminho<br>';
                    }if($d->ARRIVED_AT_DESTINATION > 0){
                        echo 'Entrega realizada<br>';
                    }if($d->RETURNING > 0){
                        echo 'Entregador retornando<br>';
                    }
                }
                echo (($d->name)?"<hr>".$d->name."<br>":false);
                echo (($d->phone)?:false);


            ?>


            </li>


            <li class="list-group-item">
                <div class="row">
                    <div <?=(($d->situacao != 'i')?"StOff='{$d->codigo}'":"StOn='{$d->codigo}'")?> class="col-8">
                        <?=(($d->situacao != 'i')?'<i class="fa-solid fa-toggle-off stOff"></i>':'<i class="fa-solid fa-toggle-on stOn"></i>')."<span class='StDesc'>".$StDescricao[$d->situacao]."</span>"?>
                    </div>
                    <div pedido="<?=$d->codigo?>" class="col-4 btn btn-primary">
                        <i class="fa-solid fa-basket-shopping"></i>
                            Pedido
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <?php
        }
    ?>
</div>

<script>
    $(function(){
        Carregando('none');
        setTimeout(() => {
            $.ajax({
                url: "src/pedidos/ListaPedidos/index.php",
                data:{
                    loja:window.localStorage.getItem('bk_pedidos_loja')
                },
                success: function (dados) {
                    $(".ListaPedidos").html(dados);
                },
                error:function(){
                    $.alert('Erro no acesso!')
                }
            });
        }, 50000);

        $("div[pedido]").click(function(){
            obj = $(this);
            pedido = $(this).attr("pedido");
            obj.attr("disabled","disabled");
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:`src/pedidos/ListaPedidos/pedido.php`,
                    pedido,
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                    obj.removeAttr("disabled");
                }
            });

        });

        $("div[StOff]").click(function(){
            cod = $(this).attr("StOff");
            obj = $(this).children("svg.fa-toggle-off");
            obj.removeClass("fa-toggle-off stOff");
            obj.addClass("fa-toggle-on stOn");
            $(this).children("span").text("Iniciado");

            $.ajax({
                url:"src/pedidos/ListaPedidos/index.php",
                data:{
                    Ini:cod,
                },
                success:function(){

                }
            });

        });

    })
</script>
