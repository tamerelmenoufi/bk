<?php
    include("../../../lib/includes.php");
?>
<div class="col">
    <div class="col" style="padding-bottom:50px;">

        <div class="mb-3">
            <h4>Incluir Observações</h4>
            <textarea class="form-control" id="observacoes"></textarea>
        </div>

        <div class="mb-3">
            <div class="card">
                <h5 class="card-header">Remover Itens do produto</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="card">
                <h5 class="card-header">Adicionar Itens ao produto</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
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