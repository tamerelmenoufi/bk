<?php
    include("../../../lib/includes.php");

    $query = "select * from clientes_enderecos where codigo = '{$_POST['codigo']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_array($result, MYSQLI_ASSOC);

    echo json_encode($d);