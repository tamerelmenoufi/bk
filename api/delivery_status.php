<?php

include("../lib/includes.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
$_POST = json_decode(file_get_contents('php://input'), true);
$dados = json_encode($_POST);

if($_POST['CodigoExterno']){

    $query = "insert into status_delivery set
                                venda = '{$_POST['CodigoExterno']}',
                                operadora = 'mottu',
                                tipo = '{$_POST['Tipo']}',
                                data = NOW(),
                                retorno = '{$dados}'";

    mysqli_query($con, $query);

    if($_POST['Tipo'] == 'bkmanaus'){
        $status = mysqli_fetch_object(mysqli_query($con, "select * from status_mottu where cod = '{$_POST['Situacao']}'"));
        if($status->campo == 'reset'){
            $query = "update vendas set
                                    SEARCHING = NOW(),
                                    GOING_TO_ORIGIN = 0,
                                    ARRIVED_AT_ORIGIN = 0,
                                    GOING_TO_DESTINATION = 0,
                                    ARRIVED_AT_DESTINATION = 0,
                                    RETURNING = 0,
                                    COMPLETED = 0,
                                    CANCELED = 0,
                                    name = '',
                                    phone = ''
                where codigo = '{$_POST['CodigoExterno']}'
            ";
        }else if($status->campo){
            $query = "update vendas set $status->campo = NOW()".(($_POST['Situacao'] == 30)?", situacao = 'c'":false)." where codigo = '{$_POST['CodigoExterno']}'";
        }

        if($query){
            mysqli_query($con, $query);
        }

        // EnviarWapp('92991886570',"VENDA - pedido *{$_POST['CodigoExterno']}* com alteração status *{$_POST['Situacao']}*.");
        //*/
        // SOLICITAÇÃO DA ENTREGA BEE
        //////////////////////////////////////////////////////////

        $query = "select
                        a.*,
                        d.id as id_loja,
                        d.mottu as id_mottu,
                        b.nome,
                        b.cpf,
                        b.telefone,
                        b.email,
                        c.cep,
                        c.numero,
                        c.rua,
                        c.bairro,
                        c.referencia
                    from vendas a
                        left join clientes b on a.cliente = b.codigo
                        left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
                        left join lojas d on a.loja = d.codigo
                    where a.codigo = '{$_POST['CodigoExterno']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        $mottu = new mottu;
        $retorno1 = $mottu->ConsultarPedido($d->deliveryId,$d->id_mottu);
        $retorno = json_decode($retorno1);

        if($retorno->code){
        $query = "update vendas set delivery_retorno = '{$retorno1}' where codigo = '{$retorno->code}'";
        mysqli_query($con,$query);
        }

    }else{

        if($_POST['PedidoId']){
            echo "HC<br>";
            $mottu = new mottu;
            $retorno1 = $mottu->ConsultarPedido($_POST['PedidoId'],813416);
            $retorno = json_decode($retorno1);
            echo "<pre>".var_dump($retorno)."</pre>";
            echo "codigo:".$retorno->code;

            if($retorno->code){
            $query = "replace into vendas_ifood set venda = '{$retorno->code}', deliveryId={$retorno->id}, data = NOW(), retorno = '{$retorno1}'";
            mysqli_query($con,$query);
            }

            echo "<hr>";
            echo "DJ<br>";
            $mottu = new mottu;
            $retorno1 = $mottu->ConsultarPedido($_POST['PedidoId'],813383);
            $retorno = json_decode($retorno1);
            echo "<pre>".var_dump($retorno)."</pre>";

            echo "codigo:".$retorno->code;
            if($retorno->code){
              $query = "replace into vendas_ifood set venda = '{$retorno->code}', deliveryId={$retorno->id}, data = NOW(), retorno = '{$retorno1}'";
              mysqli_query($con,$query);
            }
        }

    }

}
