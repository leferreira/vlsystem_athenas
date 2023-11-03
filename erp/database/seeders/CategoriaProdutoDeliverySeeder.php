<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProdutoDelivery;

class CategoriaProdutoDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaProdutoDelivery::create(['nome'  => 'Pizza', 'descricao'    => 'Pizza' ]);
        CategoriaProdutoDelivery::create(['nome'  => 'Hamburguer', 'descricao'    => 'Hamburguer' ]);
        CategoriaProdutoDelivery::create(['nome'  => 'Refrigerante', 'descricao'    => 'Refrigerante' ]);
        CategoriaProdutoDelivery::create(['nome'  => 'Sucos', 'descricao'    => 'Sucos' ]);
        CategoriaProdutoDelivery::create(['nome'  => 'Porções', 'descricao'    => 'Porções' ]);
    }
}
