<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class TabelaPreco extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id',
        'nome',
        'padrao',
        
    ];
}
