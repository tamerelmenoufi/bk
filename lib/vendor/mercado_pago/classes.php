<?php

    class MercadoPago {

        public $Ambiente = 'producao'; //homologacao ou producao

        # SIstema BK
        //public $AccessTOKEN = '*****************************************************************';
        public $AccessTOKEN;

        public function TOKEN(){
            global $cBk;
            return $cBk['mercado_pago'][$this->Ambiente]['TOKEN'];
        }

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

            $this->AccessTOKEN = $this->TOKEN;

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

            $this->AccessTOKEN = $this->TOKEN;

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