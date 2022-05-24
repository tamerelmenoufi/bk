<?php

    include("../../../lib/includes.php");
    $q = "select * from clientes where codigo = '{$_SESSION['AppCliente']}'";
    $c = mysqli_fetch_object(mysqli_query($con, $q));

    if($_POST['envio'] == 'SMS'){

        $retorno = ['status' => true];

        echo json_encode($retorno);
        exit();

    }


?>

<style>
    .ClienteTopoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
</style>

<div class="ClienteTopoTitulo">
    <h4>
        <i class="fa-solid fa-user"></i> Confirmar Telefone
    </h4>
</div>

<div class="col">
    <div class="col-12">
        <p style="text-align:center">
        O seu telefone <b><?=$c->telefone?></b> informado no cadastro, precisa ser confirmado para liberar o seu cadastro.
        Como deseja receber o código de confirmação?
        </p>
        <button class="sms btn btn-primary btn-block btn-lg"><i class="fa-solid fa-comment-sms"></i> SMS</button>
        <button class="whatsapp btn btn-primary btn-block btn-lg"><i class="fa-brands fa-whatsapp"></i> WHATSAPP</button>

    </div>
</div>


<script>
    $(function(){

        $("button.sms").click(function(){
            Carregando();
            $.ajax({
                url:"src/cliente/confirmar_telefone.php",
                data:{
                    envio:'SMS',
                },
                type:"POST",
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    if(retorno.status){
                        $.ajax({
                            url:"componentes/ms_popup_100.php",
                            type:"POST",
                            data:{
                                local:"src/cliente/perfil.php",
                            },
                            success:function(dados){
                                Carregando('none');
                                PageClose(2);
                                $(".ms_corpo").append(dados);
                            }
                        });
                    }else{
                        $.alert('Ocorreu um erro. Tente novamente!');
                    }
                }
            });
        });

    })
</script>