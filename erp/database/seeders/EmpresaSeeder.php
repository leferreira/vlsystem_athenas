<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
       Empresa::create([
            'razao_social'          =>  'Sistema',
            'cpf_cnpj'              =>  '12345678',
            'fone'                  =>  '9898988989',
            'email'                 =>  'sistema@sistema.com.br',
            'cep'                   =>  '22040002',
            'logradouro'            =>  'Rua',
            'numero'                =>  '191',
            'uf'                    =>  'MA',
            'cidade'                =>  'Cidade',
            'bairro'                =>  'Bairro',
            'status_id'             =>  config("constantes.status.ATIVO"),
            'status_assinatura_id'  =>  config("constantes.status.EM_DIAS"), 
        ]);
        
        
    }
}
