<?php

namespace Database\Seeders;

use App\Models\VariacaoGrade;
use Illuminate\Database\Seeder;
use App\Models\ItemVariacaoGrade;

class VariacaoGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $variacao = VariacaoGrade::Create(['variacao' => "Cor"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" => "Branco"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Azul"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Vermelho"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Verde"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Cinza"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Amarelo"]);
        ItemVariacaoGrade::Create(["variacao_grade_id"=>$variacao->id, "valor" =>"Preto"]);
        
        $variacao = VariacaoGrade::Create(['variacao' => "Tamanho"]);
        
        
    }
}
