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

<button Sair type="button" class="btn btn-danger btn-lg">Sair</button>

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