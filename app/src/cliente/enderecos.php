<?php
    include("../../../lib/includes.php");
?>

<style>



</style>

<style>
    .EnderecoTitulo{
        position:fixed;
        left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        z-index:1;
    }

</style>
<div class="EnderecoTitulo">
    <h4>Lista de Endereços</h4>
</div>
<div class="col" style="margin-bottom:60px;">
    <div class="row">
        <div class="col-12">
            <?php
                for($i=0;$i<5;$i++){
            ?>
            <div class="card" style="width: 18rem;">
                <div class="card-img-top" alt="Card image cap"></div>
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

    <script>




</script>