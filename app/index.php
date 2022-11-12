<?php
    include("../lib/includes.php");

    //Verificação loja aberta
    date_default_timezone_set("America/Manaus");
    $inicio = strtotime(date("Y-m-d 11:00:00"));
    $final  = strtotime(date("Y-m-d 21:45:00"));
    $agora = strtotime("NOW");
    if($inicio <= $agora and $final >= $agora){

    }else{
        // exit();
    }
    //Verificação loja aberta

    exit();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ff0000"/>
    <title>APP</title>
    <?php include("../lib/header.php"); ?>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/app.css?xyz">


</head>
<body>
<div class="Carregando">
    <span>
        <i class="fa-solid fa-spinner"></i>
    </span>
</div>

<div class="ms_corpo"></div>

<?php include("../lib/footer.php"); ?>



<script src="<?= "js/app.js?" . date("YmdHis"); ?>"></script>
<script src="<?= "js/wow.js"; ?>"></script>

<script>
    $(function () {
        $.ajax({
            url: "src/home/index.php",
            success: function (dados) {
                $(".ms_corpo").html(dados);
            }
        });
    })


    //Configurações globais

    //Jconfirm
    jconfirm.defaults = {
        theme: "modern",
        type: "blue",
        typeAnimated: true,
        smoothContent: true,
        draggable: false,
        animation: 'bottom',
        closeAnimation: 'top',
        animateFromElement: false,
        animationBounce: 1.5
    }

</script>
<form></form>
</body>
</html>