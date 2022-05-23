<?php

    include("../../../lib/includes.php");

    $c = mysqli_fetch_array(mysqli_query($con, "select * from clientes where codigo = '{$_SESSION['appCliente']}'"));

?>

<style>
    .ClienteTopoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
</style>

<div class="ClienteTopoTitulo">
    <h4>
        <i class="fa-solid fa-user"></i> Confirmar Telefone
    </h4>
</div>

<div class="col">
    <div class="col-12">
        <p style="text-align:center">
        O seu telefone XX <?=$c->telefone?> informado no cadastro, precisa ser confirmado para liberar o seu cadastro.
        Como deseja receber o código de confirmação?
        </p>
        <button class="sms btn btn-primary btn-block btn-lg">POR SMS</button>
        <button class="whatsapp btn btn-primary btn-block btn-lg">POR WHATSAPP</button>

    </div>
</div>