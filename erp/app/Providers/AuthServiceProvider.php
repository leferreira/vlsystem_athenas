<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Modulo;
use App\Models\Permissao;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

   
    public function boot()
    {
        $this->registerPolicies();
        if ($this->app->runningInConsole()) return;
        
        //verifica as permissçoes dos modulos
        $modulos = Modulo::all();
        foreach($modulos as $modulo){
            Gate::define($modulo->menu, function(User $user) use ($modulo){
                return $user->temAPermissaoModulo($modulo->menu);
            });
        }
      
        $permissoes = Permissao::all();
        foreach($permissoes as $permissao){
            Gate::define($permissao->permissao, function(User $user) use ($permissao){
                return ($user->temPermissaoFuncao($permissao->permissao) );
            });
        }
    
        Gate::define("dono", function(User $user, $object){
            return $user->id === $object->user_id;
        });

        //
    }
}
