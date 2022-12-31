<?php
    include("../../../lib/includes.php");

    $_POST['reference'] = 12927;

    require "../../../lib/vendor/rede/Consulta.php";

    echo "<pre>".$retorno."</pre>";

    echo "<hr>";

    $r = json_decode($retorno);

    echo "<pre>";
    var_dump($r);
    echo "</pre>";
