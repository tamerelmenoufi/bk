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
            <div style="text-align:center; color:#333; font-size:12px;">Selecione a Loja se sua preferência</div>
            <?php
                $query = "select * from lojas where situacao = '1' order by nome";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <button class="btn btn-primary btn-block mb-2" loja="<?=$d->codigo?>"><?=strtoupper($d->nome)?></button>
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