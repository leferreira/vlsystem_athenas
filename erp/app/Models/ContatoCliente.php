<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ContatoCliente extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'id', 'empresa_id', 'cliente_id', 'nome', 'email', 'nascimento', 'telefone','funcao'
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
