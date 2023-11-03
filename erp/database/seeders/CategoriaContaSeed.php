<?php

namespace Database\Seeders;

use App\Models\CategoriaConta;
use Illuminate\Database\Seeder;

class CategoriaContaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaConta::create(['nome' => 'Compras']);
        CategoriaConta::create(['nome' => 'Vendas' ]);
        
        
    }
}
