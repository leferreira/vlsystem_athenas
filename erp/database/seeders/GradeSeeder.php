<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Variacao;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        Grade::create(['grade' => 'tamanho']);
        Variacao::create(['grade_id' => 1, 'variacao'=> 'PP']);
        Variacao::create(['grade_id' => 1, 'variacao'=> 'P']);
        Variacao::create(['grade_id' => 1, 'variacao'=> 'M']);
        Variacao::create(['grade_id' => 1, 'variacao'=> 'G']);
        Variacao::create(['grade_id' => 1, 'variacao'=> 'GG']);
        
        Grade::create(['grade' => 'cor']);
        Variacao::create(['grade_id' => 2, 'variacao'=> 'Vermelho']);
        Variacao::create(['grade_id' => 2, 'variacao'=> 'Azul']);
        Variacao::create(['grade_id' => 2, 'variacao'=> 'Roxo']);
        Variacao::create(['grade_id' => 2, 'variacao'=> 'Verde']);
        Variacao::create(['grade_id' => 2, 'variacao'=> 'Cinza']);
        
    }
}
