<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    $q = "select * from itens where categoria = '{$_GET['categoria']}'";
    $r = mysqli_query($con, $q);
    while($p = mysqli_fetch_object($r)){
?>
    <li item="<?=$p->codigo?>" class="list-group-item list-group-item-action"><?=$p->item?></li>
<?php
    }
?>
</ul>

<script>
    $(function () {

        $("li[item]").off('click').on('click', function(){
            produto = parseInt($(this).attr("item"));
            codigos = $("div[itens]").attr("codigos");
            existe = [];
            existe = JSON.parse("[" + codigos + "]");

            if(existe.includes(produto) === false){
                console.log(existe.includes(produto));
                existe.push(produto);
                $("div[itens]").attr("codigos", existe);
            }
            console.log(existe);



            $.ajax({
                url:"produtos/itens.php",
                data:{
                    produtos:existe,
                },
                success:function(dados){
                    $("div[itens]").html(dados);
                }
            });


        });


    });
</script>