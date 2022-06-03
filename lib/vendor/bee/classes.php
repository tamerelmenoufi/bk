<?php


    class Bee {

        public $Ambiente = 'producao'; //homologacao ou producao
        public $AccessTOKEN = '7ee80ecf9002e205789139ef9179b3b4c3dbe776';

        public function ConnectDB(){
            global $con;
            return $con;
        }

        public function Autenticacao($opc){
            return $opc;
        }
        public function Ambiente($opc){
            if($opc == 'homologacao'){
                return 'api';
            }else{
                return 'api';
            }
        }


        public function ValorViagem($id, $lat, $lng){

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://".$this->Ambiente($this->Ambiente).".beedelivery.com.br/api/v1/public/fees/calculate");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"vehicle\": \"M\",
                \"needReturn\": \"N\",
                \"origin\": {
                    \"externalId\": {$id}
                },
                \"destination\": {
                    \"type\": \"COORDS\",
                    \"address\": {
                        \"latitude\": {$lat},
                        \"longitude\": {$lng}
                    }
                }
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: ".$this->Autenticacao($this->AccessTOKEN)
            ));

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;

        }

        public function NovaEntrega($venda){

            $con = $this->ConnectDB();

            $query = "select * from vendas where codigo = '{$venda}'";
            $result = mysqli_query($con, $query);
            $v = mysqli_fetch_object($result);
            var_dump($v);

            exit();

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://".$this->Ambiente($this->Ambiente).".beedelivery.com.br/api/v1/public/deliveries/create");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"orderExternalId\": 4000,
                \"description\": \"Entrega Teste\",
                \"needReturn\": \"S\",
                \"vehicle\": \"M\",
                \"compartmentType\": \"BAG\",
                \"completedPermission\": \"S\",
                \"needCode\": \"N\",
                \"origin\": {
                    \"externalId\": 1
                },
                \"destination\": {
                    \"contactName\": \"Daraedna\",
                    \"contactPhone\": 84989898988,
                    \"type\": \"COORDS\",
                    \"address\": {
                        \"latitude\": -5.0447118,
                        \"longitude\": -42.7625088,
                        \"complement\": \"Depois do hospital\",
                        \"streetAddress\": \"R. São João, N. 1753, São Paulo – São Paulo\"
                        }
                    }
                },
                \"schedule\": {
                    \"callTime\": \"2022-09-07 12:00:00\"
                }
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json",
              "Authorization: ".$this->Autenticacao($this->AccessTOKEN)
            ));

            $response = curl_exec($ch);
            curl_close($ch);

            var_dump($response);


        }


    }