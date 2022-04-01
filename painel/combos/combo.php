<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    $q = "select * from produtos where codigo in (".implode(", ", $_GET['produtos']).")";
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

        $("li[excluir]").click(function(){

            opc = parseInt($(this).attr("excluir"));

            produto = parseInt($(this).attr("produto"));
            codigos = $("div[combo]").attr("codigos");
            atualiza = [];
            atualiza = JSON.parse("[" + codigos + "]");

            atualiza.splice(atualiza.indexOf(opc), 1);

            $("div[combo]").attr("codigos", atualiza);


            $.ajax({
                url:"combos/combo.php",
                data:{
                    produtos:atualiza,
                },
                success:function(dados){
                    $("div[combo]").html(dados);
                }
            });



        })

    });
</script>