<?php
    include("includes.php");

    function VerificarItens($cod){
        global $con;
        $query = "select * from produtos where codigo = '{$cod}'";
        $result = mysqli_query($con, $query);

        $d = mysqli_fetch_object($result);

        $itens = json_decode($d->itens);

        print_r($itens);

        echo "<hr>";

        foreach($itens as $i => $val){
            echo $val->produto."<br>";
        }

    }

    if($_GET['cod']) VerificarItens($_GET['cod']);