<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissao extends Model
{
    use HasFactory;
    protected $table = 'permissaos';
    protected $fillable = ['permissao', 'descricao'];
    
    public function funcoes() {
        return $this->belongsToMany(Funcao::class);
    }
}
