<?php

namespace App\Observers;

use App\Models\Empresa;
use Str;

class EmpresaObserver
{
    /**
     * Handle the Empresa "created" event.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return void
     */
    public function creating(Empresa $empresa)
    {
        $empresa->pasta = Str::uuid();  
        $empresa->uuid = Str::uuid(); 
    }

   

}
