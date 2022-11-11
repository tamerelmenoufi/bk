<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);

$query = "select
                    a.codigo,
                    concat(b.categoria,' - ', a.produto) as nome,
                    JSON_EXTRACT(a.lojas,'$.\"{$_POST['cod']}\".situacao') as situacao
            from produtos a
                left join categorias b on a.categoria = b.codigo
            where
                    a.deletado != '1' and
                    b.deletado != '1' and
                    a.situacao = '1' and
                    b.situacao = '1'
            order by
                    b.ordem asc,
                    a.produto asc
    ";

$result = mysqli_query($con, $query);
$dados = [];
while($d = mysqli_fetch_object($result)){
    $dados[] = $d;

}

echo json_encode($dados);