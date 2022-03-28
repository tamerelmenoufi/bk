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
    .SemProduto{
        position:fixed;
        top:40%;
        left:0;
        text-align:center;
        width:100%;
        color:#ccc;
    }
    .icone{
        font-size:70px;
    }
</style>
<div class="EnderecoTitulo">
    <h4>Lista de Endereços</h4>
</div>
<div class="col" style="margin-bottom:60px; margin-top:10px;">
    <div class="row">
        <div class="col-12">
            <?php
                $query = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' order by padrao desc";
                $result = mysqli_query($query);
                $n = mysqli_num_rows($result);
                while($d = mysqli_fetch_object($result)){
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
            <div class="SemProduto" style="display:<?=(($n)?'none':'block')?>">
                <i class="fa-solid fa-face-frown icone"></i>
                <p>Poxa, ainda não tem endereços cadastrados!</p>
            </div>
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


        $(".NovoEndereco").click(function(){
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:'src/cliente/endereco_form.php',
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

    })


</script>