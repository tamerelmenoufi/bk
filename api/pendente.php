<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$dados = ['status' => true, 'loja' => $_POST['loja']];

echo json_encode($dados);