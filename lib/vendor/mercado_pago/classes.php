<?php


    class MercadoPago {

        public $Ambiente = 'producao'; //homologacao ou producao

        //Homologação
        // public $PV = '19348375';
        // public $TOKEN = '2b4e31d3a75b429c9ef5fdd02f2b5c59';

        //produção
        public $AccessTOKEN = 'fdcc875290d64809acfbd09a8a111fd5';


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


    }