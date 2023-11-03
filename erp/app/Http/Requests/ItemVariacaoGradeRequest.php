<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemVariacaoGradeRequest extends FormRequest
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
            'variacao_grade_id' => 'required',
            'valor'             => [
                'required'
             ]
            
        ];
        
        return $regras;
    }

    
   
}
