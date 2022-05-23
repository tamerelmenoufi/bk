<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'salvar'){
        $query = "update clientes set nome = '{$_POST['nome']}', email = '{$_POST['email']}' where codigo = '{$_SESSION['AppCliente']}'";
        mysqli_query($con, $query);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'msg' => $_POST['nome'],
        ]);

        exit();
    }

    $c = mysqli_fetch_object(mysqli_query($con, "select * from clientes where codigo = '{$_SESSION['AppCliente']}'"));

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
    <h4>Perfil do Cliente</h4>
</div>
<div class="col" style="margin-bottom:60px;">
    <div class="row">
            <div class="col-12">

                <div class="form-group">
                    <label for="nome">
                        Telefone
                        <?php
                        if(!$c->telefone_confirmado){
                        ?>
                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Não Confirmado</span>
                        <?php
                        }
                        ?>
                    </label>
                    <div class="form-control form-control-lg" style="cursor:pointer; background-color:#ccc;"><?=$c->telefone?></div>
                </div>

                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control form-control-lg" id="nome" placeholder="Seu Nome Completo" value="<?=$c->nome?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control form-control-lg" id="email" placeholder="seuemail@seudominio.com" value="<?=$c->email?>">
                </div>
                <button SalvarDados type="buttom" class="btn btn-secondary btn-lg">Salvar dados</button>
            </div>


            <div class="col-12">
                <div class="ConfirmaTelefone">
                        Seu Cadastro não está completo, é necessário confirmar o seu telefone.<br>
                        <span class="text-primary">Clique aqui e confirme agora!</span>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function(){

        $("button[SalvarDados]").click(function(){
            nome = $("#nome").val();
            email = $("#email").val();

            if(!nome || !email){
                $.alert({
                    content:'Preencha os campos do formulário!',
                    title:false,
                    type: "red",
                });
                return false;
            }

            $.ajax({
                url:"src/cliente/perfil.php",
                type:"POST",
                data:{
                    nome,
                    email,
                    acao:'salvar'
                },
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    //$.alert(retorno.status);
                    if(retorno.status){
                        $.alert({
                            content:'Dados salvos com sucesso!',
                            title:false,
                            type: "green",
                        });
                        $("span[ClienteNomeApp]").html(retorno.msg);
                        PageClose();
                    }
                }
            });

            $(".ConfirmaTelefone").click(function(){
                $.ajax({
                    url:"componentes/ms_popup.php",
                    data:{
                        local:"src/clientes/confirmar_telefone.php",
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });
            });

        });

    })
</script>