<?php
    include("../conf.php");

    echo date("d/m/Y H:i:s");
?>

<script>
    $(function(){
        setTimeout(() => {
            $.ajax({
                url: "src/pedidos/ListaStatus/index.php",
                success: function (dados) {
                    $(".ListaPedidos").html(dados);
                }
            });
        }, 5000);
    })
</script>