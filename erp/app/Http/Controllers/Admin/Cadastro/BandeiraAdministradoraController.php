<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\AdministradoraCartao;
use App\Models\Bandeira;
use App\Models\BandeiraAdministradora;
use Illuminate\Http\Request;
use App\Models\FormaPagto;
use App\Models\FormaParcelamento;

class BandeiraAdministradoraController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'categoria';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["bandeiras"] = Bandeira::get();
        $dados["administradoras"] = AdministradoraCartao::get();
        $dados["formas"]  = FormaPagto::get();
        
        $dados["lista"] = BandeiraAdministradora::get();
        return view("Admin.Cadastro.BandeiraAdministradora.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.BandeiraAdministradora.Create");
    }

    
    
    public function listarBandeiraAdministradora(){
        $lista = BandeiraAdministradora::get();
        echo json_encode($lista);
    }
    

    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method"]);
        BandeiraAdministradora::Create($req);
        return redirect()->route('admin.bandeiraadministradora.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function show($id)
    {
        //Escolher a forma de pagamento
        // - Cartão de Credito
        $forma_pagto_id = config("constantes.forma_pagto.CARTAO_CREDITO");
        
        
        // - Lista as Bandeiras
        $bandeiras = BandeiraAdministradora::where("forma_pagto_id", $forma_pagto_id)->get();
        foreach($bandeiras as $bandeira){          
            echo $bandeira->descricao . "<br>";
            
        }
        //Escolhe a bandeira
        $bandeira_selecionada = $bandeiras[0]->id;
        
        //lista as formas de pagamento
        $formas_pagto = FormaParcelamento::where("administradora_cartao_id", $bandeira->administradora_cartao_id)->get();
        $j=1;
        $valor = 100;
        foreach ($formas_pagto as $f){           
            $inicio = $f->parcela_de;
            for($i=$inicio; $i<=$f->parcela_ate; $i++){
              echo $j . " - ".  $f->taxa ."<br>";
                $j++;
            }
           //echo  $f->parcela_de . " a " . $f->parcela_ate . " = " . $f->taxa ."<br>";
        }
    }
   
    public function edit($id){
        $dados["categoria"]     = BandeiraAdministradora::find($id);
        $dados["categorias"]    = BandeiraAdministradora::get();
        return view('Admin.Cadastro.BandeiraAdministradora.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        BandeiraAdministradora::where("id", $id)->update($req);
        return redirect()->route("admin.categoria.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    public function pesquisa(){
        $q          = $_GET["q"];
        $lista      = BandeiraAdministradora::where("categoria","like","%$q%")->get();
        return response()->json($lista);
    }
    
 
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = BandeiraAdministradora::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
