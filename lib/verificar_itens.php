<?php
    include("includes.php");

    function VerificarItens($cod, $loja = 10){
        global $con;
        $query = "select * from produtos where codigo in (".implode(",",$cod).")";
        $result = mysqli_query($con, $query);

        $status = [];

        while($d = mysqli_fetch_object($result)){

            $Itens = [];


            $itens = json_decode($d->itens);
            foreach($itens as $i => $val){
                $Itens[] = $val->produto;
            }


            if($Itens){

                $query1 = "select * from itens where codigo in (".implode(",",$Itens).")";
                $result1 = mysqli_query($con, $query1);

                while($d1 = mysqli_fetch_object($result1)){
                    $lojas = json_decode($d1->lojas);

                    // print_r($lojas);
                    // echo "<hr>";

                    foreach($lojas as $i => $val){
                        $status[$d->codigo][$i][$d->codigo] = $val->situacao;
                    }
                }

            }

        }



        if($status) echo "<pre>"; print_r($status); echo "</pre>";

    }

// print_r($_GET['cod']);

    if($_GET['cod']) VerificarItens($_GET['cod']);