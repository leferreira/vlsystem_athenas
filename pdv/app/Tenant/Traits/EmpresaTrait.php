<?php
namespace App\Tenant\Traits;

use App\Tenant\Observers\EmpresaObserver;
use App\Tenant\Scopes\EmpresaScope;

trait EmpresaTrait{
    public static function boot(){
        parent::boot();
        static::addGlobalScope(new EmpresaScope );
        static::observe(new EmpresaObserver());
    }
}

