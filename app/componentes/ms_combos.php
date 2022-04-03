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
        height:150px;
        background-position:center;
        background-size:cover;
    }
    .ms_combos p{
        position:absolute;
        top:10px;
        left:15px;
        font-weight:bold;
        font-size:25px;
        color:#502314;
        text-transform: uppercase;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }

    .ms_combos span{
        position:absolute;
        bottom:10px;
        right:15px;
        font-weight:bold;
        font-size:35px;
        color:#502314;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }

    .ms_combos span sup{
        font-weight:normal;
        font-size:20px;
        color:#502314;
    }
    .ms_combos span sub{
        font-weight:bold;
        font-size:25px;
        color:#502314;
    }


</style>

<?php

while ($d = mysqli_fetch_object($result) ) {

    $icone = "../painel/combos/icon/{$d->icon}";

?>
    <div
        local="src/produtos/produto.php?categoria=<?=$d->codigo?>"
        janela="ms_popup_100"
        class="ms_combos"
        style="background-image:url(<?=$icone?>)"
    >
        <p><?=$d->produto?></p>
        <span> <sub>R$</sub> 56<sup>,99</sup></span>
    </div>
<?php
    }
?>

<script>
    $(function(){


    })
</script>