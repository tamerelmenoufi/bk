<?php
    include("../../../lib/includes.php");
    $PIX = new MercadoPago;
    $retorno = $PIX->ObterPagamento($_POST['id']);

    echo "<p>".date("d/m/Y H:i:s")."</p>";
    print_r($retorno);
?>

<script>
    $(function(){
        setTimeout(() => {
            $.ajax({
                url:"src/produtos/pagar_pix_verificar.php",
                type:"POST",
                data:{
                    id:'<?=$_POST['id']?>'
                },
                success:function(dados){
                    $(".status_pagamento").html(dados)
                }
            });
        }, 5000);
    })
</script>