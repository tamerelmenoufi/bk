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
<h4>Campanha: #EUTONABKMANAUS</h4>

<p>
<li>Participe do Sorteio para concorrer a 6 (seis) COMBOS WHOPPER/Q por semana;</li><br>
<li>Os sorteios serão divulgados em eventos/shows e postagens nas mídias sociais;</li><br>
<li>A campanha atual terá validade até o dia 24 de dezembro de 2022;</li><br>
<li>Os participantes devem informar o nome completo e o número de telefone WhatsApp;</li><br>
<li>A confirmação do cadastro será enviada em forma de mensagem no WhatsApp cadastrado;</li><br>
<li>Na mensagem enviada será informado o número de participação no sorteio;</li><br>
<li>Os sorteados deverão comprovar em qualquer uma das lojas BKMANAUS, o seu nome completo, número de telefone WhatsApp e o código fornecido na inscrição.</li><br>
</p>
<p>Boa Sorte</p>

<p style="text-align:center">
    <button class="btn btn-primary aceito_termos">Aceito</button>
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