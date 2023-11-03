<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EadMatricula extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'empresa_id',
        'curso_id',
        'aluno_id',
        'data_matricula',
        'hora_matricula',
    ];
    
    public function curso(){
        return $this->belongsTo(EadCurso::class, 'curso_id');
    }
    
    public function aluno(){
        return $this->belongsTo(EadAluno::class, 'aluno_id');
    }
}
