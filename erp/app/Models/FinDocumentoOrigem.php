<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinDocumentoOrigem extends Model
{
    use HasFactory;
    protected $fillable   = ["id","codigo","sigla","documento_origem"];
}
