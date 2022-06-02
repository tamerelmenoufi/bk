<?php

    include("../../includes.php");

    echo "<h1>{$md5}</h1>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = json_decode(file_get_contents('php://input'), true);


    if($_GET and !$_POST) $_POST = $_GET;

    $dadosLog = print_r($_POST,true);

    if($_POST){
        file_put_contents("logs/retorno_".date("YmdHis").".txt",$dadosLog);

        $dados = json_decode($_POST);

        $operadora_id = $dados->id;
        $forma_pagamento = $dados->payment_method_id;
        $operadora_situacao = $dados->status;
        $qrcode = $dados->point_of_interaction->transaction_data->qr_code;
        $qrcode_img = $dados->point_of_interaction->transaction_data->qr_code_base64;

    }