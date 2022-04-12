<?php
include("../../../lib/includes.php");
include "conf.php";

if (isset($_POST["action"]) && ($_POST["action"] === "index")) {
    $sql = "SELECT * FROM vendas v "
        . "INNER JOIN clientes c ON c.codigo = v.cliente "
        . "WHERE v.deletado != '1'";

    $result = mysqli_query($con, $sql);
    $totalData = mysqli_num_rows($result);

    if (!empty($requestData['search']['value'])) {
        $sql .= " AND ( c.total LIKE '" . $requestData['search']['value'] . "%' ";
        $sql .= " OR c.nome LIKE '" . $requestData['search']['value'] . "%' ";
        $sql .= " OR v.forma_pagamento LIKE '" . $requestData['search']['value'] . "%' ";
    }

    $requestData = $_REQUEST;

    $result = mysqli_query($con, $sql);

    $data = [];

    if (mysqli_num_rows($result)) {
        $totalFiltered = mysqli_num_rows($result);

        while ($d = mysqli_fetch_object($result)) {
            $data[] = [
                $d->nome,
                date("d/m/Y H:i:s", strtotime($d->data_pedido)),
                $d->forma_pagamento,
                number_format($d->valor, 2, ',', '.')
            ];
        }

        $json_data = [
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "success" => true,
            "aaData" => $data,
        ];

        echo json_encode($json_data);
    } else {
        echo "No data found";
    }

    exit();
}


?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="../">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $ConfTitulo ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $ConfTitulo ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table id="datatable" class="table" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Data do pedido</th>
                    <th>Forma de pagamento</th>
                    <th>Total</th>
                    <!--<th class="mw-20">Ações</th>-->
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        function load_data(start, length) {
            var dataTable = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "retrieve": true,
                "ajax": {
                    url: "<?= $UrlScript; ?>fetch.php",
                    method: "POST",
                    data: {start: start, length: length}
                },
                "drawCallback": function (settings) {
                    var page_info = dataTable.page.info();

                    $('#totalpages').text(page_info.pages);

                    var html = '';

                    var start = 0;

                    var length = page_info.length;

                    for (var count = 1; count <= page_info.pages; count++) {
                        var page_number = count - 1;

                        html += '<option value="' + page_number + '" data-start="' + start + '" data-length="' + length + '">' + count + '</option>';

                        start = start + page_info.length;
                    }

                    $('#pagelist').html(html);

                    $('#pagelist').val(page_info.page);
                }
            });
        }

        load_data();
    })
</script>


