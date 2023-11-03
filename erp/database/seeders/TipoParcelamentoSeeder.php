<?php

namespace Database\Seeders;

use App\Models\TipoParcelamento;
use Illuminate\Database\Seeder;

class TipoParcelamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoParcelamento::Create(['nome' =>'Crédito']);
        TipoParcelamento::Create(['nome' =>'Débito']);
    }
}
