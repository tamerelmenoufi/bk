<?php
error_reporting(0);
include "confBk.php";
include "connection.php";
include "config.php";
include "utils.php";
include "fn.php";
include "vendor/rede/classes.php";
include "vendor/mercado_pago/classes.php";
include "vendor/bee/classes.php";
include "AppWapp.php";
$md5 = md5(date("YmdHis"));
if($_SESSION['usuario']){
    $Usu = $_SESSION['usuario'];
}

//Verificação loja aberta
date_default_timezone_set("America/Manaus");
$inicio = strtotime(date("Y-m-d 11:00:00"));
$final  = strtotime(date("Y-m-d 21:45:00"));
$agora = strtotime("NOW");
if($inicio <= $agora and $final >= $agora){
    $StatusApp = 'a';
}else{
    $StatusApp = 'f';
}

//Promoção sem taxa de entrega
$promocao_taxa_zero = false;