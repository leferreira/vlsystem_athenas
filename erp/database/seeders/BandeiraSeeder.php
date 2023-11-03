<?php

namespace Database\Seeders;

use App\Models\Bandeira;
use Illuminate\Database\Seeder;

class BandeiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bandeira::Create(['codigo' =>'01', 'bandeira' =>'Visa']);
        Bandeira::Create(['codigo' =>'02', 'bandeira' =>'Mastercard']);
        Bandeira::Create(['codigo' =>'03', 'bandeira' =>'American Express']);
        Bandeira::Create(['codigo' =>'04', 'bandeira' =>'Sorocred']);
        Bandeira::Create(['codigo' =>'05', 'bandeira' =>'Diners Club']);
        Bandeira::Create(['codigo' =>'06', 'bandeira' =>'Elo']);
        Bandeira::Create(['codigo' =>'07', 'bandeira' =>'Hipercard']);
        Bandeira::Create(['codigo' =>'08', 'bandeira' =>'Aura']);
        Bandeira::Create(['codigo' =>'09', 'bandeira' =>'Cabal']);
        Bandeira::Create(['codigo' =>'10', 'bandeira' =>'Alelo']);
        Bandeira::Create(['codigo' =>'11', 'bandeira' =>'Banes Card']);
        Bandeira::Create(['codigo' =>'12', 'bandeira' =>'CalCard']);
        Bandeira::Create(['codigo' =>'13', 'bandeira' =>'Credz']);
        Bandeira::Create(['codigo' =>'14', 'bandeira' =>'Discover']);
        Bandeira::Create(['codigo' =>'15', 'bandeira' =>'GoodCard']);
        Bandeira::Create(['codigo' =>'16', 'bandeira' =>'GreenCard']);
        Bandeira::Create(['codigo' =>'17', 'bandeira' =>'Hiper']);
        Bandeira::Create(['codigo' =>'18', 'bandeira' =>'JCB']);
        Bandeira::Create(['codigo' =>'19', 'bandeira' =>'Mais']);
        Bandeira::Create(['codigo' =>'20', 'bandeira' =>'MaxVan']);
        Bandeira::Create(['codigo' =>'21', 'bandeira' =>'Policard']);
        Bandeira::Create(['codigo' =>'22', 'bandeira' =>'RedeCompras']);
        Bandeira::Create(['codigo' =>'23', 'bandeira' =>'Sodexo']);
        Bandeira::Create(['codigo' =>'24', 'bandeira' =>'ValeCard']);
        Bandeira::Create(['codigo' =>'25', 'bandeira' =>'Verocheque']);
        Bandeira::Create(['codigo' =>'26', 'bandeira' =>'VR']);
        Bandeira::Create(['codigo' =>'27', 'bandeira' =>'Ticket']);
        Bandeira::Create(['codigo' =>'99', 'bandeira' =>'Outros']);
    }
}
