<?php


    class MercadoPago {

        public $Ambiente = 'producao'; //homologacao ou producao

        //Homologação
        // public $PV = '19348375';
        // public $TOKEN = '2b4e31d3a75b429c9ef5fdd02f2b5c59';

        //produção
        # TAMER
        //public $AccessTOKEN = 'TEST-7005694497942738-042513-1436ca13f7406f79cb64f3ec45899547-182791413';
        // public $AccessTOKEN = 'APP_USR-7005694497942738-042513-790803032b2264d9df4929b9668cae16-182791413';

        # SIstema BK
        //public $AccessTOKEN = 'TEST-7005694497942738-042513-1436ca13f7406f79cb64f3ec45899547-182791413';
        public $AccessTOKEN = 'APP_USR-8942495640154155-053112-1c6fe2ed11a06c7fc854277fb95d2afe-1125971512';



        public function Autenticacao($opc){
            return $opc;
        }
        public function Ambiente($opc){
            if($opc == 'homologacao'){
                return 'https://api.mercadopago.com/v1/payments/';
            }else{
                return 'https://api.mercadopago.com/v1/payments/';
            }
        }


        public function Transacao($d){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->Ambiente($this->Ambiente));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json",
              "Authorization: Bearer ".$this->Autenticacao($this->AccessTOKEN)
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $d);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;

        }

        public function ObterPagamento($Id){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->Ambiente($this->Ambiente).$Id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              //"Content-Type: application/json",
              "Authorization: Bearer ".$this->Autenticacao($this->AccessTOKEN)
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $d);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;

        }


    }