<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuncionamentoDelivery;

class FuncionamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FuncionamentoDelivery::create([
            'dia' => 'DOMINGO',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'SEGUNDA',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'TERÇA',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'QUARTA',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'QUINTA',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'SEXTA',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
        
        FuncionamentoDelivery::create([
            'dia' => 'SABADO',
            'inicio_expediente' => '08:00',
            'fim_expediente' => '23:59',
            'ativo' => 1
        ]);
    }
}
