<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class LojaPacote extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'status_id', 'nome', 'descricao', 'valor','ordem'
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
