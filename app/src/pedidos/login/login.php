<h3>Tela de login</h3>
<p>Dados de acesso do meu login da loja</p>
<button class="btn btn-success">Logar</button>


<script>
    $(function(){
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
    })
</script>