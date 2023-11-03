<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplementoDelivery;

class ComplementoDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ComplementoDelivery::create(['nome' => 'Alface Americana',"valor"=> 1,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Rúcula',"valor"=> 1,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Tomate',"valor"=> 1,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Cebola Roxa',"valor"=> 2,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Alho Frito',"valor"=> 2,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Picles',"valor"=> 2,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Bacon',"valor"=> 2,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Maionese da casa',"valor"=> 2,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Catupiry',"valor"=> 3,"categoria_id"=>1]);
        ComplementoDelivery::create(['nome' => 'Molho Cheddar',"valor"=> 3,"categoria_id"=>1]);
    }
}
