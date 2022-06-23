<?php
    include("../../../lib/includes.php");

    $query = "select * from produtos where codigo = '{$_POST['produto']}'";
    $result = mysqli_query($con, $query);
    $p = mysqli_fetch_object($result);


    $ItensDoProduto = json_decode($p->itens);

    $Codigos = [];
    $produtos = false;
    foreach($ItensDoProduto as $ind => $val){
        $Codigos[] = $val->produto;
        $Quantidade[$val->produto] = $val->quantidade;
    }
    if($Codigos) $produtos = implode(", ",$Codigos);


?>

<style>
    .ObsTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
</style>

<div class="ObsTopoTitulo">
    <h4>Personalizar Pedido</h4>
</div>

<div class="col">
    <div class="col" style="padding-bottom:50px;">

        <div class="mb-3">
            <h5>Incluir Observações</h5>
            <textarea class="form-control" id="observacoes"></textarea>
        </div>
        <?php
        if(!$_POST['combo']){
        ?>
        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-eraser"></i> <small> Remover Itens do produto</small></h5>
                <ul class="list-group">


                <?php
                        $query = "select * from itens where situacao = '1' and deletado != '1' and codigo in (" . implode(", ", $Codigos) . ")";
                        $result = mysqli_query($con, $query);
                        while($d = mysqli_fetch_object($result)){
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input
                                del
                                type="checkbox"
                                class="form-check-input"
                                id="del<?=$d->codigo?>"
                                codigo="<?=$d->codigo?>"
                                descricao="<?=$d->item?>"
                                valor="<?=$d->valor?>"
                            >
                            <label class="form-check-label" for="del<?=$d->codigo?>"> <small><?=$d->item?></small></label>
                        </div>
                        <!-- <span class="badge badge-primary badge-pill">R$ <?=number_format($d->valor,2,',',false)?></span> -->
                    </li>
                    <?php
                        }
                    ?>


                </ul>
            </div>
        </div>

        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-cart-plus"></i> <small> Adicionar Itens ao produto</small></h5>
                <ul class="list-group">
                    <?php
                        $query = "select * from itens where situacao = '1' and deletado != '1' order by item";
                        $result = mysqli_query($con, $query);
                        while($d = mysqli_fetch_object($result)){
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input
                                add
                                type="checkbox"
                                class="form-check-input"
                                id="add<?=$d->codigo?>"
                                codigo="<?=$d->codigo?>"
                                descricao="<?=$d->item?>"
                                valor="<?=$d->valor?>"
                            >
                            <label class="form-check-label" for="add<?=$d->codigo?>"><small><?=$d->item?></small></label>
                        </div>
                        <span class="badge badge-pill"> <small>R$ <?=number_format($d->valor,2,',',false)?></small></span>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div style="position:fixed; bottom:0px; left:0px; width:100%;">
    <button class="btn btn-success btn-lg btn-block" id="incluir_observacoes">Incluir Observações</button>
</div>

<script>
    $(function(){
        Carregando('none');

        $("#observacoes").val($(".observacoes").html());


        for(i=0; i < Del.length; i++){
            // console.log(Del[i].codigo)
            $(`#del${Del[i].codigo}`).prop("checked", true);
        }

        for(i=0; i < Add.length; i++){
            // console.log(Add[i].codigo)
            $(`#add${Add[i].codigo}`).prop("checked", true);
        }



        $("#incluir_observacoes").click(function(){

            $(".observacoes").html($("#observacoes").val());

            //-------
            valor_unitario = $("span[valor]").attr("atual");

            Add = [];
            $("input[add]").each(function(){
                if($(this).prop("checked") == true){
                    Add.push({codigo:$(this).attr('codigo'), descricao:$(this).attr('descricao'), quantidade:/*$(this).attr('quantidade')*/1, valor:$(this).attr('valor')});
                }
            });

            Del = [];
            $("input[del]").each(function(){
                if($(this).prop("checked") == true){
                    Del.push({codigo:$(this).attr('codigo'), descricao:$(this).attr('descricao')});
                }
            });


            //--------
            var obsAdd = '';
            var valor_unitario_aditivo = 0;
            if(Add.length > 0){
                obsAdd += "<b>Adicionar os Itens no produto:</b><br>";
            }
            for(i=0; i < Add.length; i++){
                // console.log(Add[i].codigo)
                valor_unitario_aditivo = ( (valor_unitario_aditivo*1) + (Add[i].valor * Add[i].quantidade));
                obsAdd += `- ${Add[i].quantidade} x ${Add[i].descricao}<br>`;
            }

            $("span[valor]").attr("aditivo", valor_unitario_aditivo*1);

            $("span[valor]").html((valor_unitario_aditivo*1 + valor_unitario*1).toLocaleString('pt-br', {minimumFractionDigits: 2}));

            //---------
            var obsDel = '';
            if(Del.length > 0){
                obsDel += "<b>Remover os Itens do produto:</b><br>";
            }
            for(i=0; i < Del.length; i++){
                // console.log(Del[i].codigo)
                obsDel += `- ${Del[i].descricao}<br>`;
            }

            //-------
            var produto_descricao2 = '';
            produto_descricao2 += obsAdd;
            produto_descricao2 += obsDel;
            $(".observacoes2").html(produto_descricao2);

            // console.log('Adicionados:');
            // console.log(Add);
            // console.log('Deletados:');
            // console.log(Del);
            // return false;

            PageClose();
        });

    })
</script>