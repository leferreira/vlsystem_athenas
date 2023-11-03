<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class AutorizadosNfe extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'emitente_id', 'aut_contato','aut_cnpj'
    ];
}
