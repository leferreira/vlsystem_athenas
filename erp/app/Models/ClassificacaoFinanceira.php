<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ClassificacaoFinanceira extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = ['empresa_id','codigo','descricao','titulo_grupo','ativo','receita_despesa'];
}
