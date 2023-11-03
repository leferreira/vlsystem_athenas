<?php
namespace Database\Seeders;
use App\Models\StatusSolicitacao;
use Illuminate\Database\Seeder;

class StatusSolicitacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusSolicitacao::Create([
            'status_solicitacao'   =>  'Em Aberto'
        ]);
        StatusSolicitacao::Create([
            'status_solicitacao'   =>  'Em Cotação de Preço'
        ]);
        StatusSolicitacao::Create([
            'status_solicitacao'   =>  'Em Ordem de Compra'
        ]);
        StatusSolicitacao::Create([
            'status_solicitacao'   =>  'Em Estoque'
        ]);
        StatusSolicitacao::Create([
            'status_solicitacao'   =>  'Cancelado'
        ]);
    }
}
