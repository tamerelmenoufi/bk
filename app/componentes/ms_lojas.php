<?php
    include("../../lib/includes.php");
?>

<style>
    .PainelLojas{
        padding:10px;
    }
</style>

<div class="PainelLojas">
    <div class="row">
        <div class='col'>
            <h4>Selecione a Loja se sua preferência</h4>
            <?php
                $query = "select * from lojas where situacao = '1' order by nome";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <button class="btn btn-primary btn-block mb-2" loja="<?=$d->codigo?>"><?=$d->nome?></button>
            <?php
                }
            ?>
        </div>
    </div>
</div>
<script>
    $(function(){

        $("button[loja]").click(function(){
            $(".ListaLojas").css("display","none");
        });

    })
</script>