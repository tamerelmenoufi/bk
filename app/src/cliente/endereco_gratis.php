<?php
    include("../../../lib/includes.php");

    $query = "select * from clientes_enderecos where cliente = '0' and deletado != '1'";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

    }