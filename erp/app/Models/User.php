<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use App\Notifications\RedefinirSenhaNotification;
use App\Notifications\VerificarEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email',  'password','empresa_id','telefone','status_id','foto','eh_admin', "uuid"
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
 
    public function sendPasswordResetNotification($token) {
        $this->notify(new RedefinirSenhaNotification($token, $this->email, $this->name));
    }
    
    public function sendEmailVerificationNotification() {
        $this->notify(new VerificarEmailNotification($this->name));
    }
    
    
    public function scopeEmpresaUser(Builder $query)
    {
        return $query->where('empresa_id', auth()->user()->empresa_id);
    }
    
    public function status() {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }
    
    public function funcoes() {
        return $this->belongsToMany(Funcao::class);
    }
    
    public function empresa(){
        return $this->belongsTo(Empresa::class);
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
    //seta um status para o usuário
    public function setStatus( $status ) {
        
        if ( is_string( $status ) ) {
            $status = Status::where('status','=', $status)->firstOrFail();
        }
        //$this->staus_id = $status->id;
        $this->status()->associate($status);
        return $this->update();
        
    }
    //
  
 
   
}
