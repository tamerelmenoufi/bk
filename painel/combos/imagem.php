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
<style>
    #IdTeste{
        width:500px;
        height:250px;
        background-color:#eee;
        text-align:center;
    }
</style>
<div class="col">
    <div  class="row">
        <div class="col">
            <div id="IdTeste">
            <?php
                foreach($img as $i => $icon){
            ?>
            <img class="redimencionar" src="./produtos/icon/<?=$icon?>" alt="<?=$nome[$i]?>" style="width:<?=(100/count($img)-1)?>%">
            <?php
                }
            ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <img id="ImgResult" src="" />
        </div>
    </div>

</div>

<script>



$( function() {

    html2canvas(document.getElementById('IdTeste')).then(function(canvas) {
        //document.body.appendChild(canvas);
        $("#ImgResult").attr("src", canvas.toDataURL('image/png'));
        console.log(canvas);
    });


    $( ".redimencionar" ).resizable({
      aspectRatio: 16 / 9
    });

    $( ".ui-wrapper" ).draggable({ containment: "#IdTeste", scroll: false });

});

</script>