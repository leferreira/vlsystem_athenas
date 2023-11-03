<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Categoria extends Model
{    
    use EmpresaTrait;
    protected $fillable = ["id","empresa_id", "categoria","imagem"];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function subcategorias(){
        return $this->hasMany(SubCategoria::class, 'categoria_id', 'id');
    }
}


