<?php

class Criptografia{

    public function criptografarBase64($valor){

        return base64_encode($valor);

    }
}