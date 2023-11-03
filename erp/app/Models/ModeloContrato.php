<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ModeloContrato extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = ['empresa_id', 'status_id','nome','conteudo' ];
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
