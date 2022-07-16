<?php
    include("../conf.php");

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
</style>

<div class="col">
    <?php
        $query = "select
                        a.*,
                        b.nome as cliente
                    from vendas a
                    left join clientes b on a.cliente = b.codigo

                    where
                            a.loja = '{$_GET['loja']}'
                        and a.operadora_situacao = 'approved'
                        and a.COMPLETED = 0 and a.CANCELED = 0 order by a.data_pedido desc";

        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
    ?>
    <div class="card m-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?=$d->cliente?></li>
            <li class="list-group-item"><?=$d->valor?></li>
            <li class="list-group-item"><?=$d->taxa_entrega?></li>
            <li class="list-group-item"><?=$d->total?></li>
            <li class="list-group-item"><?=$d->data_pedido?></li>
            <li class="list-group-item">
                <div <?=(($d->situacao != 'i')?"StOff='{$d->codigo}'":"StOn='{$d->codigo}'")?> class="row">
                    <div class="col-8">
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
                }
            });
        }, 50000);

        $("div[pedido]").click(function(){
            pedido = $(this).attr("pedido");
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:`src/pedidos/ListaPedidos/pedido.php`,
                    pedido,
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                }
            });

        });

        $("div[StOff]").click(function(){
            cod = $(this).attr("StOn");
            obj = $(this).children("div").children("svg.fa-toggle-off");
            obj.removeClass("fa-toggle-off stOff");
            obj.addClass("fa-toggle-on stOn");
            $(this).children("div").children("span").text("Iniciado");

        });

    })
</script>
