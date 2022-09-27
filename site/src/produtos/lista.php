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
</style>

<span class="close_popup">
    <i class="bi bi-x"></i>
</span>


<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3" style="background-color:#fff; margin-top:80px;">
            <?php
                $query = "select * from produtos where 1";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?=$caminho_sis.'/painel/produtos/icon/'.$d->icon?>" class="img-fluid rounded-start" >
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