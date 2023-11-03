<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Tenant\UniqueTenant;

class ServicoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);
        $rules =  [
            'nome'=>[
                'required',
                'max:120',
                new UniqueTenant("produtos", $id)
            ],
            'valor_venda'   => 'required',
        ];      
        
        return $rules;
    }
}
