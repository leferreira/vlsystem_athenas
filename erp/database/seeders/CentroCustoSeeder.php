<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CentroCusto;

class CentroCustoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroCusto::create(["empresa_id" =>1, 'nome' => 'Empresa']);
        CentroCusto::create(["empresa_id" =>1, 'nome' => 'Pessoal' ]);
    }
}
