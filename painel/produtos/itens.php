<?php
include("../../lib/includes.php");

if($_GET['acao'] == 'addProduto'){

    $query = "SELECT * FROM produtos WHERE codigo = '{$_GET['produto']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $ItensDoProduto = json_decode($d->itens);

    $ItensDoProduto[] = ['produto' => $_GET['item'], 'quantidade' => 1];

    $ItensDoProduto =  json_encode($ItensDoProduto);

    mysqli_query($con, "update produtos set itens = '{$ItensDoProduto}' where  codigo = '{$_GET['produto']}'");

    $_GET['codigo'] = $_GET['produto'];
}

if ($_GET['codigo']) {
    $query = "SELECT * FROM produtos WHERE codigo = '{$_GET['codigo']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $ItensDoProduto = json_decode($d->itens);

    $Codigos = [];
    $produtos = false;
    foreach($ItensDoProduto as $ind => $val){
        $Codigos[] = $val->produto;
        $Quantidade[$val->produto] = $val->quantidade;
    }
    if($Codigos) $produtos = implode(", ",$Codigos);
}



?>

<ul class="list-group">
    <?php
    $q = "select * from itens where codigo in (" . implode(", ", $Codigos) . ")";
    $r = mysqli_query($con, $q);
    while ($p = mysqli_fetch_object($r)) { ?>
        <li class="list-group-item">
            <div class='row'>
                <div class="col-8"><?= $p->item ?> XX</div>
                <div class="col-2">
                    <input qt="<?= $p->codigo ?>" value="<?=$Quantidade[$p->codigo]?>" type="text" style='width:30px; padding:2; text-align:center; margin:0; background:transparent; border:1px solid #eee; border-radius:2px;' />
                </div>
                <div class="col-2 align-items-right">
                    <span excluir="<?= $p->codigo ?>" class="badge badge-pill" style="cursor:pointer">
                        <i class="fa fa-trash text-danger"></i>
                    </span>
                </div>
            </div>


        </li>
    <?php } ?>
</ul>

<script>
    $(function() {
        $("span[excluir]").click(function () {

            opc = parseInt($(this).attr("excluir"));

            produto = parseInt($(this).attr("item"));
            codigos = $("div[itens]").attr("codigos");
            atualiza = [];
            atualiza = JSON.parse("[" + codigos + "]");

            atualiza.splice(atualiza.indexOf(opc), 1);

            $("div[itens]").attr("codigos", atualiza);

            $.ajax({
                url: "produtos/itens.php",
                data: {
                    produtos: atualiza
                },
                success: function (dados) {
                    $("div[itens]").html(dados);
                }
            });


        })
    });
</script>