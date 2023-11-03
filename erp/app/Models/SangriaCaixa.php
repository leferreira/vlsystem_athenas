<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SangriaCaixa extends Model
{
    use HasFactory;
    protected $fillable = [
        'usuario_id', 'valor', 'observacao'
    ];
    
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
