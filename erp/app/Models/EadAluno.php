<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class EadAluno extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'nome',
        'cpf',
        'rg',
        'logradouro',
        'senha',
        'password',
        'numero',
        'bairro',
        'uf',
        'complemento',
        'telefone',
        'celular',
        'email',
        'cep',
        'cidade',
        'nascimento',
        'empresa_id',
        'status_id',
    ];
}
