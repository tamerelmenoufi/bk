<?php
    include("../../lib/includes.php");
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
                <i class="fa fa-toggle-on fa-3x" aria-hidden="true"></i>
            </div>
        </div>
    <?php
        // echo "{$d->produto}<br>";
    }