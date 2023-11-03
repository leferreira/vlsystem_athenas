<?php

namespace App\Tenant\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Tenant\ManagerEmpresa;
use Illuminate\Support\Facades\DB;

class UniqueEmpresa implements Rule
{
    protected $table, $value, $collumn;
    public function __construct(string $table, $value = null, $collumn = 'id')
    {
        $this->table = $table;
        $this->value = $value;
        $this->collumn = $collumn;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $empresaId = app(ManagerEmpresa::class)->getIdEmpresa();
        
        $salvo = DB::table($this->table)
        ->where($attribute, $value)
        ->where('empresa_id_id', $empresaId)
        ->first();
        
        if ($salvo && $salvo->{$this->collumn} == $this->value)
            return true;
            
            return is_null($salvo);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor para :attribute já está sendo usado ';
    }
}
