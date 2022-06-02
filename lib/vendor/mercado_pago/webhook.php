<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = json_decode(file_get_contents('php://input'), true);


    if($_GET and !$_POST) $_POST = $_GET;

    $dadosLog = print_r($_POST,true);

    if($_POST){
        file_put_contents("logs/retorno_".date("YmdHis").".txt",$dadosLog);

        

    }