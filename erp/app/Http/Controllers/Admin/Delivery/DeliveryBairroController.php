<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BairroDelivery;
use Illuminate\Http\Request;

class DeliveryBairroController extends Controller
{
   
    
    public function index()
    {
        $dados["bairros"] = BairroDelivery::all();
        return view("Admin.Delivery.Bairro.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.Bairro.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bairro = new BairroDelivery();
        $this->_validate($request);
        
        $request->merge(['valor_entrega' => str_replace(",", ".", $request->valor_entrega)]);
        $request->merge(['valor_repasse' => $request->valor_repasse ? str_replace(",", ".", $request->valor_repasse) : 0]);
        
        $result = $bairro->create($request->all());
        
        if($result){
            
            session()->flash("mensagem_sucesso", "Bairro cadastrado com sucesso.");
        }else{
            
            session()->flash('mensagem_erro', 'Erro ao cadastrar bairro.');
        }
        
        return redirect()->route('admin.deliverybairro.index');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:50',
            'valor_entrega' => 'required'
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '50 caracteres maximos permitidos.',
            'valor_entrega.required' => 'O campo valor de entrega é obrigatório.',
            
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
        $dados["bairro"] = BairroDelivery::find($id);
        return view('admin.Delivery.Bairro.Create', $dados);
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
        BairroDelivery::where("id", $id)->update($req);
        return redirect()->route("admin.deliverybairro.index");
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
            $h = BairroDelivery::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
