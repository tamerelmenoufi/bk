<?php

if (session_id() === "") {
    session_start();
}

function getUrl()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO']; //($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }


    if ($_SERVER['HTTP_HOST'] === 'localhost'){
        return $protocol . "://localhost/bk/";
    }else if( $_SERVER['HTTP_HOST'] === '192.168.0.18'){
        return $protocol . "://192.168.0.18/bk/";
    }else{
        return $protocol . "://sis.bkmanaus.com.br/";
    }
    // return 'http://lib.yobom.com.br/';
}

$caminho_vendor = getUrl() . "lib/vendor";

date_default_timezone_set('America/Manaus');

