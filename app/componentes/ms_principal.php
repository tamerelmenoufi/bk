<?php
    include("../../lib/includes.php");
?>
<style>
    .topo{
        position:fixed;
        width:100%;
        height:60px;
        background:#502314;
        left:0;
        top:0;
        z-index:2;
    }

    .rodape{
        position:fixed;
        width:100%;
        height:65px;
        background:#502314;
        left:0;
        bottom:0;
    }
    .rodape .row .col{
        color:#fff;
        text-align:center;
        font-size:30px;
    }
    .rodape .row .col p{
        font-size:10px;
        text-align:center;
        color:#fff;
        padding:0;
        margin:0;
    }

    .categorias_home{
        position:fixed;
        top:60px;
        padding-top:5px;
        padding-bottom:5px;
        width:100%;
        height:125px;
        background:#f5ebdc;
    }

    .pagina{
        position:fixed;
        top:185px;
        bottom:65px;
        width:100%;
        overflow:auto;
        background:#f5ebdc;
        padding:10px;
        z-index:1;
    }



    .categoria_combo{
        position:relative;
        width:100%;
        margin-bottom:15px;

    }

</style>
<div class="topo"></div>

<div class="categorias_home"></div>

<div class="pagina">

    <div class="categoria_combo"></div>

<!-- <?php
    $query = "select * from categorias where deletado != '1' and situacao = '1' and categoria != 'COMBOS'";
    $result = mysqli_query($con,$query);
    while($d = mysqli_fetch_object($result)){
?>
    <button
            class="btn btn-danger btn-lg btn-block"
            acao<?=$md5?>
            local="src/produtos/produtos.php?categoria=<?=$d->codigo?>"
            janela="ms_popup_100"
    >
        <?=$d->categoria?>
    </button>
<?php
    }
?> -->
</div>
<div class="rodape"></div>


<script>
    $(function(){

        Carregando('none');

        $.ajax({
            url:"componentes/ms_topo.php",
            success:function(dados){
                $(".topo").html(dados);
            }
        });

        $.ajax({
            url:"componentes/ms_rodape.php",
            success:function(dados){
                $(".rodape").html(dados);
            }
        });


        $.ajax({
            url:"componentes/ms_categorias_scroll.php",
            success:function(dados){
                $(".categorias_home").html(dados);
            }
        });


        $.ajax({
            url:"componentes/ms_combos.php",
            success:function(dados){
                $(".categoria_combo").html(dados);
            }
        });



        $("button[acao<?=$md5?>]").off('click').on('click',function(){

            AppPedido = window.localStorage.getItem('AppPedido');
            AppCliente = window.localStorage.getItem('AppCliente');

            if(!AppCliente || AppCliente === null || AppCliente === undefined){

                Carregando();
                $.ajax({
                    url:"componentes/ms_popup_100.php",
                    type:"POST",
                    data:{
                        local:"src/cliente/cadastro.php",
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });

            }else{
                local = $(this).attr('local');
                janela = $(this).attr('janela');
                Carregando();
                $.ajax({
                    url:"componentes/"+janela+".php",
                    type:"POST",
                    data:{
                        local,
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });
            }
        })

    })

</script>