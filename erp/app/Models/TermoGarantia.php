<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermoGarantia extends Model
{
    use HasFactory;
    protected $fillable = ["id","data_garantia", "referencia_garantia","texto_garantia"];
}
