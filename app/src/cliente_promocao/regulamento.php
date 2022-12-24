<?php
    include("../../../lib/includes.php");
?>

<h3>Regulamento para o sorteio</3>

<h4>Campanha: #EUTONABKMANAUS</h4>

<p>
Participe do Sorteio para concorrer a 6 (seis) COMBOS WHOPPER/Q por semana.<br>
Os sorteios serão divulgados em eventos/shows e postagens nas mídias sociais<br>
A campanha atual terá validade até o dia 24 de dezembro de 2022<br>
Os participantes devem informar o nome completo e o número de telefone WhatsApp<br>
A confirmação do cadastro será enviada em forma de mensagem no WhatsApp cadastrado<br>
Na mensagem enviada será informado o número de participação no sorteio<br>
Os sorteados deverão comprovar em qualquer uma das lojas BKMANAUS, o seu nome completo, número de telefone WhatsApp e o código fornecido na inscrição.<br>
</p>
<p>Boa Sorte</p>

<p style="text-align:center">
    <button class="btn btn-primary aceito_termos">Aceito</button>
</p>


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