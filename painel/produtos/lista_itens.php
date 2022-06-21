<?php

    include("../../lib/includes.php");


    if ($_GET['codigo']) {
        $query = "SELECT * FROM produtos WHERE codigo = '{$_GET['codigo']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);


        $ItensDoProduto = json_decode($d->itens);

        print_r($ItensDoProduto);

        $Codigos = [];
        $produtos = false;
        foreach($ItensDoProduto as $ind => $val){
            $Codigos[] = $val->produto;
        }
        if($Codigos) $produtos = implode(", ",$Codigos);
    }

?>

<ul class="list-group">
<?php
    $q = "select * from itens where categoria = '{$produtos}'";
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