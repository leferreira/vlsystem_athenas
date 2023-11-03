<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class NumeroCaixaRequest extends FormRequest
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
        return [
            'num_caixa' => [
                'required',
                new UniqueTenant("pdv_caixa_numeros", $id)
            ],
            'descricao' => [
                'required',
                new UniqueTenant("pdv_caixa_numeros", $id)
            ],            
        ];
    }
}

