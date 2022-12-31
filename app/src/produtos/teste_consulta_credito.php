<?php
    include("../../../lib/includes.php");

    $_POST['reference'] = 12927;

    require "../../../lib/vendor/rede/Consulta.php";

    echo $retorno;

    echo "<hr>";

    $r = json_decode($retorno);

    var_dump($r);
