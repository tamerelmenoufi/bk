<?php
    include("../../lib/includes.php");

    if($_POST['acao'] == 'situacao'){
        echo $query = "update produtos set lojas = JSON_SET(lojas,'$.\"{$_POST['loja']}\".situacao',{$_POST['situacao']}) where codigo = '{$_POST['cod']}'";
        mysqli_query($con,$query);
        exit();
    }


?>
<style>
    span[acaoSituacao]{
        cursor:pointer;
    }
</style>
<?php
    echo "<h2><small>Estabelecimento</small> - {$_GET['loja']}</h2>";
    // echo "{$_GET['cod']}<br><br>";

    $query = "select
                    a.*,
                    b.categoria,
                    JSON_EXTRACT(a.lojas,'$.\"{$_GET['cod']}\".situacao') as situacao_loja
            from produtos a
                left join categorias b on a.categoria = b.codigo
            where
                    a.deletado != '1' and
                    b.deletado != '1' and
                    a.situacao = '1' and
                    b.situacao = '1'
            order by
                    b.ordem asc,
                    a.produto asc
    ";
    $result = mysqli_query($con, $query);
    $categoria = false;
    while($d = mysqli_fetch_object($result)){
        if($categoria != $d->categoria){
            $categoria = $d->categoria;
            echo "<hr><h3 style='margin-top:20px;'>{$categoria}</h3>";
        }
        ?>
        <div class="row">
            <div class="col-md-10"><?=$d->produto?></div>
            <div class="col-md-2">
                <span acaoSituacao="<?=(($d->situacao_loja == '1')?'on':'off')?>" cod="<?=$d->codigo?>" style="color:<?=(($d->situacao_loja == '1')?'green':'#858796')?>">
                    <i class="fa fa-toggle-<?=(($d->situacao_loja == '1')?'on':'off')?> fa-2x" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    <?php
        // echo "{$d->produto}<br>";
    }
    ?>
    <script>
        $(function(){
            $("span[acaoSituacao]").click(function(){
                acao = $(this).attr("acaoSituacao");
                cod = $(this).attr("cod");
                if(acao == 'off'){
                    $(this).children("svg").removeClass("fa-toggle-off");
                    $(this).children("svg").addClass("fa-toggle-on");
                    $(this).css("color","green");
                    $(this).attr("acaoSituacao","on");
                    situacao = '1';
                }else{
                    $(this).children("svg").removeClass("fa-toggle-on");
                    $(this).children("svg").addClass("fa-toggle-off");
                    $(this).css("color","#858796");
                    $(this).attr("acaoSituacao","off");
                    situacao = '0';
                }
                $.ajax({
                    url:"lojas/cardapio.php",
                    type:"POST",
                    data:{
                        acao:"situacao",
                        loja:"<?=$_GET['cod']?>",
                        cod,
                        situacao
                    },
                    success:function(dados){
                        $.alert(dados)
                    }
                });
            });
        })
    </script>