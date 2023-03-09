<?php
    include("../lib/includes.php");
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ff0000"/>
    <title>APP</title>
    <?php include("../lib/header.php"); ?>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/app.css">


</head>
<body>


<div class="ms_corpo">

<h2>Lista de pedidos</h2>

<?php
    $query = "SELECT
    a.*,
    concat( a.produto_nome, ' [', a.quantidade ,' x R$', a.valor_unitario , ' = R$' , a.valor_total, '] ' ) as produto_nome,
    b.categoria,
    b.descricao,
    concat(c.prefixo,' ',c.categoria) as nome_categoria,
    v.situacao,
    v.SEARCHING,
    v.GOING_TO_ORIGIN,
    v.ARRIVED_AT_ORIGIN,
    v.GOING_TO_DESTINATION,
    v.ARRIVED_AT_DESTINATION,
    v.name,
    v.phone,
    v.loja,
    e.entrega_gratis,
    cl.nome as cliente_nome,
    cl.telefone as cliente_telefone,
    concat(trim(e.rua), ', ',  trim(e.numero), ', ', trim(e.bairro), ', ', trim(e.complemento), ', ', trim(e.referencia)) as endereco
        FROM vendas_produtos a
        left join produtos b on a.produto = b.codigo
        left join vendas v on a.venda = v.codigo
        left join categorias c on b.categoria = c.codigo
        left join clientes cl on v.cliente = cl.codigo
        left join clientes_enderecos e on v.cliente = e.cliente and e.padrao = '1'
    where v.loja = '{$_GET['l']}' and a.deletado != '1' and v.deletado != '1' and v.operadora_situacao = 'approved' order by v.data_pedido desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>
Lista: <?=$d->codigo?><br>
<?php
    }
?>

</div>

<?php include("../lib/footer.php"); ?>



<script src="<?= "js/app.js?" . date("YmdHis"); ?>"></script>
<script src="<?= "js/wow.js"; ?>"></script>

<script>
    $(function () {


    })


    //Configurações globais

    //Jconfirm
    jconfirm.defaults = {
        theme: "modern",
        type: "blue",
        typeAnimated: true,
        smoothContent: true,
        draggable: false,
        animation: 'bottom',
        closeAnimation: 'top',
        animateFromElement: false,
        animationBounce: 1.5
    }

</script>
<form></form>
</body>
</html>