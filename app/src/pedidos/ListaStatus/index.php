<?php
    include("../conf.php");

    echo date("d/m/Y H:i:s");
?>
<style>
    .som{
        position:fixed;
        left:-1000px;
        top:-1000px;
    }
</style>
<audio autoplay="autoplay" controls="controls" class="som">
    <source src="src/pedidos/ListaStatus/som/pedido.mp3" type="audio/mp3" />
</audio>

<script>
    $(function(){
        Carregando('none');
        setTimeout(() => {
            $.ajax({
                url: "src/pedidos/ListaStatus/index.php",
                success: function (dados) {
                    $(".ListaStatus").html(dados);
                }
            });
        }, 5000);
    })
</script>