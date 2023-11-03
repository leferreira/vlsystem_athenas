<?php

namespace App\Observers;


use App\Models\GradeProduto;
use App\Models\Produto;

class GradeProdutoObserver
{
    public function created(GradeProduto $grade)
    {
        $produto = Produto::find($grade->produto_id);
        if($produto->usa_grade != "S"){
            $produto->usa_grade = "S";
            $produto->save();
        }
        
    }
    
  
    public function deleted(GradeProduto $grade)
    {
        $tem = GradeProduto::where("produto_id", $grade->produto_id)->first();
        if(!$tem){
            $produto = Produto::find($grade->produto_id);           
            $produto->usa_grade = "N";
            $produto->save();            
        }
    }
}
