<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email',  'password','empresa_id','telefone','status_id','foto','eh_admin',"uuid"
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function scopeEmpresaUser(Builder $query)
    {
        return $query->where('empresa_id', auth()->user()->empresa_id);
    }
    
    public function status() {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }
    

    
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
    
    //verifica se o usuário é admin master
    public function isAdminMaster()
    {
        return $this->perfilExiste('Admin-Master');
    }
    
    public function perfilMaisAlto(){
        return $this->perfis->pluck('id')->min() ?? 0;
    }
     
    
    //checa se é uma pessoa
    public function ehPessoaFisica() {
        
        if ( ! $this->ehPessoa() ) {
            return false;
        }
        return ($this->pessoa->tipo_pessoa_id == 1 ? true : false);
        
    }
    
    //checa se é uma pessoa
    public function ehPessoaJuridica() {
        
        if ( ! $this->ehPessoa() ) {
            return false;
        }
        return ($this->pessoa->tipo_pessoa_id == 2 ? true : false);
        
    }
    
   
    //verifica se o usuário tem um perfil da lista
    public function temUmPerfilDaLista($perfis)
    {
        $perfis_usuario = $this->perfis;
        return $perfis->intersect($perfis_usuario)->count();
    }
    //está ativo no sistema?
    public function isAtivo() {
        
        if ($this->status_id == config('constantes.status.ATIVO')) {
            return true;
        } else {
            return false;
        }
    }
    //foi deletado do sistema?
    public function isDeletado() {
        
        if ($this->status_id == config('constantes.status.DELETADO')) {
            return true;
        } else {
            return false;
        }
    }
    //foi bloqueado temporariamente do sistema?
    public function isBloqueado() {
        
        if ($this->status_id == config('constantes.status.BLOQUEADO')) {
            return true;
        } else {
            return false;
        }
    }
    
   
    
    public function limpaTodosPerfis()
    {
        foreach( $this->perfis as $atual ) {
            $this->dropPerfil($atual);
        }
        return;
    }
  
    
 
   
}
