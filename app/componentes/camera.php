<?php
    include("../../lib/includes.php");


    $mesas = [];
    $query = "SELECT * FROM mesas WHERE situacao = '1' AND deletado != '1'";
    $result = mysqli_query($con, $query);
    while($m = mysqli_fetch_object($result)){
        $mesas[] = $m->mesa;
    }
?>
<style>
    #videoCaptura{
        position:fixed;
        top:0px;
        left:0px;
        width:100%;
        height: 100%;
        border:solid 2px red;
        margin:0;
        padding:0;
        flex:1;
    }
    #DadosCaptura{
        position:fixed;
        bottom:10px;
        left:0px;
        width:100%;
        padding:10px;
        color:#fff;
        font-weight:bold;
        text-align:center;
        border:solid 1px green;
    }
    #QuadroCaptura{
        position:fixed;
        top:50%;
        left:50%;
        margin-left:-150px;
        margin-top:-150px;
        width:300px;
        height:300px;
    }
    #QuadroCaptura .opc1{
        position:absolute;
        left:0;
        top:0;
        width:25%;
        height:25%;
        border-top:solid 2px green;
        border-left:solid 2px green;
        opacity:0.5;
    }
    #QuadroCaptura .opc2{
        position:absolute;
        right:0;
        top:0;
        width:25%;
        height:25%;
        border-top:solid 2px green;
        border-right:solid 2px green;
        opacity:0.5;
    }
    #QuadroCaptura .opc3{
        position:absolute;
        left:0;
        bottom:0;
        width:25%;
        height:25%;
        border-bottom:solid 2px green;
        border-left:solid 2px green;
        opacity:0.5;
    }
    #QuadroCaptura .opc4{
        position:absolute;
        right:0;
        bottom:0;
        width:25%;
        height:25%;
        border-right:solid 2px green;
        border-bottom:solid 2px green;
        opacity:0.5;
    }
</style>
    <iframe name="videoCaptura" id="videoCaptura" src="../lib/vendor/camera/camera.html?<?=$md5?>"></iframe>
    <div id="DadosCaptura"></div>
    <div id="QuadroCaptura">
        <div class="opc1"></div>
        <div class="opc2"></div>
        <div class="opc3"></div>
        <div class="opc4"></div>
    </div>

    <script>
        function LeituraCamera(content){

            m = ['<?=@implode("','",$mesas)?>'];


            if(mesa && $.inArray( content, m ) != -1){
                window.localStorage.setItem('AppMesa', content);

                $.ajax({
                    url:"home/index.php?mesa="+mesa,
                    success:function(dados){
                        $("#body").html(dados);
                    }
                });
            }else{
                $.alert('CÓDIGO <b>'+content+'</b> BLOQUEADO, EM USO OU NÃO REGISTRADO NO SISTEMA!');
            }


            //document.getElementById('DadosCaptura').innerHTML = 'Adicionado pela função: ' + content;
            //AppMesa = window.localStorage.getItem('AppMesa');
            //window.localStorage.setItem('AppMesa', content);
            //var valor = window.parent.videoCaptura.document.getElementById('campoTeste').value;
        }
    </script>