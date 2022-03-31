<?php
    //Config
    $ConfTitulo = 'Combos';
    $UrlScript = 'combos/';

    $ConfCategoria = mysqli_fetch_object(mysqli_query($con, "select * from categorias where categoria = 'combos' and deletado != '1' and situacao = '1'"));

    //Config ----------
    function getSituacao()
    {
        return [
            '1' => 'Liberado',
            '0' => 'Bloqueado',
        ];
    }