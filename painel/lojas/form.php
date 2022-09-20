<?php
include("../../lib/includes.php");
include "./conf.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $attr = [];

    $codigo = $data['codigo'] ?: null;

    $lojas = implode(",",$data['lojas']);

    unset($data['codigo'], $data['senha_2'], $data['lojas']);

    $query_existe = "SELECT codigo FROM lojas WHERE nome = '{$data['nome']}'";

    if (mysqli_num_rows(mysqli_query($con, $query_existe)) and !$codigo) {
        echo json_encode([
            "status" => false,
            "msg" => "Nome de loja já existe",
        ]);

        exit();
    }

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    $attr = implode(', ', $attr);

    if ($codigo) {
        $query = "UPDATE lojas SET {$attr} WHERE codigo = '{$codigo}'";
    } else {
        $query = "INSERT INTO lojas SET {$attr}";
    }

    #file_put_contents("query.txt",$query);

    if (mysqli_query($con, $query)) {
        $codigo = $codigo ?: mysqli_insert_id($con);

        sis_logs('lojas', $codigo, $query);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso ',
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
    $query = "SELECT * FROM lojas WHERE codigo = '{$codigo}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $Lojas = [];
    if($d->lojas){
        $Lojas = explode(',',$d->lojas);
    }

}

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="./">Início</a></li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="#" url="<?= $UrlScript; ?>/index.php"><?= $ConfTitulo ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?>
        </li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?> <?= $ConfTitulo ?>
        </h6>
    </div>
    <div class="card-body">
        <form id="form-<?= $md5 ?>">


            <div class="form-group">
                <label for="nome">Nome <i class="text-danger">*</i></label>
                <div class="form-control"><?= $d->nome; ?></div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="senha">Senha <i class="text-danger">*</i></label>
                        <input
                                type="password"
                                class="form-control"
                                id="senha"
                                name="senha"
                                value="<?= !$codigo ? $d->senha : ''; ?>"
                            <?= !$codigo ? 'required' : ''; ?>
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="senha_2">Confirmar senha <i class="text-danger">*</i></label>
                        <input
                                type="password"
                                class="form-control"
                                id="senha_2"
                                name="senha_2"
                            <?= !$codigo ? 'required' : ''; ?>
                        >
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

        $("#cpf").mask("999.999.999-99");

        $('#form-<?=$md5?>').validate({
            rules: {
                senha: {
                    minlength: 4
                },
                senha_2: {
                    minlength: 4,
                    equalTo: '[name="senha"]'
                }
            },
            messages: {
                senha: {
                    minlength: 'Digite minímo 4 caracteres'
                },
                senha_2: {
                    minlength: 'Digite minímo 4 caracteres',
                    equalTo: 'As senhas não conferem'
                }
            }
        });

        $('#form-<?=$md5?>').validate();

        $('#form-<?=$md5?>').submit(function (e) {
            e.preventDefault();

            if (!$(this).valid()) return false;

            var codigo = $('#codigo').val();
            var dados = $(this).serializeArray();

            if (codigo) {
                dados.push({name: 'codigo', value: codigo})
            }

            $.ajax({
                url: '<?= $UrlScript; ?>/form.php',
                method: 'POST',
                data: dados,
                success: function (response) {
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