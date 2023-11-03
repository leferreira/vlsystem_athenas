<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class ContaCorrenteRequest extends FormRequest
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
            
            'descricao' => [
                'required',              
                new UniqueTenant("conta_correntes", $id)
            ],  
            'tipo_conta_corrente_id'          => 'required',
            'banco_id'                        => 'required',
            'agencia'                        => 'required',
            'conta'                          => 'required',
        ];
    }

    
   
}
