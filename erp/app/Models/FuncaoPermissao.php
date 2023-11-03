<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FuncaoPermissao extends Model
{
    use HasFactory;
    protected $table = "funcao_permissao";
    public $fillable = ['funcao_id','permissao_id', "menu_id","submenu_id"];
    
    public function funcao(){
        return $this->belongsTo(Funcao::class,"funcao_id",'id',"funcao_permissao");
    }
    
    public function permissao(){
        return $this->belongsTo(Permissao::class,"permissao_id","id","funcao_permissao");
    }
}
