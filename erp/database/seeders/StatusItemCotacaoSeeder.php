<?php
namespace Database\Seeders;
use App\Models\StatusItemCotacao;
use Illuminate\Database\Seeder;

class StatusItemCotacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Aguardando Cotação'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Aguardando Aprovação'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Aprovado'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Cancelado'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Rejeitado'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Não comercializa'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'Não Atende'
        ]);
        
        StatusItemCotacao::firstOrCreate([
            'status_item_cotacao'   =>  'No Estoque'
        ]);
        
    }
}
