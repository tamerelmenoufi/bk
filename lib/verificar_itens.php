<?php
    include("includes.php");

    function VerificarProdutos($cod){
        global $con;
        $query = "select * from produtos where codigo in (".implode(",",$cod).")";
        $result = mysqli_query($con, $query);

        $status = [];

        while($d = mysqli_fetch_object($result)){

            $lojas = [];

            $lojas = json_decode($d->lojas);
            foreach($lojas as $i => $val){
                $status[$i][$d->codigo] = $val->situacao;
            }

        }

        return $status;

        // if($status) echo "<pre>"; print_r($status); echo "</pre>";

    }

// print_r($_GET['cod']);

    if($_GET['cod']) VerificarProdutos($_GET['cod']);