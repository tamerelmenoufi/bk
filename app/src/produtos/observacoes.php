<?php
    include("../../../lib/includes.php");

    $query = "select * from produtos where codigo = '{$_POST['produto']}'";
    $result = mysqli_query($con, $query);
    $p = mysqli_fetch_object($result);

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

        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-eraser"></i> <small> Remover Itens do produto</small></h5>
                <ul class="list-group">

                    <?php
                    echo $query;
                        print_r(json_decode($p->itens));
                    ?>

                    <li class="list-group-item">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </li>

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
                            <input type="checkbox" class="form-check-input" id="add<?=$d->codigo?>">
                            <label class="form-check-label" for="add<?=$d->codigo?>"><?=$d->item?></label>
                        </div>
                        <span class="badge badge-primary badge-pill">R$ <?=number_format($d->valor,2,',',false)?></span>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<div style="position:fixed; bottom:0px; left:0px; width:100%;">
    <button class="btn btn-success btn-lg btn-block" id="incluir_observacoes">Incluir Observações</button>
</div>

<script>
    $(function(){
        Carregando('none');

        $("#observacoes").val($(".observacoes").html());

        $("#incluir_observacoes").click(function(){
            $(".observacoes").html($("#observacoes").val());
            PageClose();
        });

    })
</script>