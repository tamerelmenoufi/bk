<?php
    include("../conf.php");

    echo date("d/m/Y H:i:s");
?>

<audio autoplay="autoplay" controls="controls">
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