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
    <div id="IdTeste" class="row">
    <?php
        foreach($img as $i => $icon){
    ?>
    <div class="col">
        <img src="./produtos/icon/<?=$icon?>" alt="<?=$nome[$i]?>">
    </div>
    <?php
        }
    ?>
    </div>
    <div class="row">
        <img id="ImgResult" src="" style="height:300px;" />
    </div>





</div>

<script>

html2canvas(document.getElementById('IdTeste')).then(function(canvas) {
    document.body.appendChild(canvas);
    console.log(canvas);
});


</script>