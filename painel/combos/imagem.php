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
    <div class="row">
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






    <div id="mydiv" style="background-image:url(Koala.jpg) ;background-size: 100%;
background-size :200px 200px;
background-repeat: no-repeat;">
<p>text!</p>
<img src="mug.png" height="100" width="100"/></div>
<div id="canvas">
<p>Canvas:</p>
</div>

 <div style="width:200px; float:left" id="image">
 <p style="float:left">Image: </p>
 </div>
 <div style="float:left;margin-top: 120px;" class="return-data">
 </div>



</div>

<script>

html2canvas([document.getElementById('mydiv')], {
    onrendered: function (canvas) {

        document.getElementById('canvas').appendChild(canvas);
        var data = canvas.toDataURL('image/png');
        //display 64bit imag
        var image = new Image();
        image.src = data;
        document.getElementById('image').appendChild(image);
        // AJAX call to send `data` to a PHP file that creates an PNG image from the dataURI string and saves it to a directory on the server
        console.log('image');
        console.log(image);
        var file= dataURLtoBlob(data);
        console.log('file');
        console.log(file);
        // Create new form data
        var fd = new FormData();
        fd.append("imageNameHere", file);

   }
});

</script>