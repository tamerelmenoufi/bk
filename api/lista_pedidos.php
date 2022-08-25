<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "SELECT
                a.codigo,
                a.situacao,
                c.nome
        FROM vendas a
        left join clientes c on a.cliente = c.codigo
        where a.situacao in ('p','i') and a.operadora_situacao = 'Approved' and a.deletado != '1' /*and a.loja = '{$_POST['loja']}'*/";



// $data = '2022-08-24';
// $query = "SELECT
//                 a.codigo,
//                 a.situacao,
//                 c.nome,
//                 (select count(*) from vendas_produtos where venda = a.codigo and deletado != '1') as qt
//                 FROM vendas a
//                 left join clientes c on a.cliente = c.codigo
//         where a.data_pedido LIKE '%".$data."%' and a.deletado != '1' and a.situacao in ('i','p')";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    if($d->qt > 0){
        $pedido = '#'.str_pad($d->codigo , 5 , '0' , STR_PAD_LEFT);
        $dados[] = ['codigo'=> $d->codigo, 'pedido' => $pedido, 'cliente' => $d->nome, 'situacao' => $d->situacao];
    }
}

echo json_encode($dados);