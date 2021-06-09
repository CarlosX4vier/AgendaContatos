<?php

namespace App\Http\Helpers;

use \SoapClient;

class CorreiosAPI
{

    private $client;

    public function __construct()
    {
        set_time_limit(0);
        $this->client = new SoapClient("https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl", array(
            'cache_wsdl' => WSDL_CACHE_BOTH,
        ));
    }

    public function consultarCEP($cep)
    {
        return $this->client->consultaCEP(array('cep' => $cep));
    }
}
