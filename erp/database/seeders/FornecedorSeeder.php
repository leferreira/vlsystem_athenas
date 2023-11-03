<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fornecedor::create([
            'empresa_id'    => 1,
            'razao_social'  => 'Sistema',
            'nome_fantasia' => 'Sistema',
            'cnpj'      => '0000000',
            'logradouro'           => 'Rua de Tal',
            'numero'        => '20',
            
            'uf'            => 'MA',
            'bairro'        => 'Centro',
            'complemento'        => '',
            'telefone'      => '9999999999',
            'celular'       => '9999999999',
            'email'         => 'fornecedor@gmail.com',
            'cep'           => '65070000',
            'ibge'           => '',
            'cidade'        => 'São Luis'            
            
        ]);
    }
}

