<?php
include "../../../lib/includes.php";

$codigo = $_GET["codigo"];

$colunas_produtos = "p.produto AS p_produto, p.valor AS p_valor, p.descricao AS p_descricao";

$query = "SELECT vp.*, {$colunas_produtos} FROM vendas_produtos vp "
    . "INNER JOIN produtos p ON p.codigo = vp.produto "
    . "WHERE vp.deletado != '1' AND "
    . "vp.venda = '{$codigo}'";

$result = mysqli_query($con, $query);
?>

<div class="col-md-12">
    <?php while ($d = mysqli_fetch_object($result)) { ?>
        <div class="card">
            <div class="card-body bg-gray-100">
                <h5><?= $d->p_produto; ?></h5>
                <div>
                    <?= $d->p_descricao; ?>
                </div>
                <div class="d-flex flex-row justify-content-end">
                    <span class="">R$ <?= number_format($d->valor_unitario, 2, ',', '.'); ?></span>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row align-items-center">
                        <button
                                class="btn btn-sm btn-outline-danger menos"
                                type="button"
                        >
                            <i class="fa-solid fa-minus"></i>
                        </button>

                        <div
                                class="quantidade px-3"
                        ><?= $d->quantidade ?>
                        </div>

                        <button
                                class="btn btn-sm btn-outline-success mais"
                                type="button"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>

                    <div>
                        <span class="text-primary">
                            <h5 class="font-weight-bold">
                                R$ <?= number_format($d->valor_total, 2, ',', '.'); ?>
                            </h5>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $(function () {
        
    });
</script>