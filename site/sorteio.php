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

    list($qt) = mysqli_fetch_row(mysqli_query($con, "select count(*) from clientes where data_promocao like '%2022-12-23%'"));


    if($_GET['s']){

        $sorteio = mysqli_fetch_object(mysqli_query($con, "select * from clientes where data_promocao like '%2022-12-23%' and sorteio != '1' order by rand() limit 1"));

        mysqli_query($con, "update clientes set sorteio = '1', sorteio_data = NOW() where codigo = '{$sorteio->codigo}'");

    }

?>

<center>
    <br><br><br><br>
    <h1><?=$qt?> CADASTROS</h1>

    <?php

    $query = "select * from clientes where sorteio = '1' and data like '%2022-12-23%' order by sorteio_data asc";
    $result = mysqli_query($con, $query);
    $n = mysqli_num_rows($result);
    if($n){
        echo "<h1>SORTEADOS</h1>";
        echo '<ul class="list-group">';
    while($d = mysqli_fetch_object($result)){
?>
    <li class="list-group-item">
        <h4><?=str_pad($d->codigo , 4 , '0' , STR_PAD_LEFT);?></h4>
        <b><?=$d->nome?></b><br>
        <?=substr($d->telefone,0,8).'****'.substr($d->telefone,-4)?><br><?=$d->telefone?>

    </li>
<?php
    }
        echo '</ul>';
    }

list($qt) = mysqli_fetch_row(mysqli_query($con, "select count(*) from clientes where data_promocao like '%2022-12-23%'"));


if($_GET['s']){

    $sorteio = mysqli_fetch_object(mysqli_query($con, "select * from clientes where data_promocao like '%2022-12-23%' and sorteio != '1' order by rand() limit 1"));

    mysqli_query($con, "update clientes set sorteio = '1', sorteio_data = NOW() where codigo = '{$sorteio->codigo}'");

}
    if($n == 3){
?>
    <br><br><br><br>
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
      $(".produtos_detalhes").click(function(){
        codigo = $(this).attr("codigo");
        descricao = $(this).attr("descricao");
        $.ajax({
          url:"src/produtos/lista.php",
          type:"POST",
          data:{
            codigo,
            descricao,
          },
          success:function(dados){
            $(".popup").html(dados); //lin
            $(".popup").css("display","block");
            $("body").css("overflow","hidden");
          }
        });
      })

    })
  </script>

</body>

</html>
