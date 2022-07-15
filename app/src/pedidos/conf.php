<?php
    include("../../lib/includes.php");
    if($_SESSION['PedidosUsuario']) $Uconf = $_SESSION['PedidosUsuario'];
    else $Uconf = [];