<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinTipoDespesa;

class TipoDespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinTipoDespesa::Create([
            'nome'   =>  'Água'
        ]);
        FinTipoDespesa::Create([
            'nome'   =>  'Luz'
        ]);
        FinTipoDespesa::Create([
            'nome'   =>  'Telefone'
        ]);
        FinTipoDespesa::Create([
            'nome'   =>  'Aluguel'
        ]);
    }
}
