<?php
    include("../../../lib/includes.php");
?>

<style>



</style>

<style>
    .EnderecoTitulo{
        width:100%;
        position:fixed;
        padding-left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        background:#f5ebdc;
        z-index:1;
    }
    .mapa{
        width:100%;
        height:200px;
        background-color:#ccc;
    }
    .NovoEndereco{
        position:fixed;
        bottom:0px;
        right:10px;
        font-size:50px;
        color:#502314;
    }
</style>
<div class="EnderecoTitulo">
    <h4>Lista de Endereços</h4>
</div>
<div class="col" style="margin-bottom:60px; margin-top:10px;">
    <div class="row">
        <div class="col-12">
            <?php
                for($i=0;$i<5;$i++){
            ?>
            <div class="card" style="margin-bottom:10px;">
                <div class="card-img-top mapa">

                </div>
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<div class="NovoEndereco">
    <i class="fa-solid fa-circle-plus"></i>
</div>

<script>

    $(function(){

        ViewMap = (p, obj) => {
            $.ajax({
                url:"src/cliente/mapa_visualizar.php",
                data:{
                    p
                },
                success:function(dados){
                    obj.html(dados);
                }

            })
        }

        $(".mapa").each(function(opc){
            obj = $(this);
            ViewMap(opc, obj);
        });

    })


</script>