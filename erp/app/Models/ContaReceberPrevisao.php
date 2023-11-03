<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaReceberPrevisao extends Model
{
    use HasFactory;protected $fillable =[
        "conta_receber_id",
        "data_previsao",
        "historico",
    ];
}
