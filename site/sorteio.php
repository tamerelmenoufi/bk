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
    <h1><span style="font-size:50px;">SORTEIO</span><br><img src="https://logospng.org/download/burger-king/logo-burger-king-2021-2048.png" width="120" /></h1>
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
