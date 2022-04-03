<?php
    include("../../lib/includes.php");

    $query = "select * from produtos where deletado != '1' and situacao = '1' and categoria = '8'";
    $result = mysqli_query($con, $query);
?>
<style>

    .ms_combos{
        position:relative;
        width:100%;
        border-radius:20px;
        background-color:#f2e5d4;
        height:90px;
    }
    .ms_combos p{
        position:absolute;
        top:10px;
        right:15px;
        font-weight:bold;
        font-size:25px;
        color:#333;
    }

</style>

<?php

while ($d = mysqli_fetch_object($result) ) {

    $icone = "../painel/categorias/icon/{$d->icon}";

?>
    <div
        local="src/produtos/produto.php?categoria=<?=$d->codigo?>"
        janela="ms_popup_100"
        class="ms_combos"
    >
        <p><?=$d->produto?></p>
    </div>
<?php
    }
?>

<script>
    $(function(){


    })
</script>