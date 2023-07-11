<?php

function sis_logs($tabela, $codigo, $query, $operacao = null)
{
    global $con;
    $usuario = $_SESSION['usuario']['codigo'];
    $operacao = $operacao ?: strtoupper(trim(explode(' ', $query)[0]));
    $query = mysqli_real_escape_string($con, $query);
    $data = date("Y-m-d H:i:s");

    $query_log = "INSERT INTO sis_logs "
        . "SET usuario = '{$usuario}', registro = '{$codigo}', operacao = '{$operacao}', query = '{$query}', "
        . "tabela = '{$tabela}', data = '{$data}'";

    mysqli_query($con, $query_log);
}

function exclusao($tabela, $codigo, $fisica = false)
{
    global $con;
    if ($fisica) {
        $query = "DELETE FROM {$tabela} WHERE codigo = '{$codigo}'";
    } else {
        $query = "UPDATE {$tabela} SET deletado = '1' WHERE codigo = '{$codigo}'";
    }

    if (mysqli_query($con, $query)) {
        sis_logs($codigo, $query, $tabela, 'DELETE');
        return true;
    } else {
        return false;
    }
}

function ListaLogs($tabela, $registro){
    global $con;
    $Query = [];
    $query = "select a.*, b.nome from sis_logs a left join usuarios b on a.usuario=b.codigo where a.tabela = '{$tabela}' and a.registro = '{$registro}' order by a.codigo asc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

        switch($d->operacao){

            case 'INSERT':{
                $Query[] = [$d->data, $d->operacao, $d->nome, InsertQuery($d->query)];
                break;
            }
            case 'UPDATE':{
                $Query[] = [$d->data, $d->operacao, $d->nome, UpdateQuery($d->query)];
                break;
            }

        }

    }
    return $Query;
}

function InsertQuery($query){
    list($l, $d) = explode("SET", $query);
    $d = str_replace("=","=>", $d);
    eval("\$r = [{$d}];");
    return $r;
}

function UpdateQuery($query){
    list($l, $d) = explode("SET", $query);
    list($d, $l) = explode("WHERE", $d);
    $d = str_replace("=","=>", $d);
    eval("\$r = [{$d}];");
    return $r;

}


function VerificarVendaApp(){
    global $SESSION;
    global $con;

    $tempo = date("Y-m-d H:i:s", mktime((date("H") - 12), date("i"), date("s"), date("m"), date("d"), date("Y")));


    $r = mysqli_query($con, "SELECT * FROM vendas WHERE cliente = '{$_SESSION['AppCliente']}' AND deletado != '1' AND operadora_situacao = '' LIMIT 1");
    $n = mysqli_num_rows($r);

    if(!$n){

        mysqli_query($con, "INSERT INTO vendas SET cliente = '{$_SESSION['AppCliente']}', data_pedido = NOW()");
        $_SESSION['AppVenda'] = mysqli_insert_id($con);

        //$_SESSION = [];
        // header("location:./?s=1");
        echo "<script>window.localStorage.setItem('AppVenda','{$_SESSION['AppVenda']}');</script>";
        //echo "<h1>TESTE 1</h1>";
        //exit();
    }else{
        $_SESSION['AppVenda'] = mysqli_fetch_object($r)->codigo;
        echo "<script>window.localStorage.setItem('AppVenda','{$_SESSION['AppVenda']}');</script>";
        // if(mysqli_fetch_object($r)->atualiza == 'u'){
            mysqli_query($con, "UPDATE vendas SET data_pedido = NOW() where codigo = '{$_SESSION['AppVenda']}'");
        // }
        //echo "<h1>TESTE 2</h1>";
    }

}




////////////////////////////////////////////////////////////////////////////

function VerificarItens($l=false){
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

                foreach($lojas as $i => $val){
                    //Dentro do Array status[loja][produto][item] = situação
                    $status[$i][$d->codigo][$d1->codigo] = $val->situacao;
                }
            }

        }

    }

    if($l){
        $st = true;
        foreach($status[$l] as $i => $v){
            foreach($v as $i1 => $v1){
                if(!$v1) $st = false;
            }
        }
        return ['status' => $st];
    }else{
        return $status;
    }

    // if($status) echo "<pre>"; print_r($status); echo "</pre>";

}

////////////////////////////////////////////////////////////////////////////////////

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
    $st = true;
    if($l){
        foreach($status[$l] as $i => $v){
            if(!$v) $st = false;
        }
    }
    return ["status" => $st];
    // if($status) echo "<pre>"; print_r($status); echo "</pre>";

}




////Verificar promoção/////////////
function ValidarPromocoes(){

    global $con;
    global $_SESSION;

    $q = "select * from cupom where codigo = (select cupom from vendas where codigo = '{$_SESSION['AppVenda']}')";
    $cupom = mysqli_fetch_object(mysqli_query($con, $q));

    if($cupom->codigo and $cupom->chave){

        if($cupom->tipo == 'taxa_entrega'){
            $acao = ",valor_cupom = taxa_entrega";
        }else if($cupom->tipo == 'desconto' and $cupom->tipo_desconto == 'v'){
            $acao = ",valor_cupom = '{$cupom->valor}'";
        }else if($cupom->tipo == 'desconto' and $cupom->tipo_desconto == 'p'){
            $acao = ",valor_cupom = (valor/100*".(($cupom->valor > 0)?$cupom->valor:1).")";
        }
        $query = "update vendas set
                                    cupom = '{$cupom->codigo}'
                                    {$acao}
                where codigo = '{$_SESSION['AppVenda']}'";
        mysqli_query($con, $query);
    }
}

////Verificar promoção/////////////