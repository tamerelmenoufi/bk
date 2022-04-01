<?php
    include("../../lib/includes.php");

    $query = "select * from produtos where codigo in ({$_GET['produtos']})";
    $result = mysqli_query($con, $query);
    $img = [];
    while($d = mysqli_fetch_object($result)){
        $img[] = $d->icon;
        $nome[] = $d->produto;
    }

?>

<div class="col">
    <?php
        foreach($img as $i => $icon){
    ?>
        <img src="./produtos/icon/<?=$icon?>" alt="<?=$nome[$i]?>">
    <?php
        }
    ?>
</div>

