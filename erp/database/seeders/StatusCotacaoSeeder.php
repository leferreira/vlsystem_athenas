<?php

namespace Database\Seeders;
use App\Models\StatusCotacao;
use Illuminate\Database\Seeder;

class StatusCotacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusCotacao::firstOrCreate([
            'status_cotacao'   =>  'Em digitação'
        ]);
        StatusCotacao::firstOrCreate([
            'status_cotacao'   =>  'Aguardando Fornecedores'
        ]);
        StatusCotacao::firstOrCreate([
            'status_cotacao'   =>  'Pronto para Cotar'
        ]);
        StatusCotacao::firstOrCreate([
            'status_cotacao'   =>  'Cotado'
        ]);
    }
}
