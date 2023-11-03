<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NovaNfeRequest extends FormRequest
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
            'cliente_id'            => 'required',
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
        
     /*   if($this->finNFe!=1){
            if($this->tipo_nota_referenciada==1  || $this->tipo_nota_referenciada==2  || $this->tipo_nota_referenciada==7 ){
                $rules['ref_NFe']  = 'required';
            }else if($this->tipo_nota_referenciada==3  || $this->tipo_nota_referenciada==4  || $this->tipo_nota_referenciada==5 || $this->tipo_nota_referenciada==6){
                $rules['ref_ano_mes']  = 'required';
                $rules['ref_num_nf']   = 'required';
                $rules['ref_serie']    = 'required';
            }else{
                $rules['tipo_nota_referenciada']    = 'required';
            }
         }
        */
        return $rules;
    }
}
