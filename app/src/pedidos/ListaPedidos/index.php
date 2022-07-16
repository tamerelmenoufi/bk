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
                        and situacao = 'p' and COMPLETED = 0 and CANCELED = 0";

        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
    ?>
    <div class="card m-3">
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
    })
</script>
