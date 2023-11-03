<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinTipoDespesa extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "nome"
    ];
}
