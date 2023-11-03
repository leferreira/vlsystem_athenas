<?php


namespace App\Http\Controllers\Acl;


use Illuminate\Support\Facades\Gate;

trait PermissaoTrait{

    protected $modelName;
    private $msg = "Acesso não autorizado, por favor consulte o Administrador";

    public function checaPermissaoPersonalizada($permissao){
        if(Gate::denies($permissao)){
            abort(403, $this->msg);
        }
    }

    public function checaPermissao($acao){      
        $user = auth()->user();
        if($user->isNotAdmin()){
            switch ($acao){
                case 'index':
                case 'show':
                    if(Gate::denies("{$this->modelName}-visualizar")){
                        abort(403, $this->msg);
                    }
                    break;
                case 'create':
                case 'store':
                    if(Gate::denies("{$this->modelName}-cadastrar")){
                        abort(403, $this->msg);
                    }
                    break;
                case 'destroy':
                    if(Gate::denies("{$this->modelName}-excluir")){
                        abort(403, $this->msg);
                    }
                    break;
                case 'edit':
                case 'update':
                    if(Gate::denies("{$this->modelName}-editar")){
                        abort(403, $this->msg);
                    }
                    break;
            }
        }
    }

}
