<?php

namespace Database\Seeders;

use App\Models\OperadoraCartao;
use Illuminate\Database\Seeder;

class OperadoraCartaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperadoraCartao::Create(['nome' =>'Cielo']);   
        OperadoraCartao::Create(['nome' =>'Rede']);
        OperadoraCartao::Create(['nome' =>'Hipercard']);
        OperadoraCartao::Create(['nome' =>'Amex']);
        OperadoraCartao::Create(['nome' =>'GetNet']);
        OperadoraCartao::Create(['nome' =>'Stone']);
        OperadoraCartao::Create(['nome' =>'Elavon']);
        OperadoraCartao::Create(['nome' =>'Global Payments']);        
    }
}
