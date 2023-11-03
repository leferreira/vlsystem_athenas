<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class TabelaPrecoProduto extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id',
        'tabela_preco_id',
        'produto_id',
        'valor',
        'data_atualizacao',  
    ];
    
    public function tabela_preco(){
        return $this->belongsTo(TabelaPreco::class,"tabela_preco_id");
    }
}
