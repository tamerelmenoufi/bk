<?php

class mottu {

    public $ambiente = 'producao'; //homologação ou producao

    public function Ambiente($opc){
        if($opc == 'homologacao'){
            return 'https://integrations.mottu.io/delivery';
        }else{
            return 'https://integrations.mottu.cloud/delivery';
        }
    }

    public function apiKey($opc, $loja){

        if($opc == 'producao'){
            $Lojas = [
                'hc' => '8C0CC3BEBE314FD1830520A2A09AC8F8XXXXX',
            ];
            return $Lojas[$loja];
        }else{
            return 'F74C23D9DF05489E9A5185EB5F7DEE28';
        }

    }

    public function NovoPedido($json){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'/orders',
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey(),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apikey()."\n";

    }


    public function ConsultarPedido($pedido){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'/orders/'.$pedido,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey(),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response."\n".$this->Ambiente($this->ambiente)."\n".$this->apikey()."\n";

    }


    public function cancelarPedido($json){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'/orders/cancel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey(),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response."\n".$this->Ambiente($this->ambiente)."\n".$this->apikey()."\n";
    }

    public function calculaFrete($json, $loja = false){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente)."/orders/preview",
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey($this->ambiente, $loja),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response."\n".$this->Ambiente($this->ambiente)."\n".$this->apikey($this->ambiente, $loja)."\n";

    }

    public function webhook($json){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente)."/webhooks/handle",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey(),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response."\n".$this->Ambiente($this->ambiente)."\n".$this->apikey()."\n";

    }


}



    $cod_pedido = 33;

    $origem_rua = 'Rua Bruxelas';
    $origem_numero = '15';
    $origem_complemento = 'Em frente ao PAC';
    $origem_bairro = 'Planalto';
    $origem_cidade = 'Manaus';
    $origem_estado = 'AM';
    $origem_cep = '69045260';

    $endereco_rua = 'Rua Monsenhor Coutinho';
    $endereco_numero = '600';
    $endereco_complemento = 'Edifício Maximino Correia, Apartamento 1302';
    $endereco_bairro = 'Centro';
    $endereco_cidade = 'Manaus';
    $endereco_estado = 'AM';
    $endereco_cep = '69010110';

    $json = "{
      \"previewDeliveryTime\": true,
      \"sortByBestRoute\": false,
      \"deliveries\": [
        {
          \"orderRoute\": {$cod_pedido},
          \"address\": {
            \"street\": \"{$endereco_rua}\",
            \"number\": \"{$endereco_numero}\",
            \"complement\": \"{$endereco_complemento}\",
            \"neighborhood\": \"{$endereco_bairro}\",
            \"city\": \"{$endereco_cidade}\",
            \"state\": \"{$endereco_estado}\",
            \"zipCode\": \"{$endereco_cep}\"
          },
          \"onlinePayment\": true
        }
      ]
    }";


      $mottu = new mottu;

      echo $retorno = $mottu->calculaFrete($json, 'hc');