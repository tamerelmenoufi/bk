<?php
    include("../conf.php");

    echo date("d/m/Y H:i:s");


    echo $query = "select * from vendas where loja = '{$_GET['loja']}'";
    $result = mysqli_query($con, $query);
    $n = mysqli_num_rows($result);
?>
<style>
    .som{
        position:fixed;
        left:-1000px;
        top:-1000px;
    }
    .alerta{
        position:fixed;
        bottom:30px;
        left:5%;
        right:5%;
        z-index:10;
    }
</style>
<?php
    if($n){
?>
<audio autoplay="autoplay" controls="controls" class="som">
    <source src="src/pedidos/ListaStatus/som/pedido.mp3" type="audio/mp3" />
</audio>

<div class="alert alert-success alerta" role="alert">
    <div class="row">
        <div class="col-2"><i class="fa-solid fa-phone-volume"></i></div>
        <div class="col-10">Você tem novos pedidos!</div>
    </div>
</div>

<?php
    }
?>




<script>
    $(function(){
        Carregando('none');
        setTimeout(() => {
            $.ajax({
                url: "src/pedidos/ListaStatus/index.php",
                data:{
                    loja:window.localStorage.getItem('bk_pedidos_loja')
                },
                success: function (dados) {
                    $(".ListaStatus").html(dados);
                }
            });
        }, 5000);
    })
</script>