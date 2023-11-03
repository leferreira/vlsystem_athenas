<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContabilConta extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "id_pai",
        "codigo",
        "conta",
        "alias",
        "tipo",
        "natureza"
        
    ];
}
