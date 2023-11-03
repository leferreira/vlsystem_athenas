<?php

namespace Database\Seeders;

use App\Models\IcmsDesoneracao;
use Illuminate\Database\Seeder;

class IcmsDesoneracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        IcmsDesoneracao::Create(['codigo' =>'1', 'descricao' => 'Táxi']);
        IcmsDesoneracao::Create(['codigo' =>'2', 'descricao' => 'Deficiente Físico']);
        IcmsDesoneracao::Create(['codigo' =>'3', 'descricao' => 'Produtor Agropecuário']);
        IcmsDesoneracao::Create(['codigo' =>'4', 'descricao' => 'Frotista / Locadora']);
        IcmsDesoneracao::Create(['codigo' =>'5', 'descricao' => 'Diplomático / Consular']);
        IcmsDesoneracao::Create(['codigo' =>'6', 'descricao' => 'Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio ']);
        IcmsDesoneracao::Create(['codigo' =>'7', 'descricao' => 'SUFRAMA']);
        IcmsDesoneracao::Create(['codigo' =>'8', 'descricao' => 'Venda a Órgãos Públicos']);
        IcmsDesoneracao::Create(['codigo' =>'9', 'descricao' => 'Outros']);
        
    }
}
