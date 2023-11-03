<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaAdicional;

class CategoriaAdicionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaAdicional::create(['nome' => 'Categoria ùnica',"limite_escolha"=>3,"adicional"=>true]);
    }
}
