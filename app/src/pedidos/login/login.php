<style>
    .ContainerLogin{
        flex:1,
        justify-content: center;
        align-items: center;
    }
</style>

<div class="ContainerLogin">
    <h3>Tela de login</h3>
    <p>Dados de acesso do meu login da loja</p>
    <button logar class="btn btn-success">Logar</button>
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