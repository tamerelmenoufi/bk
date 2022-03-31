<?php

    include("../../lib/includes.php");

?>

<ul class="list-group">
<?php
    $q = "select * from produtos where categoria = '{$_GET['categoria']}'";
    $r = mysqli_query($con, $q);
    while($p = mysqli_fetch_object($r)){
?>
    <li produto="<?=$p->codigo?>" class="list-group-item list-group-item-action"><?=$c->produto?></li>
<?php
    }
?>
</ul>

<script>
    $(function () {

    });
</script>