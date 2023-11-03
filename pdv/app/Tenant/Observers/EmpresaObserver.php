<?php

namespace App\Tenant\Observers;

use App\Tenant\ManagerEmpresa;
use Illuminate\Database\Eloquent\Model;

class EmpresaObserver {
    public function creating(Model $model){
        $id = App(ManagerEmpresa::class)->getIdEmpresa();
        $model->setAttribute("empresa_id", $id);
    }
}