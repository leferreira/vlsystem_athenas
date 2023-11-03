<?php

namespace App\Observers;

use App\Models\Categoria;
use Str;

class CategoriaObserver
{
    public function creating(Categoria $categoria)
    {
        $categoria->url = Str::kebab($categoria->categoria);
        $categoria->uuid = Str::uuid();
    }
    
    public function updating(Categoria $categoria)
    {
        $categoria->url = Str::kebab($categoria->categoria);
    }
}
