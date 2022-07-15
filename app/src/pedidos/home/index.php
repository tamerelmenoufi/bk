Lista dos novos pedidos


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