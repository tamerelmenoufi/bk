<?php
    //Config
    $ConfTitulo = 'Itens';
    $UrlScript = 'itens/';

    if($_GET['categoria']){
        $_SESSION['categoria'] = $_GET['categoria'];
    }
    $ConfCategoria = mysqli_fetch_object(mysqli_query($con, "select * from categorias_itens where codigo = '{$_SESSION['categoria']}'"));

    //Config ----------
    function getSituacao()
    {
        return [
            '1' => 'Liberado',
            '0' => 'Bloqueado',
        ];
    }