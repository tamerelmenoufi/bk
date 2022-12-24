<?php
    include("../../../lib/includes.php");
?>
<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        z-index:1;
    }
</style>
<div class="p-3">
<div class="PedidoTopoTitulo">
    <h4>Regulamento</h4>
</div>
<h6>Campanha: #EUTONABKMANAUS</h6>

<p>
<li>Participe do Sorteio para concorrer a 6 (seis) COMBOS WHOPPER/Q por semana;</li>
<li>Os sorteios serão divulgados em eventos/shows e postagens nas mídias sociais;</li>
<li>A campanha atual terá validade até o dia 24 de dezembro de 2022;</li>
<li>Os participantes devem informar o nome completo e o número de telefone WhatsApp;</li>
<li>A confirmação do cadastro será enviada em forma de mensagem no WhatsApp cadastrado;</li>
<li>Na mensagem enviada será informado o número de participação no sorteio;</li>
<li>Os sorteados deverão comprovar em qualquer uma das lojas BKMANAUS, o seu nome completo, número de telefone WhatsApp e o código fornecido na inscrição;</li>
<li>Os sorteados poderão resgatar seus prêmios em até 7 (sete) dias corridos após a data da validade da campanha.</li>
</p>
<p><b>Boa Sorte</b></p>

<p style="text-align:center">
    <button class="btn btn-primary btn-lg aceito_termos">Aceito</button>
</p>
</div>

<script>
    $(function(){

        $(".aceito_termos").click(function(){

            Carregando();
            PageClose();
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:"src/cliente_promocao/perfil.php",
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                }
            });


        })

    })
</script>