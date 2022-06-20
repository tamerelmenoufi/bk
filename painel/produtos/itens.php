<?php
include("../../lib/includes.php");
?>

<ul class="list-group">
    <?php
    $q = "select * from itens where codigo in (" . implode(", ", $_GET['produtos']) . ")";
    $r = mysqli_query($con, $q);
    while ($p = mysqli_fetch_object($r)) { ?>
        <li Editar="<?= $p->codigo ?>" class="list-group-item">
            <div class='row'>
                <div class="col-8"><?= $p->item ?></div>
                <div class="col-2">
                    <input type="text" style='width:30px; padding:2; text-align:center; margin:0; background:transparent; border:1px solid #eee; border-radius:2px;' />
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