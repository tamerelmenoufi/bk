<?php
    include("../../lib/includes.php");
?>
<style>
    svg[acaoSituacao]{
        cursor:pointer;
    }
</style>
<?php
    echo "<h2><small>Estabelecimento</small> - {$_GET['loja']}</h2>";
    // echo "{$_GET['cod']}<br><br>";

    $query = "select a.*, b.categoria from produtos a left join categorias b on a.categoria = b.codigo where a.deletado != '1' and b.deletado != '1' and a.situacao = '1' and b.situacao = '1' order by b.ordem asc, a.produto asc";
    $result = mysqli_query($con, $query);
    $categoria = false;
    while($d = mysqli_fetch_object($result)){
        if($categoria != $d->categoria){
            $categoria = $d->categoria;
            echo "<hr><h3 style='margin-top:20px;'>{$categoria}</h3>";
        }
        ?>
        <div class="row">
            <div class="col-md-10"><?=$d->produto?></div>
            <div class="col-md-2">
                <i acaoSituacao="off" cod="<?=$d->codigo?>" class="fa fa-toggle-off fa-2x" aria-hidden="true"></i>
            </div>
        </div>
    <?php
        // echo "{$d->produto}<br>";
    }
    ?>
    <script>
        $(function(){
            $("svg[acaoSituacao]").click(function(){
                acao = $(this).attr("acaoSituacao");
                cod = $(this).attr("cod");
                if(acao == 'off'){
                    $(this).removeClass("fa-toggle-off");
                    $(this).addClass("fa-toggle-on");
                    $(this).css("color","green");
                    $(this).attr("acaoSituacao","on");
                }else{
                    $(this).removeClass("fa-toggle-on");
                    $(this).addClass("fa-toggle-off");
                    // $(this).removeCss("color");
                    $(this).attr("acaoSituacao","off");
                }
            });
        })
    </script>