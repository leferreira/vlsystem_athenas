<?php

namespace App\Observers;

use App\Models\Cliente;
use App\Models\EnderecoCliente;
use Str;

class ClienteObserver
{
    public function creating(Cliente $cliente)
    {
        $cliente->uuid = Str::uuid();
    }
    
    public function created(Cliente $cliente){
        $end                    = new \stdClass();
        $end->cliente_id        = $cliente->id;
        $end->logradouro        = $cliente->logradouro;
        $end->numero            = $cliente->numero;
        $end->bairro            = $cliente->bairro;
        $end->cep               = $cliente->cep;
        $end->complemento       = $cliente->complemento;
        $end->cidade            = $cliente->cidade;
        $end->uf                = $cliente->uf;
        $end->ibge              = $cliente->ibge;
        EnderecoCliente::Create(objToArray($end));
    }
    
}
