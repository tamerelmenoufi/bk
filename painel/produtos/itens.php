<?php
include("../../lib/includes.php");
?>

<ul class="list-group">
    <?php
    $q = "select * from itens where codigo in (" . implode(", ", $_GET['produtos']) . ")";
    $r = mysqli_query($con, $q);
    while ($p = mysqli_fetch_object($r)) { ?>
        <li excluir="<?= $p->codigo ?>" class="list-group-item d-flex justify-content-between align-items-center">
            <?= $p->item ?>
            <span class="badge badge-pill">
                <i class="fa fa-trash text-color-success"></i>
            </span>
        </li>
    <?php } ?>
</ul>

<script>
    $(function () {
        $("li[excluir]").click(function () {

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