<?php
   session_start();
    if ($_GET["captcha"] == $_SESSION["palavra"]){
        echo "success";
    }else{
        echo "error";
    }
?>