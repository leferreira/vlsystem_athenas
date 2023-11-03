<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnotacaoOs extends Model
{
    use HasFactory;
    protected $fillable = [
         'os_id', 'anotacao', 'data', 'hora'
    ];
    

    
    public function os(){
        return $this->belongsTo(OrdemServico::class, 'os_id');
    }
}
