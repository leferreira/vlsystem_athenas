<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EadAulas extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'curso_id',
        'empresa_id',
        'titulo',
        'embed',
        'duracao',
        'slug',
        'data_cadastro',
    ];
    
    public function curso(){
        return $this->belongsTo(EadCurso::class, 'curso_id');
    }
}
