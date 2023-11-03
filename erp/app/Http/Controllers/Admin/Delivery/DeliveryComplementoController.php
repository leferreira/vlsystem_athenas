<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\CategoriaAdicional;
use App\Models\ComplementoDelivery;
use Illuminate\Http\Request;

class DeliveryComplementoController extends Controller
{
    
    
    public function index()
    {
        $dados["categorias"]    = CategoriaAdicional::all();
        $dados["complementos"]  = ComplementoDelivery::all();
        return view("Admin.Delivery.Complemento.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados["categorias"] = CategoriaAdicional::all();
        return view("Admin.Delivery.Complemento.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $complemento = new ComplementoDelivery();
        
        $this->_validate($request);
        
        $request->merge([ 'valor' => str_replace(",", ".", $request->valor) ]);
        
        $result = $complemento->create($request->all());
        if($result){
            session()->flash("mensagem_sucesso", "Adicional cadastrado com sucesso.");
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar adicional.');
        }
        
        return redirect()->route('admin.deliverycomplemento.index');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:50',
            'valor' => 'required',
            'categoria_id' => 'required'
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '50 caracteres maximos permitidos.',
            'valor.required' => 'O campo valor é obrigatório.',
            'categoria_id.required' => 'O campo categoria é obrigatório.'
        ];
        $this->validate($request, $rules, $messages);
    }

    public function listaPorCategoria($id)
    {
        $complementos = ComplementoDelivery::where("categoria_id", $id)->get();
        echo json_encode($complementos);
    }
    
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
        $dados["complemento"] = ComplementoDelivery::find($id);
        $dados["categorias"]    = CategoriaAdicional::all();
        $dados["complementos"]  = ComplementoDelivery::all();
        return view('admin.Delivery.Complemento.Index', $dados);
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
        ComplementoDelivery::where("id", $id)->update($req);
        return redirect()->route("admin.deliverycomplemento.index");
    }

    
    public function destroy($id)
    {
        try{
            $h = ComplementoDelivery::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
