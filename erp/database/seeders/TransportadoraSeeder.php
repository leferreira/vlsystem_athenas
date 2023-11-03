<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transportadora;

class TransportadoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transportadora::create([
            'empresa_id'    => 1,
            'razao_social'  => 'Transportadora Granero',
            'nome_fantasia' => 'Mercadão',
            'cnpj'          => '78589452387',
            'logradouro'    => 'Rua de Tal',
            'numero'        => '20',
            
            'uf'            => 'MA',
            'bairro'        => 'Centro',
            'complemento'   => '',
            'telefone'      => '98991275551',
            'celular'       => '98991275551',
            'email'         => 'fornecedor@gmail.com',
            'cep'           => '65074410',
            'ibge'           => '',
            'cidade'        => 'São Luis'
            
        ]);
    }
}
