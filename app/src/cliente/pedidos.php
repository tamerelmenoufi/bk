<?php
    include("../../../lib/includes.php");

?>
<style>
    .PedidosTitulo{
        width:100%;
        position:fixed;
        padding-left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        background:#f5ebdc;
        z-index:1;
    }
</style>
<div class="PedidosTitulo">
    <h4>Meus Pedidos</h4>
</div>
<div class="col">
    <div class="row">
        <div class="col">
<?php
    $query = "select * from vendas where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' and data_finalizacao > 0 order by data_finalizacao desc";
    $result = mysqli_query($con, $query);
    $n = mysqli_num_rows($result);
    while($d = mysqli_fetch_object($result)){
?>
            <div class="card" style="margin-bottom:10px;">
                <div class="card-body">
                    <p class="card-text">
                        Pedido: <?=str_pad($d->codigo, 6, "0", STR_PAD_LEFT)?><br>
                        Valor: R$ <?=$d->total?><br>
                        Data do Pedido: <?=$d->data_finalizacao?><br>
                        Forma de Pagamento: <?=strtoupper($d->forma_pagamento)?><br>
                        situação: <?=$d->operadora_situacao?>
                    </p>


                    <p
                        <?=(($d->CANCELED > 0 or $d->COMPLETED > 0)?false: ' entrega="'.$d->codigo.'" ')?>
                        class="card-text">


                    </p>

                </div>
            </div>
<?php
    }
?>
        </div>
    </div>
</div>

<script>

    function AcessoDados(cod){
        $.ajax({
            url:"src/cliente/entregas.php",
            type:"POST",
            data:{
                cod
            },
            sucess:function(dados){
                $('p[entrega="'+cod+'"]').html(dados);
            },
            error:function(){
                alert('erro');
            }
        });
    }

    $(function(){
        AtualizarEntrega = setInterval(function () {
            $("p[entrega]").each(function(){
                cod = $(this).attr("entrega");
                AcessoDados(cod);
            });
        }, 5000);
    })
</script>