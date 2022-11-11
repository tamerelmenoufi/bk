<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT * FROM usuarios where
                                        cpf = '{$_POST['cpf']}' and
                                        senha = '".md5($_POST['senha'])."' and
                                        perfil = '".$_POST['perfil']."' and
                                        lojas in (".$_POST['loja'].")
        ";
$result = mysqli_query($con, $query);
$dados = [];
if(mysqli_num_rows($result)){
    $d = mysqli_fetch_object($result);
    $dados = [
        status => true,
        cod_usuario => $d->codigo,
        nome_usuario => $d->nome,
    ];
}else{
    $dados = [
        status => false,
        cod_usuario => false,
        nome_usuario => false,
        query=> $query
    ];
}

echo json_encode($dados);