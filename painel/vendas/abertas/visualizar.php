<?php
include "../../../lib/includes.php";
include "conf.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $acao = $_POST["acao"];

    switch ($acao) {
        case "atualiza":
            $codigo = $_POST["codigo"];
            $quantidade = $_POST["quantidade"];
            $valor_total = $_POST["valor_total"];

            $query = "UPDATE vendas_produtos SET quantidade='{$quantidade}', valor_total='{$valor_total}' WHERE codigo = '{$codigo}'";
            mysqli_query($con, $query);

            break;

        case "excluir_produto":
            $codigo = $_POST["codigo"];

            $query = "UPDATE vendas_produtos SET deletado = '1' WHERE codigo = '{$codigo}'";
            file_put_contents("debug.txt", $query);
            if (mysqli_query($con, $query))
                echo "ok";
            else
                echo "error";

            break;
    }
    exit();
}

$codigo = $_GET["codigo"];

$colunas_produtos = "p.produto AS p_produto, p.valor AS p_valor, p.descricao AS p_descricao";

$query = "SELECT vp.*, {$colunas_produtos} FROM vendas_produtos vp "
    . "INNER JOIN produtos p ON p.codigo = vp.produto "
    . "WHERE vp.deletado != '1' AND "
    . "vp.venda = '{$codigo}'";

$result = mysqli_query($con, $query);
?>

<div class="col-md-12">
    <div class="list-group">
        <?php while ($d = mysqli_fetch_object($result)) { ?>

            <div id="vp-<?= $d->codigo; ?>" class="mb-2 bg-gray-100 p-3">
                <div class="position-relative py-2">

                    <div class="d-flex flex-row justify-content-between mb-2">
                        <div>
                            <h5 class="h5 font-weight-bold mb-1"><?= $d->p_produto; ?></h5>

                            <div>
                                <?= $d->p_descricao; ?>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <h5 class="font-weight-bold text-info">
                                R$ <span valor_total_<?= $d->codigo; ?>="<?= $d->valor_total; ?>">
                                <?= number_format(
                                    $d->valor_total,
                                    2,
                                    ',',
                                    '.'
                                ); ?>
                              </span>
                            </h5>
                            <span>
                                R$ <?= number_format(
                                    $d->valor_unitario,
                                    2,
                                    ',',
                                    '.'
                                ); ?>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center"> <!-- Botões de ações -->
                        <div
                                class="d-flex flex-row align-items-center"
                                cod="<?= $d->codigo; ?>"
                                valor_unitario="<?= $d->valor_unitario; ?>"
                                produto="<?= $d->produto; ?>"
                        >
                            <button class="btn btn-sm btn-outline-danger menos" type="button">
                                <i class="fa-solid fa-minus"></i>
                            </button>

                            <div class="quantidade px-3"
                            ><?= $d->quantidade ?>
                            </div>

                            <button class="btn btn-sm btn-outline-success mais mr-1" type="button">
                                <i class="fa-solid fa-plus"></i>
                            </button>

                        </div> <!-- Botões de ações -->

                        <div>
                            <button type="button" class="btn btn-sm btn-outline-danger excluir">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        <?php } ?>
    </div>
</div>


<script>
    $(function () {

        $(".menos").click(function () {
            // @formatter:off
            obj            = $(this).parent("div");
            codigo         = obj.attr('cod');
            valor_unitario = obj.attr("valor_unitario");
            quantidade     = obj.find(".quantidade").html();
            valor_total    = $(`span[valor_total_${codigo}]`).attr("valor_total");

            if (quantidade > 1) {
                valor_total = (valor_total * 1 - valor_unitario * 1);
                $(`span[valor_total_${codigo}]`).attr("valor_total", valor_total);
                $(`span[valor_total_${codigo}]`).text(valor_total.toLocaleString('pt-br', {minimumFractionDigits: 2}));
            }

            quantidade = ((quantidade * 1 > 1) ? (quantidade * 1 - 1) : 1);

            obj.find(".quantidade").html(quantidade);

            valor = valor_unitario * quantidade;

            $(`span[valor_total_${codigo}]`).html(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
            // @formatter:on

            //if(quantidade > 1){
            $.ajax({
                url: "<?= $UrlScript; ?>visualizar.php",
                type: "POST",
                data: {
                    quantidade,
                    valor_total: valor,
                    codigo,
                    acao: 'atualiza'
                }
            });
            //}

        });

        $(".mais").click(function () {
            // @formatter:off
            obj            = $(this).parent("div");
            codigo         = obj.attr('cod');
            valor_unitario = obj.attr('valor_unitario');
            quantidade     = obj.find(".quantidade").html();
            quantidade     = (quantidade * 1 + 1);

            obj.find(".quantidade").html(quantidade);

            valor = valor_unitario * quantidade;

            valor_total = (valor_unitario *1 + quantidade* 1);

            $(`span[valor_total_${codigo}]`).attr("valor_total", valor);
            $(`span[valor_total_${codigo}]`).text(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
            //obj.find("span[valor_total]").html(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
            // @formatter:off

            $.ajax({
                url:"<?= $UrlScript; ?>visualizar.php",
                type:"POST",
                data:{
                    quantidade,
                    valor_total:valor,
                    codigo,
                    acao:'atualiza'
                }
            });
        });

        $(".excluir").click(function(){
            // @formatter:off
            obj            = $(this).parent("div").parent("div");
            produto        = obj.attr("produto");
            codigo         = obj.attr('cod');
            quantidade     = obj.find(".quantidade").html();
            valor_unitario = obj.attr("valor_unitario");
            desconto       = (quantidade * valor_unitario);
            valor_total    = $(`span[valor_total_${codigo}]`).attr("valor_total");
            valor_total    = (valor_total * 1 - valor_unitario * 1);
            // @formatter:on

            n = $("p[Excluirproduto]").length;

            $.confirm({
                content: "Deseja realmente remover este produto?",
                title: false,
                buttons: {
                    'SIM': function () {

                        $(`span[valor_total_${codigo}]`).attr("valor_total", valor_total);
                        $(`span[valor_total_${codigo}]`)
                            .text(valor_total.toLocaleString('pt-br', {minimumFractionDigits: 2}));

                        $.ajax({
                            url: "<?= $UrlScript?>visualizar.php",
                            type: "POST",
                            data: {
                                acao: 'excluir_produto',
                                codigo,
                                produto
                            },
                            success: function (dados) {
                                if (dados === "ok") {
                                    $(`#vp-${codigo}`).remove();
                                }
                            }
                        });

                    },
                    'NÃO': function () {

                    }
                }
            });
        });
    });
</script>