<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Categoria;
use App\Models\CupomDesconto;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\CupomDescontoRequest;

class CupomDescontoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'cupomdesconto';
    }    
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]         = CupomDesconto::get();  
        $dados["categorias"]    = Categoria::get();
        $dados["produtos"]       = Produto::get();
          
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.CupomDesconto.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.CupomDesconto.Create");
    }

    public function salvarJs(Request $request){
        
        $req = $request->except(["_token","_method"]);
        CupomDesconto::Create($req);
        $lista = CupomDesconto::get();
        echo json_encode($lista);
    }
    
    public function store(CupomDescontoRequest $request){
        try {
            $this->checaPermissao(__FUNCTION__);
            $req = $request->except(["_token","_method"]);
            $req["desconto_por_valor"] = $req["desconto_por_valor"] ? getFloat($req["desconto_por_valor"]) : 0;
            $req["desconto_percentual"] = $req["desconto_percentual"] ? getFloat($req["desconto_percentual"]) : 0;
            $req["valor_minimo"] = $req["valor_minimo"] ? getFloat($req["valor_minimo"]) : 0;
            CupomDesconto::Create($req);
            return redirect()->route('admin.cupomdesconto.index')->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro',"erro: " . $e->getMessage());
        }
        
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $this->checaPermissao(__FUNCTION__);
        $dados["cupomdesconto"]  = CupomDesconto::find($id);        
        $dados["lista"]         = CupomDesconto::get();
        $dados["categorias"]    = Categoria::get();
        $dados["produtos"]      = Produto::get();
     
        return view('Admin.Cadastro.CupomDesconto.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        $req["desconto_por_valor"] = $req["desconto_por_valor"] ? getFloat($req["desconto_por_valor"]) : 0;
        $req["desconto_percentual"] = $req["desconto_percentual"] ? getFloat($req["desconto_percentual"]) : 0;
        $req["valor_minimo"] = $req["valor_minimo"] ? getFloat($req["valor_minimo"]) : 0;
        CupomDesconto::where("id", $id)->update($req);
        return redirect()->route("admin.cupomdesconto.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = CupomDesconto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
