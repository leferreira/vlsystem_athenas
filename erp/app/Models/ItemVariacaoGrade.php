<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ItemVariacaoGrade extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
       'empresa_id', 'variacao_grade_id', 'descricao', 'valor', 
    ];
    
    public function variacao(){
        return $this->belongsTo(VariacaoGrade::class, 'variacao_grade_id');
    }
}
