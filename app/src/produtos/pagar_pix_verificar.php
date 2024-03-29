<?php
    include("../../../lib/includes.php");

    $Status = [
        'pending' => '<span style="color:red">Pendente</span>',
        'approved' => '<span style="color:green">Aprovado</span>',
    ];

    list($codVenda) = mysqli_fetch_row(mysqli_query($con, "select codigo from vendas where operadora_id = '{$_POST['id']}'"));


    $query = "select
                    a.*,
                    d.id as id_loja,
                    d.mottu as id_mottu,
                    b.nome,
                    b.cpf,
                    b.telefone,
                    b.email,
                    c.cep,
                    c.numero,
                    c.rua,
                    c.bairro,
                    c.referencia
                from vendas a
                     left join clientes b on a.cliente = b.codigo
                     left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
                     left join lojas d on a.loja = d.codigo
                where a.codigo = '{$codVenda}'";

    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

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
        if($d->retirada_local != '1'){
            $json = '{
                "code": "'.$d->codigo.'",
                "fullCode": "bk-'.$d->codigo.'",
                "preparationTime": 0,
                "previewDeliveryTime": false,
                "sortByBestRoute": false,
                "deliveries": [
                  {
                    "code": "'.$d->codigo.'",
                    "confirmation": {
                      "mottu": true
                    },
                    "name": "'.$d->nome.'",
                    "phone": "'.trim(str_replace(array(' ','-','(',')'), false, $d->telefone)).'",
                    "observation": "'.$d->observacoes.'",
                    "address": {
                      "street": "'.$d->rua.'",
                      "number": "'.$d->numero.'",
                      "complement": "'.$d->referencia.'",
                      "neighborhood": "'.$d->bairro.'",
                      "city": "Manaus",
                      "state": "AM",
                      "zipCode": "'.trim(str_replace(array(' ','-'), false, $d->cep)).'"
                    },
                    "onlinePayment": true,
                    "productValue": '.$d->total.'
                  }
                ]
              }';

        $mottu = new mottu;

        $retorno1 = $mottu->NovoPedido($json, $d->id_mottu);
        $retorno = json_decode($retorno1);
        if($retorno->id){
            $query = "update vendas set deliveryId = '{$retorno->id}', situacao = 'p', data_finalizacao = NOW(), SEARCHING = NOW() where codigo = '{$codVenda}'";
            mysqli_query($con, $query);
            EnviarWapp('92991886570',"VENDA - Código do pedido (Verificar) *{$codVenda}* ID mottu: {$retorno->id}");
            EnviarWapp('92981829506',"VENDA - Código do pedido (Verificar) *{$codVenda}* ID mottu: {$retorno->id}");
        }
        }else{
        $query = "update vendas set situacao = 'p', data_finalizacao = NOW() where codigo = '{$codVenda}'";
        mysqli_query($con, $query);

        EnviarWapp('92991886570',"VENDA - Código do pedido (Retirada do pedido na loja - PIX) *{$codVenda}*");
        EnviarWapp('92981829506',"VENDA - Código do pedido (Retirada do pedido na loja - PIX) *{$codVenda}*");
        }
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

            Carregando();
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:`src/cliente/pedidos.php`,
                },
                success:function(dados){
                    $.alert('Pagamento Confirmado.<br>Seu pedido está sendo preparado!');
                    PageClose(2);
                    $(".ms_corpo").append(dados);
                }
            });

        <?php
        }
        ?>
    })
</script>