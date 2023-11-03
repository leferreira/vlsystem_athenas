<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListaComplementoDelivery;

class ListaComplementoDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ListaComplementoDelivery::create(['produto_id' => 2, 'complemento_id'=>1]);
        ListaComplementoDelivery::create(['produto_id' => 2, 'complemento_id'=>2]);
        ListaComplementoDelivery::create(['produto_id' => 2, 'complemento_id'=>3]);
        ListaComplementoDelivery::create(['produto_id' => 2, 'complemento_id'=>4]);
        ListaComplementoDelivery::create(['produto_id' => 2, 'complemento_id'=>5]);
    }
}
