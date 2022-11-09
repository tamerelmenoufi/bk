<?php
    include("includes.php");

    function VerificarProdutos($l=false){
        global $con;
        global $_SESSION;

        $query = "select * from vendas_produtos where venda = '{$_SESSION['AppVenda']}' and deletado != '1'";
        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
            $cod[] = $d->produto;
        }

        if(!$cod) return false;

        $query = "select * from produtos where codigo in (".implode(",",$cod).")";
        $result = mysqli_query($con, $query);

        $status = [];

        while($d = mysqli_fetch_object($result)){

            $lojas = [];

            $lojas = json_decode($d->lojas);
            foreach($lojas as $i => $val){
                //Dentro do Array status[loja][produto] = situação
                $status[$i][$d->codigo] = $val->situacao;
            }

        }

        if($l){
            $st = true;
            foreach($status[$l] as $i => $v){
                if(!$v) $st = false;
            }
            return ["status" => $st];
        }else{
            return $status;
        }

        // if($status) echo "<pre>"; print_r($status); echo "</pre>";

    }

// print_r($_GET['cod']);

print_r(VerificarProdutos());