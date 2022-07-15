<?php
    include("../conf.php");

    if($_POST['acao'] == 'logar'){
        $senha = md5($_POST['senha']);
        $query = "select * from usuarios where usuario='{$_POST['login']}' and senha = '{$senha}'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result)){
            $d = mysqli_fetch_object($result);
            $retorno = [
                'status' => true,
                'mensagem' => 'Usuário identificado'
            ];

            $_SESSION['PedidosUsuario'] = $d;

        }else{
            $retorno = [
                'status' => false,
                'mensagem' => 'Dados incorretos ou usuário não cadastrado'
            ];
        }
        echo json_encode($retorno);
        exit();
    }

?>

<style>
    .PaginaPedidos{
        position:fixed;
        left:0;
        top:0;
        bottom:0;
        right:0;
        border:1px solid red;
    }
    .BotaoSair:{
        position:fixed;
        right:10px;
        top:10px;
    }
    .IdentificaUser{
        position:fixed;
        left:10px;
        top:10px;
        color:#333;
        font-size:12px;
    }
</style>

<div class="PaginaPedidos">
    <span class="IdentificaUser"><?=$Uconf->nome?></span>
    <button Sair type="button" class="btn btn-danger BotaoSair">Sair</button>
</div>


<script>
    $(function(){
        Carregando('none');

        $("button[Sair]").click(function(){

            Carregando();
            $.ajax({
                url: "src/pedidos/login/login.php",
                success: function (dados) {
                    $(".ms_corpo").html(dados);
                }
            });

        });


    })
</script>