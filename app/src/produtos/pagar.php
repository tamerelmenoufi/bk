<?php
    include("../../../lib/includes.php");

    $query = "select
                    sum(a.valor_total) as total,
                    b.nome,
                    b.telefone,
                    a.venda
                from vendas_produtos a
                    left join clientes b on a.cliente = b.codigo
                where a.venda = '{$_SESSION['AppVenda']}' and a.deletado != '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    if(!$d->total) $_SESSION['AppCarrinho'] = false;

?>
<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
    .card-title small{
        font-size:10px;
    }
    .card-title div{
        width:100%;
        text-align:left;
        font-size:14px;
        font-weight:bold;
    }
    .card-title a{
        width:100%;
        text-align:left;
    }
    .card-title p{
        width:100%;
        text-align:center;
    }
    .alertas{
        width:100%;
        text-align:center;
        background-color:#fff;
        color:red;
        border:solid 1px red;
        border-radius:7px;
        font-size:10px !important;
        padding:5px;
        margin-top:10px;
        margin-bottom:10px;
    }

    .SemProduto{
        position:fixed;
        top:40%;
        left:0;
        text-align:center;
        width:100%;
        color:#ccc;
    }
    .icone{
        font-size:70px;
    }

</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar <?=$_SESSION['AppPedido']?></h4>
</div>

<div class="col" style="margin-bottom:60px; display:<?=(($d->total)?'block':'none')?>">
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header">Dados da Compra</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">
                                <small>Pedido</small>
                                <div style="font-size:18px; color:blue;"><?=str_pad($d->venda, 6, "0", STR_PAD_LEFT)?></div>
                            </h5>
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">
                                <small>Valor</small>
                                <div style="font-size:20px; color:red;">R$ <?=number_format($d->total,2,',','.')?></div>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">
                                <small>Cliente</small>
                                <div><?="{$d->nome}<br>{$d->telefone}"?></div>
                                <?php
                                if(!$d->nome or !$d->confirma_telefone){
                                ?>
                                <div class="alertas animate__animated animate__fadeIn animate__infinite">Dados Incompletos, atualize para fechar o seu pedido.</div>
                                <button class="btn btn-danger btn-xs">Abrir</button>
                                <?php
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header">Endereço para Entrega</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">
                                <small>Endereço</small>
                                <?php
                                    $query1 = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' order by padrao desc limit 1";
                                    $result1 = mysqli_query($con, $query1);
                                    $d1 = mysqli_fetch_object($result1);
                                ?>
                                <div><?="{$d1->rua}, {$d1->numero}, {$d1->bairro} ".
                                (($d1->complemento)?', '.$d1->complemento:false).
                                (($d1->referencia)?', '.$d1->referencia:false)?></div>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header">Formas de Pagamento</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a pagar opc="debito" class="btn btn-danger btn-lg"><i class="fa-solid fa-credit-card"></i> Débito</a>
                    </h5>
                    <h5 class="card-title">
                        <a pagar opc="credito" class="btn btn-danger btn-lg"><i class="fa-solid fa-credit-card"></i> Crédito</a>
                    </h5>
                    <h5 class="card-title">
                        <a pagar opc="pix" class="btn btn-danger btn-lg"><i class="fa-brands fa-pix"></i> PIX</a>
                    </h5>
                    <h5 class="card-title">
                        <a pagar opc="dinheiro" class="btn btn-danger btn-lg"><i class="fa-solid fa-money-bill-1"></i> Dinheiro</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>



</div>


<div class="SemProduto" style="display:<?=(($d->total)?'none':'block')?>">
    <i class="fa-solid fa-face-frown icone"></i>
    <p>Poxa, ainda não tem produtos em seu pedido!</p>
</div>


<script>
    $(function(){

        $("a[pagar]").click(function(){
            opc = $(this).attr("opc");
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:'src/produtos/pagar_'+opc+'.php',
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });


    })
</script>