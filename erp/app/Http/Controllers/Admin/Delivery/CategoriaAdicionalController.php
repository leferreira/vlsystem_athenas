<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\CategoriaAdicional;
use Illuminate\Http\Request;

class CategoriaAdicionalController extends Controller
{
    
    public function index()
    {
        $dados["categorias"] = CategoriaAdicional::all();
        return view("Admin.Delivery.CategoriaAdicional.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.CategoriaAdicional.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_validate($request);
        
        try{
            $request->merge(['adicional' => $request->adicional ? true : false]);
            $res = CategoriaAdicional::create($request->all());
            session()->flash('mensagem_sucesso', 'Categoria adicionada!!');
            
        }catch(\Exception $e){
            session()->flash('mensagem_erro', 'Erro: ' . $e->getMessage());
            
        }
        
        return redirect()->route('admin.categoriaadicional.index');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:30',
            'limite_escolha' => 'required',
            
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '50 caracteres maximos permitidos.',
            'limite_escolha.required' => 'O campo limite é obrigatório.'
            
        ];
        $this->validate($request, $rules, $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados["categorias"] = CategoriaAdicional::all();
        $dados["categoria"] = CategoriaAdicional::find($id);
        return view('Admin.Delivery.CategoriaAdicional.Index', $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        CategoriaAdicional::where("id", $id)->update($req);
        return redirect()->route("categoriaadicional.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $h = CategoriaAdicional::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
