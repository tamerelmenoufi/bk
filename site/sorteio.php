<?php include("../lib/includes.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Burguer King® - Manaus</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logogb.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <!-- <link href="assets/css/variables.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

  <link href="https://moh1.com.br/css/variables.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: HeroBiz - v2.1.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script src="assets/vendor/jquery-3.6.0/jquery-3.6.0.min.js"></script>
</head>

<body style="background:var(--color-white)">

<?php

    list($qt) = mysqli_fetch_row(mysqli_query($con, "select count(*) from clientes where data_promocao >= '2023-01-06 00:00:00'"));

?>

<center>
    <br>
    <!-- <h1><span style="font-size:100px;"><?=$qt?></span> CADASTROS</h1> -->
    <center>
    <h1><span style="font-size:100px;">SORTEIO</span><br><img src="data:image/png;base64,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" width="120" /></h1>
    </center>
    <?php

    $query = "select * from clientes where sorteio = '1' and data_promocao >= '2023-01-06 00:00:00' order by sorteio_data asc";
    $result = mysqli_query($con, $query);
    $n = mysqli_num_rows($result);
    if($n){
        echo "<div class='m-3 p-3'>";
        echo "<h1>SORTEADOS</h1>";
        echo '<ul class="list-group">';
    while($d = mysqli_fetch_object($result)){
?>
    <li class="list-group-item">
        <h4><?=str_pad($d->codigo , 4 , '0' , STR_PAD_LEFT);?></h4>
        <b><?=$d->nome?></b><br>
        <?=$d->telefone?><br>
        <!-- <?=substr($d->telefone,0,8).'****'.substr($d->telefone,-4)?><br> -->
    </li>
<?php
    }
        echo '</ul>';
        echo '</div>';
    }

list($qt) = mysqli_fetch_row(mysqli_query($con, "select count(*) from clientes where data_promocao >= '2023-01-06 00:00:00'"));


if($_GET['s']){

    $q = "select * from clientes where data_promocao >= '2023-01-06 00:00:00' and sorteio != '1' order by rand() limit 1";
    $sorteio = mysqli_fetch_object(mysqli_query($con, $q));

    $q = "update clientes set sorteio = '1', sorteio_data = NOW() where codigo = '{$sorteio->codigo}'";
    mysqli_query($con, $q);

    $msg = "*BKManaus Informa*: Parabéns {$sorteio->nome}, VC FOI SORTEADO(A) *#EUTONABKMANAUS*. Seu código para resgatar o prêmio é *".str_pad($sorteio->codigo , 4 , '0' , STR_PAD_LEFT)."*.";
    $result = EnviarWapp($sorteio->telefone,$msg);
    $result = EnviarWapp('92991886570',$msg);

    echo "<script>window.location.href='./sorteio.php'</script>";
    exit();

}
    if($n < 3){
?>
    <br><br>
    <a href="?s=1" class="btn btn-success btn-lg" style="width:50%; text-align:center">SORTEAR</a>
<?php
    }
?>
</center>




  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    $(function(){

    })
  </script>

</body>

</html>
