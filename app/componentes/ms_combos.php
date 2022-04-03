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
        background-position:left;
        background-repeat:no-repeat;
        background-size:auto 100%;
        margin-bottom:30px;
        margin-top:20px;
    }
    .ms_combos p{
        padding-left:5px;
        padding-right:5px;
        background-color:#f2e5d4;
        border-radius:10px;
        position:absolute;
        top:-20px;
        left:10px;
        font-weight:bold;
        font-size:20px;
        color:#502314;
        text-transform: uppercase;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }

    .ms_combos span{
        padding:5px;
        background-color:#eee;
        border-radius:6px;
        position:absolute;
        opacity:0.6;
        bottom:10px;
        right:5px;
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