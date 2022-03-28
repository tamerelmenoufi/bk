<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        if ($_POST['codigo']) {
            mysqli_query($con, "UPDATE clientes_enderecos SET
                        rua = '{$_POST['rua']}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}'
                        WHERE codigo = '{$_POST['codigo']}'
                        ");
        } else {

            mysqli_query($con, "INSERT INTO clientes_enderecos SET
                        cliente = '{$_SESSION['AppCliente']}',
                        rua = '{$_POST['rua']}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}'
                        WHERE codigo = '{$_POST['codigo']}'
                        ");

        }

        echo json_encode([
            "status" => true,
        ]);

        exit();
    }

    $query = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>

<div class="col">
    <div class="col-12">Cadastro/Editar Endereço</div>

    <div class="col-12 mb-3">
        <label for="rua">Rua*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="rua" value="<?=$d->rua?>">
    </div>
    <div class="col-12 mb-3">
        <label for="numero">Número*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="numero" value="<?=$d->numero?>">
    </div>
    <div class="col-12 mb-3">
        <label for="bairro">Bairro*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="bairro" value="<?=$d->bairro?>">
    </div>
    <div class="col-12 mb-3">
        <label for="complemento">Condomínio/Edifício/Complemento</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="complemento" value="<?=$d->complemento?>">
    </div>
    <div class="col-12 mb-3">
        <label for="referencia">Ponto de Referência</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="referencia" value="<?=$d->referencia?>">
    </div>

    <div class="col-12 mb-3">
        <button CadastrarCliente cod="<?=$d->codigo?>" class="btn btn-secondary btn-block btn-lg">Salvar</button>
    </div>
</div>

<script>
    $(function(){

        $("#ClienteTeleofne").mask("(99) 99999-9999");

        $("button[CadastrarCliente]").click(function(){
            rua = $("#rua").val();
            numero = $("#numero").val();
            bairro = $("#bairro").val();
            complemento = $("#complemento").val();
            referencia = $("#referencia").val();
            codigo = $(this).attr("cod");

            if(
                rua &&
                numero &&
                bairro
            ){
                $.ajax({
                    url:"src/cliente/endereco_form.php",
                    type:"POST",
                    data:{
                        rua,
                        numero,
                        bairro,
                        complemento,
                        referencia,
                        codigo,
                        acao:'salvar'
                    },
                    success:function(dados){

                        let retorno = JSON.parse(dados);
                        if(retorno.status){

                            $.ajax({
                                url:"componentes/ms_popup_100.php",
                                type:"POST",
                                data:{
                                    local:'src/cliente/enderecos.php',
                                },
                                success:function(dados){
                                    PageClose(2);
                                    $(".ms_corpo").append(dados);
                                }
                            });

                        }else{
                            $.alert('Ocorreu um erro!');
                        }

                    }
                });
            }else{
                $.alert('Favor Preencher os campos obrigatórios*!');
            }

        });
    })
</script>