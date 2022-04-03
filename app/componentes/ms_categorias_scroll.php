<?php
     include("../../lib/includes.php");

    $query="SELECT * FROM `categorias` where situacao ='1' and deletado != '1'";
     $result = mysqli_query($con, $query);
?>
<style>
.ms_categoria_scroll_palco {
    overflow-x: auto;
}
.ms_categoria_scroll {
   display: flex;
   flex-direction: row;
   justify-content: left;
   align-items: left;
   width: 100%;
   padding:0px;
   overflow:scroll;
}
.ms_categoria_scroll_card {
   min-width: 80px;
   text-align: center;
   border:0;
   background:transparent;
   margin:5px;
}
.ms_categoria_scroll_card div{
    position:relative;
    width:80px;
    height:80px;
    border-radius:50%;
    float:none;
    text-align:center;
}
.ms_categoria_scroll_card p{
    position:relative;
    width:80px;
    height:auto;
    color:#9C9C9C;
    font-style: normal;
    font-size: 12px;
    line-height: 14px;
    text-align:center;
    margin-top:5px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

}
.ms_categoria_scroll::-webkit-scrollbar {
    display: none;
}

</style>


<div class="ms_categoria_scroll_palco">
  <div class="ms_categoria_scroll">
     <?php
     $cor = [
                '#eae49fbd',
                '#2677386b',
                '#13687594',
                '#dc35358a'
            ];
    $i=0;
    while ($d = mysqli_fetch_object($result) ) {
    ?>
    <div
            opc="<?=$d->codigo?>"
            categoria="<?=$d->codigo?>"
            categoria_descricao="<?=$d->categoria?>"
            icone="<?='../painel/categorias/icon/'.$d->icon?>"
            class="ms_categoria_scroll_card"
    >
        <div style="background-color:<?=$cor[$i]?>">
            <img class="img-circle" src="<?='../painel/categorias/icon/'.$d->icon?>" style="margin-top:7px; width: 65px; height: 66px; border-radius:20px;" />
        </div>
        <p><?=$d->categoria?></p>
    </div>
  <?php
    $i++;
    if($i == 4) $i=0;
    }
  ?>
  </div>
</div>

<script>
    $(function(){
        Carregando('none');
        $(".ms_categoria_scroll_card").off('click').on('click',function(){
            opc = $(this).attr("opc");

        });
    })
</script>