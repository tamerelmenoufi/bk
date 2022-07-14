<?php
    include("../../../lib/includes.php");

    $Status = [
        'panding' => '<span style="color:red">Pendente</span>',
        'approved' => '<span style="color:green">Aprovado</span>',
    ];

    $PIX = new MercadoPago;
    $retorno = $PIX->ObterPagamento($_POST['id']);
    $operadora_retorno = $retorno;
    $retorno = json_decode($retorno);

    echo "<p>".date("d/m/Y H:i:s")."</p>";
    echo "Pagamento: ".$Status[$retorno->status].$retorno->status;

    if($retorno->status == 'approved'){
        //Aqui entra a solicitação da Bee
        // e tbm a mudança de status para pedido em produção

        mysqli_query($con, "update vendas set
                            operadora_situacao = '{$operadora_situacao}',
                            operadora_retorno = '{$operadora_retorno}'
                        where operadora_id = '{$_POST['id']}'
                    ");

        $_SESSION['AppVenda'] = false;
        $_SESSION['AppPedido'] = false;
        $_SESSION['AppCarrinho'] = false;

    }

?>

<script>
    $(function(){
        <?php
        if($retorno->status != 'approved'){
        ?>
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
        <?php
        }else{
        ?>
            $.alert('Pagamento Confirmado.<br>Seu pedido está em preparo!')
            PageClose(2);
        <?php
        }
        ?>
    })
</script>