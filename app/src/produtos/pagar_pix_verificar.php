<?php
    include("../../../lib/includes.php");
    $PIX = new MercadoPago;
    $retorno = $PIX->ObterPagamento($_POST['id']);

    echo "<p>".date("d/m/Y H:i:s")."</p>";
    echo "Status ID {$_POST['id']} -> ".$dados->additional_info;

    //echo "<pre>".print_r($retorno)."</pre>";

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