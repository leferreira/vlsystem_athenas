<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class TabelaPrecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->segment(3);
        $regras = [
            'nome'         => ['required',
            new UniqueTenant("tabela_precos", $id) ] 
            
        ];
        
        return $regras;
    }

    
   
}
