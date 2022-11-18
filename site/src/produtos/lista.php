<?php
    include("../../../lib/includes.php");
?>
<style>
    .close_popup{
        position:fixed;
        right:20px;
        top:-10px;
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
        top:0px;
        height:50px;
        /* background-color:yellow; */
        z-index:9;
        color:#000 !important;
    }
    .card-body{
        color:#333 !important;
    }
</style>



<div class="container">
    <div class="row">
        <div class="" style="background-color:#fff; padding-top:5px;">

        <span class="close_popup">
    <i class="bi bi-x"></i>
</span>

        <div class="" style="background-color:#fff; ">
                <center><h1 style="color:#541f11 !important;font-family:Flame-Regular!important"><?=$_POST['descricao']?></h1></center>
            </div>


            <?php
                $query = "select * from produtos where categoria = '{$_POST['codigo']}' and situacao = '1' and deletado != '1'";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){

                    $descricao = false;
                    if($d->categoria == 8){

                        $q = "select * from produtos where codigo in ({$d->descricao})";
                        $r = mysqli_query($con, $q);
                        while($d1 = mysqli_fetch_object($r)){
                            $descricao .= "{$d1->produto}<br>";
                        }

                    }else{
                        $descricao .= "{$d->descricao}";
                    }

            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4" style="background-color:rgb(255, 170, 0); display: flex; align-items: center; justify-content: center;">
                        <img src="<?=$caminho_sis."/painel/".(($_POST['codigo'] == 8)?'combos':'produtos')."/icon/".$d->icon?>" class="img-fluid rounded-start" >
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family:Flame-Regular!important"><?=$d->produto?></h5>
                            <p class="card-text"><?=$descricao?></p>
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