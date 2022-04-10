<?php
include("../../lib/includes.php");


$query = "SELECT * FROM produtos WHERE codigo IN ({$_GET['produtos']})";
$result = mysqli_query($con, $query);
$img = [];
while ($d = mysqli_fetch_object($result)) {
    $img[] = $d->icon;
    $nome[] = $d->produto;
}

function imagem($source)
{
    $img = imagecreatefrompng($source);

    if ($img) {
        $cropped = imagecropauto($img, IMG_CROP_DEFAULT);

        if ($cropped !== false) {
            imagedestroy($img);
            $img = $cropped;
        }

        ob_start();

        imagepng($img);
        imagedestroy($img);

        $image_data = ob_get_contents();
        ob_clean();

        if (!empty($image_data)) {
            $image_data_base64 = base64_encode($image_data);

            if ($image_data_base64 != false) {
                return "data:image/png;base64,$image_data_base64";
            }
        }
    } else {
        return "#";
    }
}

?>

<style>
    #IdTeste {
        position: relative;
        width: 100%;
        height: 250px;
        background-color: #f2e5d4;
        text-align: center;
    }

    .redimencionar {
        width: <?=(100/count($img)-1)?>%;
        position: absolute;
        top: 0;
        right: 0;
    }

    /*.ui-wrapper .ui-icon {
        display: none;
    }*/
</style>

<div class="col">
    <div class="row" style="height:300px;">
        <div class="col">
            <div id="IdTeste">
                <?php foreach ($img as $i => $icon) { ?>
                    <img
                            class="redimencionar"
                            src="<?= imagem("../produtos/icon/{$icon}"); ?>"
                            alt="<?= $nome[$i] ?>"
                    >
                <?php } ?>
            </div>
        </div>
        <div class="col">
            <img id="ImgResult" src=""/>
        </div>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col">
            <button
                    GerarImagem
                    class="btn btn-lg btn-block btn-success"
            >
                GERAR IMAGEM
            </button>
        </div>
        <div class="col">
            <button
                    SalvarImagem
                    class="btn btn-lg btn-block btn-primary"
                    disabled
            >
                USAR IMAGEM
            </button>
        </div>
    </div>
</div>

<script>


    $(function () {

        $("button[GerarImagem]").click(function () {
            html2canvas(document.getElementById('IdTeste')).then(function (canvas) {
                //document.body.appendChild(canvas);
                $("#ImgResult").attr("src", canvas.toDataURL('image/png'));
                //console.log(canvas);
            });

            $("button[SalvarImagem]").removeAttr("disabled");
        });

        $("button[SalvarImagem]").click(function () {
            $("#ImagemCombo").attr("src", $("#ImgResult").attr("src"));
            $("#ImagemCombo").css("width", "507px");
            $("#ImagemCombo").css("height", "250px");
            $("#encode_file").val($("#ImgResult").attr("src"));

            dialogEditorImagem.close();
        })

        $(".redimencionar").resizable({
            //aspectRatio: 16 / 9
        });

        $(".ui-wrapper").draggable();

        $(".ui-wrapper").mouseover(function () {
            $(this).css({"border": "1px solid"});
            $(this).find(".ui-icon").show();
        });

        $(".ui-wrapper").mousedown(function () {
            let obj = $(this);
            //$(".ui-wrapper").css({"zIndex": 0});
            var zindex = [];

            $(".ui-wrapper").map((index, item) => {
                zindex.push($(item).css("zIndex") == "auto" ? 0 : parseInt($(item).css("zIndex")));
            });

            let zindex_val = Math.max(...zindex) + 1;

            obj.css({
                "zIndex": zindex_val,
            });
        });

        $(".ui-wrapper").mouseout(function () {
            $(this).css({"border": "none"});
            $(this).find(".ui-icon").hide();
        })
    });

</script>