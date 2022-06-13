<?php

    include("../../../lib/includes.php");

    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $retorno_situacao = [];

    if($d->CANCELED > 0){
        $retorno_situacao['CANCELED'] =  "<p>Cancelado</p>";
    }else{

        if($d->SEARCHING > 0){
            $retorno_situacao['SEARCHING'] = "<p>Buscando</p>";
        }
        if($d->GOING_TO_ORIGIN > 0){
            $retorno_situacao['GOING_TO_ORIGIN'] = "<p>A Caminho do estabelecimento</p>";
        }
        if($d->ARRIVED_AT_ORIGIN > 0){
            $retorno_situacao['ARRIVED_AT_ORIGIN'] = "<p>Entregador no estabelecimento</p>";
        }
        if($d->GOING_TO_DESTINATION > 0){
            $retorno_situacao['GOING_TO_DESTINATION'] = "<p>A entrga está a caminho</p>";
        }
        if($d->ARRIVED_AT_DESTINATION > 0){
            $retorno_situacao['ARRIVED_AT_DESTINATION'] = "<p>Entrega realizada</p>";
        }
        if($d->RETURNING > 0){
            $retorno_situacao['RETURNING'] = "<p>Entregador retornando</p>";
        }
        if($d->COMPLETED > 0){
            $retorno_situacao['COMPLETED'] = "<p>Entrega Concluída</p>";
        }

    }
?>

<style>


.minha_linha {
  box-sizing: border-box;
  background-color: red;
  font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.timeline {
  box-sizing: border-box;
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  box-sizing: border-box;
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
}

/* Container around content */
.container {
  box-sizing: border-box;
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.container::after {
  box-sizing: border-box;
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -5px;
  background-color: white;
  border: 4px solid #FF9F55;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  box-sizing: border-box;
  left: 0;
}

/* Place the container to the right */
.right {
  box-sizing: border-box;
  left: 50%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  box-sizing: border-box;
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  box-sizing: border-box;
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
  box-sizing: border-box;
  left: -5px;
}

/* The actual content */
.content {
  box-sizing: border-box;
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  box-sizing: border-box;
  left: 31px;
  }

  /* Full-width containers */
  .container {
  box-sizing: border-box;
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }

  /* Make sure that all arrows are pointing leftwards */
  .container::before {
  box-sizing: border-box;
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  box-sizing: border-box;
  left: 15px;
  }

  /* Make all right containers behave like the left ones */
  .right {
  box-sizing: border-box;
  left: 0%;
  }
}
</style>

<div class="minha_linha">
<div class="timeline">
  <div class="container right">
    <div class="content">
      <h2>2017</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>2016</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>2015</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>2012</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>2011</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>2007</h2>
      <p>Lorem ipsum dolor</p>
    </div>
  </div>
</div>
</div>