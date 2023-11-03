<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class LojaCategoriaProduto extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = ['empresa_id','nome', 'categoria_pai' ];
    
    public function categoria(){
        return $this->belongsTo(LojaCategoriaProduto::class, 'categoria_id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
