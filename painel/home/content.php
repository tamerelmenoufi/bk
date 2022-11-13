<?php
include_once '../../lib/includes.php';

$queryClientes = "(SELECT COUNT(*) FROM clientes) AS clientes, ";
$queryVendas = "(SELECT COUNT(*) FROM vendas where operadora_situacao = 'approved') AS vendas, ";
$queryMesas = "(SELECT COUNT(*) FROM vendas where operadora_situacao != '') AS visitas, ";
$queryAtendentes = "(SELECT SUM(total) FROM vendas where operadora_situacao = 'approved') AS faturamento";

$queryCount = "SELECT {$queryMesas}{$queryClientes}{$queryVendas}{$queryAtendentes}";
$dadosCount = mysqli_fetch_object(mysqli_query($con, $queryCount));
?>

<style>
    .quadro{
        height:1px;
        color:#fff;
        font-size:10px;
        background-color:red;
        text-align:center;
    }
</style>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Clientes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dadosCount->clientes; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Vendas
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $dadosCount->vendas; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Visitas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dadosCount->visitas; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-utensils fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Faturamento
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?=number_format($dadosCount->faturamento, 2, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->


<!-- Content Row -->
<div class="row">
    <div class="col-md-12">


        <canvas id="myChart"></canvas>

    </div>
</div>


<script>
const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  };

  const config = {
  type: 'line',
  data: data,
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: 'Stacked scales',
      },
    },
    scales: {
      y: {
        type: 'linear',
        position: 'left',
        stack: 'demo',
        stackWeight: 2,
        grid: {
          borderColor: Utils.CHART_COLORS.red
        }
      },
      y2: {
        type: 'category',
        labels: ['ON', 'OFF'],
        offset: true,
        position: 'left',
        stack: 'demo',
        stackWeight: 1,
        grid: {
          borderColor: Utils.CHART_COLORS.blue
        }
      }
    }
  },
};
const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

</script>