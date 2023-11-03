<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class CupomDescontoRequest extends FormRequest
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
        return [
            
            'codigo' => [
                'required',              
                new UniqueTenant("cupom_descontos", $id)
            ],  
            'descricao'          => 'required'
        ];
    }

    
   
}
