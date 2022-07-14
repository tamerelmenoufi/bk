<?php
    include("../../../lib/includes.php");
    $PIX = new MercadoPago;
    $retorno = $PIX->ObterPagamento($_POST['id']);

    $retorno = json_decode($retorno);

    echo "<p>".date("d/m/Y H:i:s")."</p>";
    echo "Status ID {$_POST['id']} -> ".$retorno->status;

    if($retorno->status == 'approved'){
        //Aqui entra a solicitação da Bee
        // e tbm a mudança de status para pedido em produção

        mysqli_query($con, "update vendas set
                            operadora_situacao = '{$operadora_situacao}',
                            operadora_retorno = '{$retorno}'
                        where operadora_id = '{$_POST['id']}'
                    ");

        $_SESSION['AppVenda'] = false;
        $_SESSION['AppPedido'] = false;
        $_SESSION['AppCarrinho'] = false;

    }

?>

<script>
    $(function(){

        $.alert('Pagamento Confirmado.<br>Seu pedido está em preparo!')
        PageClose(2);

    })
</script>