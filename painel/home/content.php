<?php
include_once '../../lib/includes.php';

$queryClientes = "(SELECT COUNT(*) FROM clientes) AS clientes, ";
$queryVendas = "(SELECT COUNT(*) FROM vendas where operadora_situacao = 'approved') AS vendas, ";
$queryMesas = "(SELECT COUNT(*) FROM vendas where operadora_situacao != 'approved') AS visitas, ";
$queryAtendentes = "(SELECT SUM(total) FROM vendas where operadora_situacao = 'approved') AS faturamento";

$queryCount = "SELECT {$queryMesas}{$queryClientes}{$queryVendas}{$queryAtendentes}";
$dadosCount = mysqli_fetch_object(mysqli_query($con, $queryCount));

//Conectividade das lojas
$data = date("Y-m-d");
$query = "select count(*) as qt, situacao from logs_conexoes where data like '%".$data."%' group by situacao";
$result = mysqli_query($con, $query);
while($d = mysqli_fetch_object($result)){
    $connectLoja[$d->situacao] = $d->qt;
}

$conectividade = ($connectLoja[0] + $connectLoja[1]);

$off = number_format(($connectLoja[0] * 100)/$conectividade,0);
$on = number_format(($connectLoja[1] * 100)/$conectividade,0);

?>

<style>
    .pixe{
        height:3px;
        width:3px;
        border-radius:100%;
        float:left;
        background-color:red;
        border:0;
        text-align:center;
    }
    .relatorio td{
        font-size:7px;
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
    <div class="col-md-4">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-md-8">
        Tabela
        <table class="relatorio" style="width:100%; border:solid 1px #333">

        <tr>
            <td rowspan="2">
                Horas
            </td>
            <td colspan="60" style="text-align:center">
                Minutos
            </td>
        </tr>

        <tr>
            <?php
            for($i=0;$i<60;$i++){
            ?>
            <td style="text-align:center">
                <?=str_pad($i , 2 , '0' , STR_PAD_LEFT)?>
            </td>
            <?php
            }
            ?>
        </tr>

        <?php
            for($i=0;$i<24;$i++){
        ?>
            <tr>
                <td><?=str_pad($i , 2 , '0' , STR_PAD_LEFT)?> H</td>

                <?php
                    for($j=0;$j<60;$j++){
                ?>
                    <td><div class="pixe"></div></td>
                <?php
                    }
                ?>

            </tr>
        <?php
            }
        ?>
        </table>
    </div>
</div>


<script>




const DATA_COUNT = 5;
const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};

const data = {
  labels: ['On', 'Off'],
  datasets: [
    {
      label: ['<?=$on?>%','<?=$off?>%'],
      data: [<?=$on?>,<?=$off?>],
      backgroundColor: ['green','red'], //Object.values(Utils.CHART_COLORS),
    }
  ]
};

const config = {
  type: 'pie',
  data: data,
  cutout:'number',
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Percentual de Conectividade das lojas em <?=formata_datahora($data,'d/m/Y')?>'
      }
    }
  },
};

const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

</script>