<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Funcao::Create(['nome' => 'Admin',  'descricao' => 'Administrador']);
        Funcao::Create(['nome' => 'Operador',  'descricao' => 'Operador']); 
        Funcao::Create(['nome' => 'Vendedor',  'descricao' => 'Vendedor']); 
        Funcao::Create(['nome' => 'Caixa',  'descricao' => 'Caixa']); 
        Funcao::Create(['nome' => 'Supervisor',  'descricao' => 'Supervisor']); 
        Funcao::Create(['nome' => 'Financeiro',  'descricao' => 'Financeiro']); 
        Funcao::Create(['nome' => 'Estoquista',  'descricao' => 'Estoquista']); 
        Funcao::Create(['nome' => 'Coordenador',  'descricao' => 'Coordenador']); 
        
        
    }
}
