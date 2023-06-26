<?php
    include("../lib/includes.php");

    echo "Estou no teste!";

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
                where a.codigo = '13740'";

                $result = mysqli_query($con, $query);
                $d = mysqli_fetch_object($result);

                $json = "{
                    \"code\": \"{$d->codigo}\",
                    \"fullCode\": \"bk-{$d->codigo}\",
                    \"preparationTime\": 0,
                    \"previewDeliveryTime\": false,
                    \"sortByBestRoute\": false,
                    \"deliveries\": [
                      {
                        \"code\": \"{$d->codigo}\",
                        \"confirmation\": {
                          \"mottu\": true
                        },
                        \"name\": \"{$d->nome}\",
                        \"phone\": \"".trim(str_replace(array(' ','-','(',')'), false, $d->telefone))."\",
                        \"observation\": \"{$d->observacoes}\",
                        \"address\": {
                          \"street\": \"{$d->rua}\",
                          \"number\": \"{$d->numero}\",
                          \"complement\": \"{$d->referencia}\",
                          \"neighborhood\": \"{$d->bairro}\",
                          \"city\": \"Manaus\",
                          \"state\": \"AM\",
                          \"zipCode\": \"".trim(str_replace(array(' ','-'), false, $d->cep))."\"
                        },
                        \"onlinePayment\": true,
                        \"productValue\": {$d->total}
                      }
                    ]
                  }";

                $mottu = new mottu;

                $retorno1 = $mottu->NovoPedido($json, $d->id_mottu);
                $retorno = json_decode($retorno1);

                if($retorno->id == 9999){
                    $query = "update vendas set
                                                deliveryId = '{$retorno->id}',
                                                situacao = 'p',
                                                GOING_TO_DESTINATION = NOW(),
                                                name = 'Unidade Djalma Batista',
                                                phone = '(92) 9843-87438'
                            where codigo = '13740'";
                    mysqli_query($con, $query);
                    EnviarWapp('92991886570',"VENDA - Venda do pedido *13740*");
                }else if($retorno->id){
                    $query = "update vendas set
                                                operadora = 'rede',
                                                operadora_situacao = 'Approved',
                                                data_finalizacao = NOW(),
                                                forma_pagamento = 'credito',
                                                deliveryId = '{$retorno->id}',
                                                situacao = 'c'
                                where codigo = '13740'";
                    mysqli_query($con, $query);
                    EnviarWapp('92991886570',"VENDA - Venda do pedido *13740*");
                }else{
                    EnviarWapp('92991886570',"VENDA - Venda do pedido *13740* não gerou entrega.");
                }

?>