<?php
    include("../../lib/includes.php");
    echo $_GET['cod'];
    echo "<br><br>";

    $query = "select a.*, b.categoria from produtos a left join categorias b on a.categoria = b.codigo where a.deletado != '1' and b.deletado != '1' and a.situacao = '1' and b.situacao = '1' order by b.ordem asc, a.produto asc";
    $result = mysqli_query($con, $query);
    $categoria = false;
    while($d = mysqli_fetch_object($result)){
        if($categoria != $d->categoria){
            $categoria = $d->categoria;
            echo "<h5>{$categoria}</h5>";
        }
        ?>
        <div class="row">
            <div class="col-md-10"><?=$d->produto?></div>
            <div class="col-md-2">
                Ação
            </div>
        </div>
    <?php
        // echo "{$d->produto}<br>";
    }