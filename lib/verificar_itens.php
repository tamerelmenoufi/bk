<?php
    include("includes.php");

    function VerificarItens($cod, $loja = 10){
        global $con;
        $query = "select * from produtos where codigo in (".implode($cod).")";
        $result = mysqli_query($con, $query);
        $Itens = [];
        while($d = mysqli_fetch_object($result)){
            $itens = json_decode($d->itens);
            foreach($itens as $i => $val){
                $Itens[] = $val->produto;
            }
        }

        if($Itens){

            $query = "select * from itens where codigo in (".implode($Itens).")";
            $result = mysqli_query($con, $query);
            $status = [];
            while($d = mysqli_fetch_object($result)){
                $lojas = json_decode($d->lojas);

                print_r($lojas);
                echo "<br>";

                // foreach($itens as $i => $val){
                //     $Itens[] = $val->produto;
                // }
            }

        }

    }

    if($_GET['cod']) VerificarItens($_GET['cod']);