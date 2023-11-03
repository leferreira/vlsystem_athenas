<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GestaoFornecedor;

class GestaoFornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GestaoFornecedor::create([
            'razao_social'  => 'Cemar ',
            'nome_fantasia' => 'Mercadão',
            'cpf_cnpj'      => '78589452387',
            'logradouro'           => 'Rua de Tal',
            'numero'        => '20',
            
            'uf'            => 'MA',
            'bairro'        => 'Centro',
            'complemento'        => '',
            'fone'          => '98991275551',
            'email'         => 'fornecedor@gmail.com',
            'cep'           => '65074410',
            'cidade'        => 'São Luis',
            'status_id'      => config("constantes.status.ATIVO")            
        ]);
    }
}
