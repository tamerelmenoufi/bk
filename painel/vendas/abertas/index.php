<?php
include("../../../lib/includes.php");
include "conf.php";
?>
<style>
    .container-produtos .jconfirm-content-pane {
        margin-top: 15px;

    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="./">Inicio</a></li>
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
                    <th class="mw-20">Ações</th>
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
                "columnDefs": [
                    {
                        "targets": 3,
                        "orderable": false,
                    },
                ],
            });
        }

        load_data();

        $("#datatable").on("click", "tbody tr td button[visualizar]", function () {
            var codigo = $(this).data("codigo");

            $.dialog({
                closeIcon: true,
                title: false,
                columnClass: "xlarge",
                bootstrapClasses: {
                    container: 'container container-produtos',
                    containerFluid: 'container-fluid',
                    row: 'row',
                },
                content: function () {
                    var self = this;

                    return $.ajax({
                        url: "<?= $UrlScript; ?>visualizar.php",
                        data: {codigo},
                    }).done(function (response) {
                        self.setContent(response);
                    });
                },
            });
        });
    })
</script>


