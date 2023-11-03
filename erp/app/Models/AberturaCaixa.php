<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AberturaCaixa extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'valor', 'ultima_venda'
    ];
}
