<?php
    include("../../../lib/includes.php");
?>
<style>
    .close_popup{
        position:fixed;
        right:20px;
        top:0;
        color:#fff;
        text-shadow: #000 2px 3px 2px;
        font-size:50px;
        font-weight:bold;
        cursor: pointer;
        z-index:10;
    }
    .titulo_categoria{
        position:fixed;
        right:0;
        left:0;
        top:0;
        height:120px;
        /* background-color:yellow; */
        width:100%;
        z-index:9;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        color:#000 !important;
    }
    .card-body{
        color:#333 !important;
    }
</style>

<span class="close_popup">
    <i class="bi bi-x"></i>
</span>

<div class="titulo_categoria">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" >
                <h1><?=$_POST['descricao']?></h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 pt-3" style="background-color:#fff; padding-top:120px;">
            <?php
                $query = "select * from produtos where categoria = '{$_POST['codigo']}' and situacao = '1' and deletado != '1'";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4" style="background-color:rgb(170,58,21,1); display: flex; align-items: center; justify-content: center;">
                        <img src="<?=$caminho_sis."/painel/".(($_POST['codigo'] == 8)?'combos':'produtos')."/icon/".$d->icon?>" class="img-fluid rounded-start" >
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?=$d->produto?></h5>
                            <p class="card-text"><?=$d->descricao?></p>
                            <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>


<script>
    $(function(){
        $(".close_popup").click(function(){
            $(".popup").css("display","none");
            $("body").css("overflow","scroll");
        });
    })
</script>