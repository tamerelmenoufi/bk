<?php
    include("../../../lib/includes.php");
    error_reporting(9);
    $query = "select
                    a.venda,
                    sum(a.valor_total) as total,
                    b.nome,
                    b.telefone,
                    b.email
                from vendas_produtos a
                    left join clientes b on a.cliente = b.codigo
                where a.venda = '{$_SESSION['AppVenda']}' and a.deletado != '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>
<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
    .card small{
        font-size:12px;
        text-align:left;
    }
    .card input{
        border:solid 1px #ccc;
        border-radius:3px;
        background-color:#eee;
        color:#333;
        font-size:20px;
        text-align:center;
        margin-bottom:15px;
        width:100%;
        text-transform:uppercase;
    }
</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar com PIX</h4>
</div>
<div class="col">
    <div class="row">
            <div class="col-12">
                <div class="card mb-3" style="background-color:#fafcff; padding:20px;">
                    <p style="text-align:center">
                        <?php
                            $pedido = str_pad($d->venda, 6, "0", STR_PAD_LEFT);

                            $PIX = new MercadoPago;
                            $retorno = $PIX->Transacao('{
                                "transaction_amount": '.$d->total.',
                                "description": "Pedido '.$pedido.' - Venda BKManaus (Delivery)",
                                "payment_method_id": "pix",
                                "payer": {
                                  "email": "tamer@mohatron.com.br",
                                  "first_name": "Tamer Mohamed",
                                  "last_name": "Elmenoufi",
                                  "identification": {
                                      "type": "CPF",
                                      "number": "60110970225"
                                  },
                                  "address": {
                                      "zip_code": "69010110",
                                      "street_name": "Rua Monsehor Coutinho",
                                      "street_number": "600",
                                      "neighborhood": "Centro",
                                      "city": "Manaus",
                                      "federal_unit": "AM"
                                  }
                                }
                              }');

                              $dados = json_decode($retorno);

                              $operadora_id = $dados->id;
                              $forma_pagamento = $dados->payment_method_id;
                              $operadora_situacao = $dados->status;
                              $qrcode = $dados->point_of_interaction->transaction_data->qr_code;
                              $qrcode_img = $dados->point_of_interaction->transaction_data->qr_code_base64;


                              mysqli_query($con, "update vendas set
                                                                    operadora_id = '{$operadora_id}',
                                                                    forma_pagamento = '{$forma_pagamento}',
                                                                    operadora_situacao = '{$operadora_situacao}'
                                                                    operadora_retorno = '{$retorno}'
                                                    where codigo = '{$d->venda}'
                                        ");

                        ?>
                        Utilize o QrCode para pagar a sua conta ou copie o códio PIX abaixo.
                    </p>
                    <div style="padding:20px;">
                        <img src="data:image/png;base64,<?=$qrcode_img?>" style="width:100%"></i>
                    </div>
                    <p style="text-align:center; font-size:12px;">Seu Código PIX</p>
                    <p style="text-align:center; font-size:16px;">
                        <pre>
                            <?=$qrcode?>
                        </pre>
                    </p>
                    <button class="btn btn-secondary btn-lg btn-block"><i class="fa-solid fa-copy"></i> Copiar Código PIX</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#cartao_numero").mask("9999 9999 9999 9999");
        $("#cartao_validade_mes").mask("99");
        $("#cartao_validade_ano").mask("9999");
        $("#cartao_ccv").mask("9999");
    })
</script>