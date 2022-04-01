<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    $q = "select * from produtos where categoria = '{$_GET['categoria']}'";
    $r = mysqli_query($con, $q);
    while($p = mysqli_fetch_object($r)){
?>
    <li produto="<?=$p->codigo?>" class="list-group-item list-group-item-action"><?=$p->produto?></li>
<?php
    }
?>
</ul>

<script>
    $(function () {

        $("li[produto]").click(function(){
            produto = $(this).attr("produto");
            codigos = $("div[combo]").attr("codigos");
            existe = JSON.parse("[" + codigos + "]");
            if(existe.includes(produto) === false){
                codigos = codigos.push(produto);
                $("div[combo]").attr("codigos", codigos);
            }
            console.log(codigos);

        });


    });
</script>