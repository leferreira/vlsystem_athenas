<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class LojaBanner extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'produto_id', 'loja_pacote_id', 'status_id', 'path', 'titulo',
        'descricao'
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function pacote(){
        return $this->belongsTo(LojaPacote::class, 'loja_pacote_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
