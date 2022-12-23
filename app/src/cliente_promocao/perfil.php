<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        list($cod) = mysqli_fetch_row(mysqli_query($con, "select codigo from clientes where telefone = '{$_POST['telefone']}'"));
        if(!$cod){
            $query = "insert into clientes set
                                        telefone = '{$_POST['telefone']}',
                                        nome = '{$_POST['nome']}',
                                        email = '{$_POST['email']}',
                                        cpf = '{$_POST['cpf']}',
                                        data_promocao = NOW()";
            mysqli_query($con, $query);
            $cod = mysqli_insert_id($con);
        }
        $num = trim($_POST['telefone']);
        $msg = "BKManaus Informa: Parabéns, você está participando da promoção *#EUTONABKMANAUS*. Sua senha de participação é: *{$cod}*";

        $result = EnviarWapp($num,$msg);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'nome' => $_POST['nome'],
        ]);

        exit();
    }


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
    .ConfirmaTelefone{
        width:100%;
        margin-top:20px;
        padding:10px;
        text-align:center;
        border:solid 1px red;
        color:red;
        border-radius:10px;
    }

</style>
<div class="PedidoTopoTitulo">
    <h4>Promoção #EUTONABKMANAUS</h4>
</div>
<div class="col" style="margin-bottom:60px;">
    <div class="row">
            <div class="col-12">
                <div style="width:100%; text-align:center;bottom margin-top:30px; margin-top:10px;">
                    <img src="img/promocao_frete_gratis.gif" alt="Promoção Frete Grátis" style="width:100%; border-radius:10px;" />
                </div>

                <div class="form-group">
                    <label for="nome">Telefone*</label>
                    <input type="telefone" class="form-control form-control-lg" id="telefone" placeholder="Seu telefone WhatsApp" value="">
                </div>

                <div class="form-group">
                    <label for="nome">Nome Completo*</label>
                    <input type="text" class="form-control form-control-lg" id="nome" placeholder="Seu Nome Completo" value="">
                </div>
                <div class="form-group">
                    <label for="nome">CPF*</label>
                    <input type="text" class="form-control form-control-lg" id="cpf" inputmode="numeric" placeholder="CPF" value="">
                </div>
                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input type="email" class="form-control form-control-lg" id="email" placeholder="seuemail@seudominio.com" value="">
                </div>
                <div style="padding:20px; text-align:right; color:#a1a1a1; font-size:10px; width:100%;"><b>* Dados Obrigatórios</b></div>
                <button SalvarDados type="buttom" class="btn btn-secondary btn-lg">Salvar dados</button>
            </div>

        </div>
    </div>
</div>
<script>
    $(function(){

        Carregando('none');

        $("#telefone").mask("(99) 99999-9999");
        $("#cpf").mask("999.999.999-99");

        $("button[SalvarDados]").click(function(){
            telefone = $("#telefone").val();
            nome = $("#nome").val();
            email = $("#email").val();
            cpf = $("#cpf").val();

            if(!telefone || !nome || !email || !cpf){
                $.alert({
                    content:'Preencha os campos obrigatórios(*) no formulário!',
                    title:false,
                    type: "red",
                });
                return false;
            }

            $.ajax({
                url:"src/cliente_promocao/perfil.php",
                type:"POST",
                data:{
                    telefone,
                    nome,
                    email,
                    cpf,
                    acao:'salvar'
                },
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    //$.alert(retorno.status);
                    if(retorno.status){
                        $.alert({
                            content:'<center>Dados salvos com sucesso!<br><br>Enviamos seu código de participação para o seu WhatsAPP!</center>',
                            title:false,
                            type: "green",
                        });
                        PageClose();
                    }
                }
            });

        });

    })
</script>