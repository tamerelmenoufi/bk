<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    echo $q = "select * from produtos where codigo in ({$_GET['produtos']})";
    $r = mysqli_query($con, $q);
    while($p = mysqli_fetch_object($r)){
?>
    <li excluir="<?=$p->codigo?>" class="list-group-item list-group-item-action"><?=$p->produto?></li>
<?php
    }
?>
</ul>

<script>
    $(function(){

        $("li[produto]").click(function(){

            produto = $(this).attr("produto");
            codigos = $("div[combo]").attr("codigos");
            existe = JSON.parse("[" + codigos + "]");
            if(existe.includes(produto) === false){
                existe.push(produto);
                $("div[combo]").attr("codigos", existe);
            }

        });


    });
</script>