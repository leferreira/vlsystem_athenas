<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::firstOrCreate([
            'empresa_id'    => '1',
            'nome_razao_social'  => 'Manoel Jailton',
            'nome_fantasia' => 'mjailton',
            'cpf_cnpj'      => '78589452387',
            'telefone'          => '9899992466',
            'email'         => 'mjailton@gmail.com',
            'senha'         => '123',
            'cep'           => '65074410',
            'logradouro'    => 'Rua José do Patrocínio',
            'numero'        => '09',
            'uf'            => 'MA',
            'cidade'        => 'São Luís',
            'complemento'   => 'qd 20',
            'bairro'        => 'Cohama',
            'tipo_contribuinte'   => '9',
            'ibge'          => '2111300',
            'password'          =>  bcrypt("1234"),
            'status_id'      => config("constantes.status.ATIVO")
        ]);
        
      
    }
}
