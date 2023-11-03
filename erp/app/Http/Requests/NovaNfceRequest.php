<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NovaNfceRequest extends FormRequest
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
    public function rules() {
       
        $rules =  [
            'natureza_operacao_id'  => 'required',
            'verProc'               => 'required',
            'indIntermed'           => 'required',
            'cnpjIntermed'          => 'nullable',
            'idCadIntTran'          => 'nullable',
            'tipo_nota_referenciada'=> 'nullable',
            'ref_NFe'               => 'nullable',
            'ref_ano_mes'           => 'nullable',
            'ref_num_nf'            => 'nullable',
            'ref_serie'             => 'nullable',
       ];
        
        if($this->indIntermed==1){
            $rules['cnpjIntermed']  = 'required';
            $rules['idCadIntTran']  = 'required';
        }
        

        return $rules;
    }
}
