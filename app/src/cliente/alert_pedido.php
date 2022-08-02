<?php
    include("../../../lib/includes.php");
?>
<style>
    .Alerta{
        position:absolute;
        width:auto;
        height:30px;
        margin:15px;
        border:solid 1px blue;
        border-radius:7px;
    }
</style>
<?php
    $s = date("s");
    if($s >= 10 and $s <= 15){
        echo "<div class='Alerta'>{$s}</div>";
    }

?>