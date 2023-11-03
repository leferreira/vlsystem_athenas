<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EadCurso extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'curso',
        'imagem',
        'duracao',
        'mercadopago',
        'pagseguro',
        'password',
        'slug',
        'descricao',
        'valor',
        'data_cadastro',
        'empresa_id',
    ];
}
