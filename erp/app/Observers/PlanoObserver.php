<?php

namespace App\Observers;

use App\Models\Plano;
use Str;

class PlanoObserver
{
    public function creating(Plano $plan)
    {
        $plan->url = Str::kebab($plan->nome);
    }
    
    
    public function updating(Plano $plan)
    {
        $plan->url = Str::kebab($plan->nome);
    }
}
