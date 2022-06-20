<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    $q = "select * from itens where categoria = '{$_GET['categoria']}'";
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

        $("li[produto]").off('click').on('click', function(){
            produto = parseInt($(this).attr("produto"));
            codigos = $("div[combo]").attr("codigos");
            existe = [];
            existe = JSON.parse("[" + codigos + "]");

            if(existe.includes(produto) === false){
                console.log(existe.includes(produto));
                existe.push(produto);
                $("div[combo]").attr("codigos", existe);
            }
            console.log(existe);


            $.ajax({
                url:"combos/combo.php",
                data:{
                    produtos:existe,
                },
                success:function(dados){
                    $("div[combo]").html(dados);
                }
            });


        });


    });
</script>