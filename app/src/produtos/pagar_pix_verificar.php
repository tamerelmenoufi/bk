<?php
    include("../../../lib/includes.php");

    $Status = [
        'pending' => '<span style="color:red">Pendente</span>',
        'approved' => '<span style="color:green">Aprovado</span>',
    ];

    $PIX = new MercadoPago;
    $retorno = $PIX->ObterPagamento($_POST['id']);
    $operadora_retorno = $retorno;
    $retorno = json_decode($retorno);

    echo "<p>".date("d/m/Y H:i:s")."<br>Pagamento: ".$Status[$retorno->status]."</p>";

    if($retorno->status == 'approved'){
        //Aqui entra a solicitação da Bee
        // e tbm a mudança de status para pedido em produção

        mysqli_query($con, "update vendas set
                            operadora_situacao = '{$retorno->status}',
                            operadora_retorno = '{$operadora_retorno}',
                            situacao = 'p'
                        where operadora_id = '{$_POST['id']}'
                    ");

        // DADOS DE SOLICITAÇÃO DA ENTREGA
        //*
        $BEE = new Bee;
        $retorno = $BEE->NovaEntrega($_SESSION['AppVenda']);
        $retorno = json_decode($retorno);
        if($retorno->deliveryId == 9999){
            $query = "update vendas set
                                        deliveryId = '{$retorno->deliveryId}',
                                        situacao = 'p',
                                        GOING_TO_DESTINATION = NOW(),
                                        name = 'Unidade Djalma Batista',
                                        phone = '(92) 9843-87438'
                    where codigo = '{$_SESSION['AppVenda']}'";
            mysqli_query($con, $query);
        }else if($retorno->deliveryId){
            $query = "update vendas set deliveryId = '{$retorno->deliveryId}', situacao = 'p' where codigo = '{$_POST['pedido']}'";
            mysqli_query($con, $query);
        }
        EnviarWapp('92991886570',"VENDA - Venda do pedido *{$_SESSION['AppVenda']}*");
        //*/
        // DADOS DE SOLICITAÇÃO DA ENTREGA


        $_SESSION['AppVenda'] = false;
        $_SESSION['AppPedido'] = false;
        $_SESSION['AppCarrinho'] = false;

    }

?>
<style>
        .status_pagamento{
        width:100%;
        text-align:center;
    }
    </style>
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