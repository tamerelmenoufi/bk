<?php
    include("../../lib/includes.php");

    $query = "select * from clientes";
    $result = mysqli_query($con, $query);
?>

<div class="col">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>E-mail</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
<?php
    while($d = mysqli_fetch_object($result)){
?>
            <tr>
                <td><?=$d->nome?></td>
                <td><?=$d->Telefone?></td>
                <td><?=$d->cpf?></td>
                <td><?=$d->email?></td>
                <td><?=$d->data_cadastro?></td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</div>
