<?php
    include("../conf.php");

?>
<div class="col">
    <?php
        $query = "select
                        *
                    from vendas
                    where
                            loja = '{$_GET['loja']}'
                        and operadora_situacao = 'approved'
                        and COMPLETED = 0 and CANCELED = 0 order by data_pedido desc";

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
