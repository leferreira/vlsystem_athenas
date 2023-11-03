<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdvVendaRequest extends FormRequest
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
            'empresa_id'   => 'required',
            'caixa_id'     => 'required',
            'usuario_id'   => 'required',
            'total'        => 'required',
        ];
    }
}
