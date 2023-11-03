<?php

namespace App\Tenant;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTenant implements Rule
{
    protected $table, $value, $collumn;
    
    public function __construct(string $table, $value = null, $collumn = 'id')
    {
        $this->table = $table;
        $this->value = $value;
        $this->collumn = $collumn;
    }

    
    public function passes($attribute, $value)
    {
        $empresaId = app(ManagerEmpresa::class)->getIdEmpresa();
        
        $register = DB::table($this->table)
        ->where($attribute, $value)
        ->where('empresa_id', $empresaId)
        ->first();
        
        if ($register && $register->{$this->collumn} == $this->value)
            return true;
        
        return is_null($register);
    }

    
    public function message()
    {
        return 'O valor para :attribute já está em uso !';
    }
}
