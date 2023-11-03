<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LojaProdutoRequest extends FormRequest
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
        return [
            'produto_id '       => 'required',
            'categoria_id'      => 'required',
            'largura'           => 'required',
            'comprimento'       => 'required',
            'altura'            => 'required',
            'peso_liquido'      => 'required',
            'peso_bruto'        => 'required'
        ];
    }
}
