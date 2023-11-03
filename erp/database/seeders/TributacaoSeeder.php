<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tributacao;

class TributacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tributacao::create([
            'empresa_id'    => 1,
            'tributacao'    => 'Tributação Padrão - Simples Nacional',
            'cstCOFINS'     => '07',
            'cstPIS'        => '07',
            'cstIPI'        => '53',
            'cstICMS'       => '103',
            'icms_origem'   => '0',
            
        ]);
    }
}
