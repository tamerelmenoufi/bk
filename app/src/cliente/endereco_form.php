<?php
    include("../../../lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        $rua = str_replace(array('&','/','\\','?'), false, $_POST['rua']);

        if ($_POST['codigo']) {
            mysqli_query($con, "UPDATE clientes_enderecos SET
                        nome = '{$_POST['nome']}',
                        rua = '{$rua}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        cep = '{$_POST['cep']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}',
                        entrega_gratis = '{$_POST['entrega_gratis']}'/*,
                        coordenadas = ''*/
                        WHERE codigo = '{$_POST['codigo']}'
                        ");
        } else {
            mysqli_query($con, "update clientes_enderecos set padrao = '0' where cliente = '{$_SESSION['AppCliente']}'");
            mysqli_query($con, "INSERT INTO clientes_enderecos SET
                        cliente = '{$_SESSION['AppCliente']}',
                        nome = '{$_POST['nome']}',
                        rua = '{$rua}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        cep = '{$_POST['cep']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}',
                        entrega_gratis = '{$_POST['entrega_gratis']}',
                        coordenadas = '{$_POST['coordenadas']}',
                        padrao = '1'
                        ");

        }

        echo json_encode([
            "status" => true,
        ]);

        exit();
    }

    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>

<style>

</style>


<div class="col">
    <div class="col-12 mb-3">Cadastro/Editar Endereço</div>
    <?php
    /*
    if(!$d->codigo){
    ?>
    <div class="col-12 mb-3">
      <label for="novo_endereco">Lista de Endereços <small>Entrega Grátis</small></label>
      <select id="novo_endereco" class="form-control form-control-lg">
        <option value="novo">Novo Endereço</option>
        <?php
            $q = "select * from clientes_enderecos where cliente = '0' and deletado != '1'";
            $r = mysqli_query($con, $q);
            while($s = mysqli_fetch_object($r)){
        ?>
        <option value="<?=$s->codigo?>"><?=$s->complemento?></option>
        <?php
            }
        ?>
      </select>
    </div>
    <?php
    }
    //*/
    ?>
    <div class="col-12 mb-3">
        <label for="rua">Nome <small>Aplelido para o endereço</small>*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="nome" value="<?=$d->nome?>">
    </div>
    <div class="col-12 mb-3">
        <label for="rua">Rua*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg blq" <?=(($d->entrega_gratis)?'disabled':false)?> id="rua" value="<?=$d->rua?>">
    </div>
    <div class="col-12 mb-3">
        <label for="numero">Número*</label>
        <input type="text" autocomplete="off" inputmode="numeric" maxlength='8' class="form-control form-control-lg blq" <?=(($d->entrega_gratis)?'disabled':false)?> id="numero" value="<?=$d->numero?>">
    </div>
    <div class="col-12 mb-3">
        <label for="bairro">Bairro*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg blq" <?=(($d->entrega_gratis)?'disabled':false)?> id="bairro" value="<?=$d->bairro?>">
    </div>
    <div class="col-12 mb-3">
        <label for="bairro">CEP*</label>
        <input type="text" autocomplete="off" inputmode="numeric" class="form-control form-control-lg blq" <?=(($d->entrega_gratis)?'disabled':false)?> id="cep" value="<?=$d->cep?>">
    </div>
    <div class="col-12 mb-3">
        <label for="complemento">Condomínio/Edifício/Complemento</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg blq" <?=(($d->entrega_gratis)?'disabled':false)?> id="complemento" value="<?=$d->complemento?>">
    </div>
    <div class="col-12 mb-3">
        <label for="referencia">Ponto de Referência / Andar / Sala</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="referencia" value="<?=$d->referencia?>">
    </div>

    <div class="col-12 mb-3">
        <input type="hidden" id="entrega_gratis" value='<?=(($d->entrega_gratis)?:'0')?>' />
        <input type="hidden" id="coordenadas" value='<?=(($d->coordenadas)?:'')?>' />
        <button CadastrarCliente cod="<?=$d->codigo?>" class="btn btn-secondary btn-block btn-lg">Salvar</button>
    </div>
</div>

<script>
    $(function(){

        $("#ClienteTeleofne").mask("(99) 99999-9999");
        $("#cep").mask("99999-999");

        $("#novo_endereco").change(function(){
            opc = $(this).val();
            if(opc == 'novo'){
                $(".blq").removeAttr("disabled");
                $(".blq").val("");
                $("#entrega_gratis").val("0");
                $("#coordenadas").val("");
            }else{
                $(".blq").attr("disabled","disabled");
                $.ajax({
                    url:"src/cliente/endereco_gratis.php",
                    type:"POST",
                    dataType:"json",
                    data:{
                        codigo:opc
                    },
                    success:function(dados){
                        // console.log(dados)
                        // console.log(dados.codigo)

                        $("#nome").val(dados.nome);
                        $("#rua").val(dados.rua);
                        $("#numero").val(dados.numero);
                        $("#bairro").val(dados.bairro);
                        $("#cep").val(dados.cep);
                        $("#complemento").val(dados.complemento);
                        $("#referencia").val(dados.referencia);
                        $("#entrega_gratis").val("1");
                        $("#coordenadas").val(dados.coordenadas);

                    }
                });
            }
        })

        $("button[CadastrarCliente]").click(function(){
            nome = $("#nome").val();
            rua = $("#rua").val();
            numero = $("#numero").val();
            bairro = $("#bairro").val();
            cep = $("#cep").val();
            complemento = $("#complemento").val();
            referencia = $("#referencia").val();
            entrega_gratis = $("#entrega_gratis").val();
            coordenadas = $("#coordenadas").val();
            codigo = $(this).attr("cod");

            if(
                nome &&
                rua &&
                numero &&
                bairro &&
                cep
            ){
                $.ajax({
                    url:"src/cliente/endereco_form.php",
                    type:"POST",
                    data:{
                        nome,
                        rua,
                        numero,
                        bairro,
                        cep,
                        complemento,
                        referencia,
                        entrega_gratis,
                        coordenadas,
                        codigo,
                        acao:'salvar'
                    },
                    success:function(dados){

                        let retorno = JSON.parse(dados);
                        if(retorno.status){

                            retorno = $("body").attr("retorno");
                            local = ((retorno)?retorno:"src/cliente/enderecos.php");
                            $("body").attr("retorno",'');
                            $.ajax({
                                url:"componentes/ms_popup_100.php",
                                type:"POST",
                                data:{
                                    local,
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