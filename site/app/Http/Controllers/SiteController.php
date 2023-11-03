<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use App\Service\SiteService;
use Illuminate\Http\Request;
use App\Models\PlanoPreco;


class SiteController extends Controller
{
    public function index(){ 
        
        $dados["planos"]       = Plano::all();
        return view("Site.home", $dados);
    }
    public function planos(){        
        $dados["planos"]       = PlanoPreco::where("recorrencia", 1)->get(); 
        $dados["id"] = 1;
        return view("Site.Planos", $dados);
    }
    
    public function recorrencia($id){ 
        $dados["planos"]       = PlanoPreco::where("recorrencia", $id)->get(); 
        $dados["id"] = $id;
        return view("Site.Planos", $dados);
    }
    public function cadastro($plano_preco_id){
        $dados["banner"]            = true;
        $dados["plano_preco_id"]    = $plano_preco_id;
        return view("Site.Cadastro", $dados);
    }
    
    public function cadastrar(Request $request){
        $req = $request->all();
        
        //Fazer a validação
        $this->_validate($request);
        SiteService::cadastrar($req); 
        return redirect(getenv("APP_URL_ERP"))->with("Faça o login com os dados cadastrados");
    }
    
    private function _validate(Request $request){
        $rules = [
            'nome'      => 'required|min:6|max:150',
            'empresa'   => 'required|min:6|max:150',
            'email'     => 'required|min:10|max:150|unique:empresas',
            'celular'   => 'required',
            'senha'     => 'required|min:6|max:50',
            'conheceu'  => 'required'
        ];
        
        $messages = [
            'nome.required'     => 'O campo nome é obrigatório.',
            'nome.max'          => '50 caracteres maximos permitidos.',
            'empresa.required'  => 'O campo nome da Empresa é obrigatório.',
            'email.required'    => 'O campo Email é obrigatório.',
            'celular.required'  => 'O campo Celular é obrigatório.',
            'senha.required'    => 'O campo Senha é obrigatório.',
            'conheceu.required' => 'Informe como nos conheceu.',
        ];
        $this->validate($request, $rules, $messages);
    }
    
    public function sucesso(){
        $dados["banner"]        = true;
        return view("Site.Sucesso", $dados);
    }
}
