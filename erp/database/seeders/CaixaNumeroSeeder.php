<?php

namespace Database\Seeders;

use App\Models\PdvCaixaNumero;
use Illuminate\Database\Seeder;

class CaixaNumeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PdvCaixaNumero::create(['num_caixa' => 1,"descricao"=>'Caixa 01',"empresa_id"=>1]);
        PdvCaixaNumero::create(['num_caixa' => 2,"descricao"=>'Caixa 02',"empresa_id"=>1]);
    }
}
