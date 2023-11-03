<?php

namespace App\Tenant\Scopes;


use App\Tenant\ManagerEmpresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EmpresaScope implements Scope {
    public function apply(Builder $builder, Model $model) {
        $id = app(ManagerEmpresa::class)->getIdEmpresa();
        if($id)
            $builder->where("empresa_id", $id );
    }
}