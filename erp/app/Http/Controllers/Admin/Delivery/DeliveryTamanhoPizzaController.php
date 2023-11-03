<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\TamanhoPizza;
use Illuminate\Http\Request;

class DeliveryTamanhoPizzaController extends Controller
{
    
    
    public function index()
    {
        $dados["tamanhos"] = TamanhoPizza::all();
        return view("Admin.Delivery.TamanhoPizza.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.TamanhoPizza.Create");
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
        
        $res = TamanhoPizza::create($request->all());
        
        if($res){
            session()->flash('color', 'blue');
            session()->flash('message', 'Tamanho de pizza adicionado!');
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro!');
        }
        
        return redirect()->route('admin.deliverytamanhopizza.index');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:20',
            'pedacos' => 'required',
            'maximo_sabores' => 'required',
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'Maximo de 20 caracteres.',
            'pedacos.required' => 'O campo pedaços é obrigatório.',
            'maximo_sabores.required' => 'O campo maximo de sabores é obrigatório.',
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
        $dados["bairro"] = TamanhoPizza::find($id);
        return view('admin.Delivery.TamanhoPizza.Create', $dados);
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
        TamanhoPizza::where("id", $id)->update($req);
        return redirect()->route("deliverytamanhopizza.index");
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
            $h = TamanhoPizza::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
