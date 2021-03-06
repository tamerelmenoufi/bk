<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion menus" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-burger"></i>
        </div>
        <div class="sidebar-brand-text mx-3" title="Sistema de Gestão Política">BURGUER KING</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dahboard -->
    <li class="nav-item active">
        <a class="nav-link" href="./">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider  -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">Produtos</div> -->
    <!-- Nav Item - Configuração -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MenuCardapio"
           aria-expanded="true" aria-controls="MenuCardapio">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Cardápio</span>
        </a>
        <div id="MenuCardapio" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Configurações:</h6> -->
                <?php
                $query = "SELECT * FROM categorias WHERE deletado != '1' and categoria != 'combos'  ORDER BY categoria";
                $result = mysqli_query($con, $query);
                while ($c = mysqli_fetch_object($result)) { ?>
                    <a class="collapse-item" href="#"
                       url="produtos/index.php?categoria=<?= $c->codigo ?>"><?= ucwords(mb_strtolower($c->categoria, 'UTF-8')); ?></a>
                <?php } ?>
                <a class="collapse-item" href="#" url="combos/index.php">Combos</a>
            </div>
        </div>
    </li>



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MenuItens"
           aria-expanded="true" aria-controls="MenuItens">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Itens</span>
        </a>
        <div id="MenuItens" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Configurações:</h6> -->
                <?php
                $query = "SELECT * FROM categorias_itens WHERE deletado != '1'  ORDER BY categoria";
                $result = mysqli_query($con, $query);
                while ($c = mysqli_fetch_object($result)) { ?>
                    <a class="collapse-item" href="#"
                       url="itens/index.php?categoria=<?= $c->codigo ?>"><?= ucwords(mb_strtolower($c->categoria, 'UTF-8')); ?></a>
                <?php } ?>
            </div>
        </div>
    </li>



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#VendasConfiguracoes"
           aria-expanded="true" aria-controls="VendasConfiguracoes">
            <i class="fa-solid fa-cash-register"></i>
            <span>Vendas</span>
        </a>
        <div id="VendasConfiguracoes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Configurações:</h6> -->
                <a class="collapse-item" href="#" url="vendas/abertas/index.php">Abertas</a>
                <a class="collapse-item" href="#" url="vendas/confirmadas/index.php">Confirmadas</a>
                <a class="collapse-item" href="#" url="vendas/processo_entrega/index.php">Em processo de entrega</a>
                <a  class="collapse-item" href="#" url="vendas/concluidas/index.php">Entregues / Concluidas</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MenuConfiguracoes"
           aria-expanded="true" aria-controls="MenuConfiguracoes">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações</span>
        </a>
        <div id="MenuConfiguracoes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Configurações:</h6> -->
                <a class="collapse-item" href="#" url="categorias/index.php">Categorias</a>
                <a class="collapse-item" href="#" url="categorias_medidas/index.php">Medidas</a>
                <!-- <a class="collapse-item" href="#" url="mesas/index.php">Mesas</a> -->
                <!-- <a class="collapse-item" href="#" url="pagamentos/index.php">Pagamentos</a> -->
                <a class="collapse-item" href="#" url="categorias_itens/index.php">Categoria Itens</a>
                <!-- <a class="collapse-item" href="#" url="itens/index.php">Itens</a> -->

            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MenuUsuarios"
           aria-expanded="true" aria-controls="MenuUsuarios">
            <i class="fa-solid fa-users"></i>
            <span>Usuários</span>
        </a>
        <div id="MenuUsuarios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Configurações:</h6> -->
                <!-- <a class="collapse-item" href="#" url="atendentes/index.php">Atendentes</a> -->
                <a class="collapse-item" href="#" url="usuarios/index.php">Usuários</a>
                <a class="collapse-item" href="#" url="clientes/index.php">Clientes</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" opc="0"></button>
    </div>
</ul>

<script>
    $(function () {
        $("#sidebarToggle").click(function () {
            opc = $(this).attr('opc');
            if (opc == '0') {
                $("#page-top").addClass('sidebar-toggled');
                $(".menus").addClass('toggled');
                $(this).attr("opc", "1");
            } else {
                $("#page-top").removeClass('sidebar-toggled');
                $(".menus").removeClass('toggled');
                $(this).attr("opc", "0");
            }

        });

        $(document).on('click', '[url]', function (e) {
            e.preventDefault();

            var url = $(this).attr('url');

            $('.loading').fadeIn(200);

            $.ajax({
                url,
                success: function (data) {
                    $('#palco').html(data);
                }
            })
                .done(function () {
                    $('.loading').fadeOut(200);
                })
                .fail(function (error) {
                    alert('Error');
                    $('.loading').fadeOut(200);
                })
        });

    })
</script>