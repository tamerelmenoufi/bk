<?php


    class Rede {

        function Pay($dados){
            $d = json_decode($dados);
            $retorno = "Olá {$d->nome}, verifiquei que o seu e-mail é {$d->email} e seu telefone é {$d->telefone}";
            return $retorno;
        }

        function Capture(){
            return 'Realizar Captura!';
        }

        function Cancel(){
            return 'Efetuar Cancelamento 1!';
        }

        function Cancel2(){
            return 'Efetuar Cancrlamento 2!';
        }


    }