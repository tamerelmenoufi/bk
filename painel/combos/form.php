<?php
include("../../lib/includes.php");
include "./conf.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $attr = [];

    $codigo = $data['codigo'] ?: null;

    unset($data['codigo']);


    if ($data['file-base']) {
        list($x, $icon) = explode(';base64,', $data['file-base']);
        $icon = base64_decode($icon);
    }
    unset($data['file-base']);



    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    if (!$codigo) $attr[] = "categoria = '" . $ConfCategoria->codigo . "'";

    $attr = implode(', ', $attr);

    if ($codigo) {
        $query = "UPDATE produtos SET {$attr} WHERE codigo = '{$codigo}'";
    } else {
        $query = "INSERT INTO produtos SET {$attr}";
    }

    if (mysqli_query($con, $query)) {
        $codigo = $codigo ?: mysqli_insert_id($con);


        if (file_put_contents("icon/".md5($codigo).".png", $icon)) {
            mysqli_query($con, "UPDATE produtos SET icon = '".md5($codigo).".png' WHERE codigo = '{$codigo}'");
        }

        sis_logs('produtos', $codigo, $query);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'codigo' => $codigo,
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'msg' => 'Erro ao salvar',
            'codigo' => $codigo,
            'mysql_error' => mysqli_error($con),
        ]);
    }

    exit;
}

$codigo = $_GET['codigo'];

if ($codigo) {
    $query = "SELECT * FROM produtos WHERE codigo = '{$codigo}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
}

?>

<style>
    .cor {
        padding-top: 15px;
    }

    .cor:hover {
        background-color: #eee;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="./">Início</a></li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="#" url="<?= $UrlScript; ?>/index.php"><?= $ConfTitulo ?> - <?= $ConfCategoria->categoria ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?>
        </li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?> <?= $ConfTitulo ?> - <?= $ConfCategoria->categoria ?>
        </h6>
    </div>

    <div class="card-body">
        <form id="form-<?= $md5 ?>">
            <div class="form-group">
                <label for="produto">produto <i class="text-danger">*</i></label>
                <input
                        type="text"
                        class="form-control"
                        id="produto"
                        name="produto"
                        value="<?= $d->produto; ?>"
                        required
                >
            </div>

            <!-- <div class="form-group">
                <label for="descricao">Descrição <i class="text-danger"></i></label>

                <textarea
                        class="form-control"
                        id="descricao"
                        name="descricao"
                ><?= $d->descricao; ?></textarea>

            </div> -->

            <!-- <div class="form-group">
                <label for="medidas">Valores <i class="text-danger">*</i></label>

                <?php
                $query1 = "SELECT * FROM categoria_medidas "
                    . "WHERE deletado != '1' AND codigo IN({$ConfCategoria->medidas}) "
                    . "ORDER BY ordem, medida";
                $result1 = mysqli_query($con, $query1);

                $detalhes = json_decode($d->detalhes, true);

                while ($dados = mysqli_fetch_object($result1)):
                    ?>
                    <div class="row cor">
                        <div class="col-md-8">
                            <?= $dados->medida; ?>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>

                                <input
                                        valores
                                        opc="<?= $dados->codigo ?>"
                                        value="<?= $detalhes[$dados->codigo]['valor']; ?>"
                                        type="number"
                                        class="form-control"
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input
                                    situacao
                                    opc="<?= $dados->codigo ?>"
                                    value="<?= (($detalhes[$dados->codigo]['quantidade']) ?: '0') ?>"
                                    type="checkbox" <?= (($detalhes[$dados->codigo]['quantidade']) ? 'checked' : false) ?>
                                    data-toggle="toggle"
                            >
                        </div>

                    </div>
                <?php endwhile; ?>

            </div> -->

            <div class="form-group">
            <!--     <label for="situacao">
                    Imagem <i class="text-danger">*</i>
                </label>-->
                <?php
                if (is_file("icon/{$d->icon}")) {
                    $src="";
                    $style = "width:0px; height:0px;";
                }else{
                    $src="produtos/icon/{$d->icon}?{$md5}";
                    $style = "width:200px; margin-bottom:20px;";
                }
                    ?>
                    <center>
                        <img
                            id="ImagemCombo"
                           src="<?=$src?>"
                           style="<?=$src?>"
                        >
                    </center>

                <!--<input
                        type="file"
                        name="file_<?= $md5 ?>"
                        id="file_<?= $md5 ?>"
                        accept="image/*"
                        style="margin-buttom:20px"
                >
                -->

            </div>

            <div class="form-group">


                <div class="row mb-1">
                    <div class="col">
                        <b>CATEGORIAS</b>
                    </div>
                    <div class="col">
                        <b>PRODUTOS</b>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col"><b>COMBO</b></div>
                            <div class="col">
                                <button type="button" EditarImagem class="btn btn-secondary btn-sm btn-block">
                                    <i class="fa-regular fa-images"></i> Imagem
                                </button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col" style="height:300px; overflow:auto;">
                        <ul class="list-group">
                        <?php
                            $q = "select * from categorias where situacao = '1' and deletado != '1' and categoria != 'COMBOS'";
                            $r = mysqli_query($con, $q);
                            while($c = mysqli_fetch_object($r)){
                        ?>
                            <li categoria="<?=$c->codigo?>" class="list-group-item list-group-item-action"><?=$c->categoria?></li>
                        <?php
                            }
                        ?>
                        </ul>
                    </div>
                    <div produtos class="col" style="height:300px; overflow:auto;">

                    </div>
                    <div combo codigos="<?=(($d->descricao)?:'0')?>" class="col" style="height:300px; overflow:auto;">

                    </div>
                </div>

            </div>




            <div class="form-group">
                <label for="situacao">
                    Situação <i class="text-danger">*</i>
                </label>
                <select
                        class="form-control"
                        id="situacao"
                        name="situacao"
                        required
                >
                    <?php
                    foreach (getSituacao() as $key => $value): ?>
                        <option
                            <?= ($codigo and $d->situacao == $key) ? 'selected' : ''; ?>
                                value="<?= $key; ?>">
                            <?= $value; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" id="codigo" value="<?= $codigo; ?>">

            <button type="submit" class="btn btn-success">Salvar</button>

            <a class="btn btn-danger" href="#" url="<?= $UrlScript; ?>/index.php">Cancelar</a>

        </form>
    </div>
</div>

<script>
    $(function () {

        existe = JSON.parse("[" + $("div[combo]").attr("codigos") + "]");

        $.ajax({
            url:"combos/combo.php",
            data:{
                produtos:existe,
            },
            success:function(dados){
                $("div[combo]").html(dados);
            }
        });



        $('input[situacao]').change(function () {
            opc = $(this).attr("opc");
            if ($(this).prop('checked') === true) {
                $(this).val(opc);
            } else {
                $(this).val('0');
            }
        })

        $("li[categoria]").click(function(){
            categoria = $(this).attr("categoria");
            $.ajax({
                url:"combos/produtos.php",
                data:{
                    categoria
                },
                success:function(dados){
                    $("div[produtos]").html(dados);
                }
            });
        });


        $("button[EditarImagem]").click(function(){
            produtos = $("div[combo]").attr("codigos");
            $.ajax({
                url:"combos/imagem.php",
                data:{
                    produtos
                },
                success:function(dados){
                    $.dialog({
                        content:dados,
                        title:"Gerenciador da Imagem",
                        columnClass:'col-md-12'
                    });
                }
            });
        });

        $('#form-<?=$md5?>').submit(function (e) {

            e.preventDefault();

            var codigo = $('#codigo').val();
            var codigos = $("div[combo]").attr("codigos");
            var file-base = $("#ImagemCombo").attr("src");
            var dados = $(this).serializeArray();

            if (codigo) {
                dados.push({name: 'codigo', value: codigo});
            }

            if (codigos) {
                dados.push({name: 'descricao', value: codigos});
            }

            if (file-base) {
                dados.push({name: 'file-base', value: file-base});
            }


            $.ajax({
                url: '<?= $UrlScript; ?>/form.php',
                method: 'POST',
                data: dados,
                success: function (response) {
                    //console.log(response);
                    //return false;
                    let retorno = JSON.parse(response);

                    if (retorno.status) {
                        tata.success('Sucesso', retorno.msg);

                        $.ajax({
                            url: '<?= $UrlScript; ?>/index.php',
                            data: {codigo: retorno.codigo},
                            success: function (response) {
                                $('#palco').html(response);
                            }
                        })
                    } else {
                        tata.error('Error', retorno.msg);
                    }
                }
            })
        });


    });
</script>



