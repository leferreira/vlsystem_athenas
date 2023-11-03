<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
   
    protected $fillable = ["status_cotacao_id","data_abertura","data_encerramento"];
    
    
    public function status(){
        return $this->belongsTo(StatusCotacao::class,"status_cotacao_id","id");
    }
}
