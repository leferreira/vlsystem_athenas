<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracaoNota;

class ConfiguracaoNotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfiguracaoNota::create([
            'empresa_id' => 1,
            'tributacao_id' => 1,
            'ambiente'  =>2
            
        ]);
    }
}
