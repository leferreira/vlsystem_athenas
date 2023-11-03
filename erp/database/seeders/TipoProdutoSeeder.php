<?php

namespace Database\Seeders;

use App\Models\TipoProduto;
use Illuminate\Database\Seeder;

class TipoProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config("constantes.tipo_produto") as $chave=>$valor){
            TipoProduto::Create([
                'tipo_produto'    => $valor,
            ]);
        }
    }
}
