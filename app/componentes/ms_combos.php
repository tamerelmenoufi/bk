<?php
    include("../../lib/includes.php");

    $query = "select * from produtos where deletado != '1' and situacao = '1' and categoria = '8'";
    $result = mysqli_query($con, $query);
?>
<style>

    .ms_combos{
        position:relative;
        width:100%;
        border-radius:10px;
        background-color:#f2e5d4;
        height:auto;
        background-position:left;
        background-repeat:no-repeat;
        background-size:auto 100%;
        margin-bottom:30px;
        margin-top:20px;
        text-align:center;
        padding-bottom:40px;
    }
    .ms_combos p{
        padding-left:5px;
        padding-right:5px;
        background-color:#f2e5d4;
        border-radius:10px;
        position:relative;
        /* top:-20px;
        right:10px; */
        font-weight:bold;
        font-size:20px;
        color:#502314;
        /* text-transform: uppercase;
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF; */
    }

    .ms_combos span{
        padding:5px;
        background-color:#fff;
        border-radius:6px;
        position:absolute;
        opacity:0.6;
        bottom:10px;
        right:10px;
        font-weight:bold;
        font-size:20px;
        color:#d62300;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }

    .ms_combos span sup{
        font-weight:normal;
        font-size:10px;
    }
    .ms_combos span sub{
        font-weight:bold;
        font-size:10px;
    }


</style>

<?php

while ($p = mysqli_fetch_object($result) ) {

    $icone = "{$caminho_sis}/painel/combos/icon/{$p->icon}?{$md5}";

    $q = "select * from produtos where codigo in ({$p->descricao})";
    $r = mysqli_query($con, $q);
    $valor_total = 0;
    while($v = mysqli_fetch_object($r)){

        $valor_total =  $valor_total + $v->valor_combo;

        // if($m->medida == 'COMBO'){
        //     $M[$m['codigo']] = [
        //         "ordem" => $m['ordem'],
        //         "descricao" => $m['medida']
        //     ];
        // }
    }



    // foreach ($detalhes as $key => $val) :
    //     $val['ordem'] = $M[$key]['ordem'];
    //     $detalhes_2[$key] = $val;
    // endforeach;

    // aasort($detalhes_2, "ordem");

    // foreach ($detalhes_2 as $key2 => $val) {
    //     if ($val["quantidade"] > 0) {

            list($valor,$decimal) = explode(".", $valor_total);

?>
    <div
        abrir_combo
        local="src/produtos/produto_combo.php"
        produto="<?=$p->codigo?>"
        janela="ms_popup_100"
        class="ms_combos"
        style="background-imageXX:url(<?=$icone?>)"
    >
        <img src="<?=$icone?>" alt="<?=$p->produto?>" style="width:70%" />
        <p><?=$p->produto?></p>
        <span> <sub>R$</sub> <?= $valor ?><sup>,<?= str_pad($decimal , 2 , '0' , STR_PAD_RIGHT) ?></sup></span>


    </div>
<?php
        // }
    // }
}
?>

<script>
    $(function(){

        $("div[abrir_combo]").click(function(){
            local = $(this).attr("local");
            janela = $(this).attr("janela");
            produto = $(this).attr("produto");

            Carregando();
            $.ajax({
                url:`componentes/${janela}.php`,
                type:"POST",
                data:{
                    local,
                    produto,
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                }
            });

        });

    })
</script>