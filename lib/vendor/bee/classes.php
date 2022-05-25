<?php


    class Bee {

        public $Ambiente = 'producao'; //homologacao ou producao
        public $AccessTOKEN = '7ee80ecf9002e205789139ef9179b3b4c3dbe776';



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


    }