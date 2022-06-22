<?php
    include("../../lib/includes.php");
?>

<style>

</style>


<div class="row">
    <div class='col'>
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

<script>
    $(function(){

        $("button[loja]").click(function(){
            $(".ListaLojas").css("display","none");
        });

    })
</script>