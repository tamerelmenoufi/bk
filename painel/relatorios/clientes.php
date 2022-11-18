<?php
    include("../../lib/includes.php");

    $query = "select * from clientes order by nome desc";
    $result = mysqli_query($con, $query);
?>
<style>
    .relatorio_cliente td, .relatorio_cliente th{
        font-size:12px;
        white-space:nowrap;
    }
</style>
<div class="col">
    <table class="relatorio_cliente table table-hover">
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
                <td style="color:<?=(($d->telefone_confirmado)?'green':'red')?>"><?=$d->telefone?></td>
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
