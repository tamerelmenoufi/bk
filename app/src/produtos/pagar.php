<?php
    include("../../../lib/includes.php");

    $query = "select
                    sum(a.valor_total) as total,
                    b.nome,
                    b.telefone,
                    b.telefone_confirmado,
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
        font-weight:normal;
    }
    .card-title button[opc]{
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
        background-color:#ffffff;
        border:solid 1px #fd3e00;
        color:#ff7d52;
        text-align:center !important;
        border-radius:7px;
        font-size:11px !important;
        font-weight:normal !important;
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
    .alterar_endereco{
        cursor:pointer;
        color:blue;

    }

</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar <?=$_SESSION['AppPedido']?></h4>
</div>

<div class="col" style="margin-bottom:60px; display:<?=(($d->total)?'block':'none')?>">
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-clipboard-list"></i> Dados da Compra</div>
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
                                <div style="font-size:20px; color:#502314;">R$ <?=number_format($d->total,2,',','.')?></div>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">
                                <small><i class="fa-solid fa-user-check"></i> Cliente</small>
                                <div><?="{$d->nome}<br>{$d->telefone}"?></div>
                                <?php
                                if(!$d->nome or !$d->telefone_confirmado){
                                ?>
                                <div class="alertas animate__animated animate__fadeIn animate__infinite animate__slower">Dados Incompletos, atualize para fechar o seu pedido.</div>
                                <button class="ConfirmaTelefone btn btn-danger btn-block">Atualizar Cadastro</button>
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
                <div class="card-header"><i class="fa-solid fa-location-dot"></i> Endereço para Entrega</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <?php
                                $coordenadas = false;
                                $query1 = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' order by padrao desc limit 1";
                                $result1 = mysqli_query($con, $query1);
                                if(mysqli_num_rows($result1)){
                                $d1 = mysqli_fetch_object($result1);
                                $coordenadas = $d1->coordenadas;
                            ?>

                            <b><?=$d1->nome?></b>
                            <h5 class="card-title">
                                <small><i class="fa-solid fa-map-pin"></i> Endereço</small>
                                <div><?=trim($d1->rua).", ".trim($d1->numero).", ".trim($d1->bairro).
                                (($d1->complemento)?', '.$d1->complemento:false).
                                (($d1->referencia)?', '.$d1->referencia:false)?></div>

                                <?php
                                if(!$coordenadas){
                                ?>
                                <div class="alertas animate__animated animate__fadeIn animate__infinite animate__slower">Endereço Pendente de validação.</div>
                                <button endereco="<?=$d1->codigo?>" class="ConfirmaEndereco btn btn-danger btn-block">Validar Endereço</button>
                                <?php
                                }
                                ?>



                            </h5>
                            <?php
                            }
                            ?>

                            <div style="width:100%; text-align:right; margin-top:20px; margin-bottom:20px;">
                                <span class='alterar_endereco'>
                                    <i class="fa-solid fa-repeat"></i>
                                    Trocar/Cadastrar Endereço
                                </span>
                            </div>


                            <?php
                            if($coordenadas){
                            ?>
                            Taxa de Entrega


                            <div id="accordion">
                                <div class="card">
                                    <div id="headingOne">
                                        <ul class="list-group">
                                            <li class="loja list-group-item d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <small>Empresa Modelo</small>
                                                <span class="badge badge-pill">
                                                    <small>R$ <?=number_format(19.86,2,',','.')?></small>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                        <ul class="list-group">
                                        <?php
                                            $bee = new Bee;
                                            list($lat, $lng) = explode(",", $coordenadas);
                                            $q = "select * from lojas";
                                            $r = mysqli_query($con, $q);
                                            while($v = mysqli_fetch_object($r)){

                                                $valores = json_decode($bee->ValorViagem($v->id, $lat, $lng));

                                        ?>
                                            <li class="opcLoja list-group-item d-flex justify-content-between align-items-center">
                                                <small><?=$v->nome?></small>
                                                <span class="badge badge-pill">
                                                    <small>R$ <?=number_format($valores->deliveryFee,2,',','.')?></small>
                                                </span>
                                            </li>
                                        <?php
                                            }

                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>






                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-receipt"></i> Formas de Pagamento</div>
                <div class="card-body">
                    <?php
                    $pagar = true;
                    if(!$coordenadas or !$d->nome or !$d->telefone_confirmado){
                    ?>
                    <div class="alertas animate__animated animate__fadeIn animate__infinite animate__slower">
                        Você possui pendências em seu cadastro. Verifique as notificações acima e atualize seu cadastro para concluir seu pedido.
                    </div>
                    <?php
                    $pagar = false;
                    }
                    ?>
                    <!-- <h5 class="card-title">
                        <a pagar opc="debito" class="btn btn-danger btn-lg"><i class="fa-solid fa-credit-card"></i> Débito</a>
                    </h5> -->
                    <h5 class="card-title">
                        <button <?=(($pagar)?'pagar':'disabled')?> opc="credito" class="btn btn-info btn-lg"><i class="fa-solid fa-credit-card"></i> Cartão</button>
                    </h5>
                    <h5 class="card-title">
                        <button <?=(($pagar)?'pagar':'disabled')?> opc="pix" class="btn btn-info btn-lg"><i class="fa-brands fa-pix"></i> PIX</button>
                    </h5>
                    <!-- <h5 class="card-title">
                        <a pagar opc="dinheiro" class="btn btn-danger btn-lg"><i class="fa-solid fa-money-bill-1"></i> Dinheiro</a>
                    </h5> -->
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

        $(".opcLoja").click(function(){
            obj = $(this);
            $(".opcLoja").removeClass('list-group-item-success');
            dados = obj.html();
            obj.addClass('list-group-item-success');
            $(".loja").html(dados);
            $("#collapseOne").removeClass('show');
        });

        $("button[pagar]").click(function(){
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


        $(".ConfirmaTelefone").click(function(){
            $.ajax({
                url:"componentes/ms_popup.php",
                type:"POST",
                data:{
                    local:"src/cliente/confirmar_telefone.php",
                },
                success:function(dados){
                    $("body").attr("retorno","src/produtos/pagar.php");
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $(".ConfirmaEndereco").click(function(){
            cod = $(this).attr('endereco');
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:"src/cliente/mapa_editar.php",
                    cod,
                },
                success:function(dados){
                    $("body").attr("retorno","src/produtos/pagar.php");
                    $(".ms_corpo").append(dados);
                }
            });
        });


        $(".alterar_endereco").click(function(){
            $.ajax({
                url:"componentes/ms_popup.php",
                type:"POST",
                data:{
                    local:"src/cliente/enderecos_trocar.php",
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

    })
</script>