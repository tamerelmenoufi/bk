<?php
    include("../conf.php");

?>
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
    <div pedido="<?=$d->codigo?>" class="card m-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?=$d->codigo?></li>
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
        }, 5000);

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

    })
</script>
