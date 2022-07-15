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
    .BotaoSair{
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
        height:60px;
    }
    .ListaLojas{
        position:fixed;
        top:60px;
        width:100%;
        padding:10px;
        border:solid 1px red;
    }
    .ListaPedidos{
        position:fixed;
        top:150px;
        width:100%;
        bottom:0;
        border:solid 1px green;
        overflow:auto;
    }
</style>

<div class="PaginaPedidos">
    <span class="IdentificaUser"><?=$Uconf->nome?></span>
    <button Sair type="button" class="btn btn-danger BotaoSair">Sair</button>
</div>
<div class="ListaLojas">
    <div class="form-group">
    <label for="ListaLoja">Selecione a Loja</label>
        <select class="form-control" id="ListaLoja">
        <option value="">::Selecione a Loja::</option>
            <?php
                $Lojas = ($Uconf->lojas)?:'0';
                $query = "select * from lojas where codigo in({$Lojas}) and situacao = '1' order by nome";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <option value="<?=$d->codigo?>"><?=$d->nome?></option>
            <?php
                }
            ?>
        </select>
    </div>
</div>
<div class="ListaPedidos">

</div>
<script>
    $(function(){
        Carregando('none');

        opcLoja = window.localStorage.getItem('bk_pedidos_loja');
        $("#ListaLoja").val(opcLoja);

        $("#ListaLoja").change(function(){
            Loja = $(this).val();
            window.localStorage.setItem('bk_pedidos_loja',Loja);

        });

        $("button[Sair]").click(function(){

            Carregando();
            $.ajax({
                url: "src/pedidos/login/login.php",
                data:{
                    s:'1'
                },
                success: function (dados) {
                    window.localStorage.removeItem('bk_pedidos_loja');
                    $(".ms_corpo").html(dados);
                }
            });

        });


    })
</script>