<?php
    include("../../../lib/includes.php");

    $query = "select * from vendas where
                                    cliente = '{$_SESSION['AppCliente']}' and
                                    situacao in ('p','i') and
                                    deletado != '1'
                order by codigo desc limit 1
                                    ";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    $n = mysqli_num_rows($result);
    if($n){

?>
<style>
    .alerta{
        position:fixed;
        width:auto;
        height:50px;
        left:80px;
        top:5px;
        padding:10px;
        border-radius:7px;
        border:solid 1px #333;
        background-color:#ccc;
        z-index:10;
        font-size:10px;
    }
</style>
<div style="d-flex justify-content-between align-items-center">
    <span>Pedido <b><?=$d->codigo?></b><br>Em andamento</span>
</div>
<?php
    }
?>