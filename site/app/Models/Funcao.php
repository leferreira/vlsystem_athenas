<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcao extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao'];
    
    public function users(){
        return $this->belongsToMany(User::class);
    }
    
    public function permissoes() {
        return $this->belongsToMany(Permissao::class);
    }
    
    
    public  function permissoesNaoInseridas($filtro = null){
        $permissoes = Permissao::whereNotIn('permissaos.id', function($query) {
            $query->select('funcao_permissao.permissao_id');
            $query->from('funcao_permissao');
            $query->whereRaw("funcao_permissao.funcao_id={$this->id}");
        })
        ->where(function ($queryFilter) use ($filtro) {
            if ($filtro)
                $queryFilter->where('permissaos.permissao', 'LIKE', "%{$filtro}%");
        })
        ->get();
        
        return $permissoes;
    }
}
