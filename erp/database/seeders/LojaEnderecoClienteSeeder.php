<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LojaEnderecoCliente;

class LojaEnderecoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LojaEnderecoCliente::create([
            'empresa_id'    => 1,
            'cliente_id'   => 1,
            'rua'           => 'Rua Barata Ribeiro ',
            'numero'         => '100',
            'bairro'       => 'Centro',
            'cidade'         => 'Rio de Janeiro',
            'uf'         => 'RJ',
            'cep'    => '22040-002'
        ]);
        
        LojaEnderecoCliente::create([
            'empresa_id'    => 1,
            'cliente_id'   => 1,
            'rua'           => 'Rua Hugo da cunha machado',
            'numero'         => '100',
            'bairro'       => 'Centro',
            'cidade'         => 'São Luís',
            'uf'         => 'MA',
            'cep'    => '60030-700'
        ]);
    }
}
