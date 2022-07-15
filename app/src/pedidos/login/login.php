<style>
    .ContainerLogin{
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
        align-items: center;
        border: solid 1px red;
        justify-items: center;
        justify-content: center;

    }

</style>

<div class="ContainerLogin">
    <h3>Tela de login</h3>
    <p>Dados de acesso do meu login da loja</p>
    <div class="card m-3 p-3">

        <div class="form-group mb-2">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" placeholder="Digite seu login">
        </div>

        <div class="form-group mb-2">
            <label for="senha">Senha</label>
            <input type="text" class="form-control" id="senha" placeholder="Digite sua senha">
        </div>

        <button logar type="button" class="btn btn-primary">Logar</button>

    </div>
</div>

<script>
    $(function(){
        $("button[logar]").click(function(){
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:"src/pedidos/home/index.php",
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                }
            });
        });

    })
</script>