<?php
    include("../conf.php");

    echo date("d/m/Y H:i:s");

?>
<div class="row">
    <div class="col">
        <?php
            echo $query = "select * from vendas where loja = '{$_GET['loja']}'";
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
