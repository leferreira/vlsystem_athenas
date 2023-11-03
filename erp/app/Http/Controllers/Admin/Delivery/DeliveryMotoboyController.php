<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Motoboy;
use Illuminate\Http\Request;

class DeliveryMotoboyController extends Controller
{
   
    
    public function index()
    {
        $dados["motoboys"] = Motoboy::all();
        return view("Admin.Delivery.Motoboy.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.Motoboy.Create");
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
        
        $request->merge(['telefone2' => $request->telefone2 ?? '']);
        $request->merge(['telefone3' => $request->telefone3 ?? '']);
        
        
        $result = Motoboy::create($request->all());
        
        
        if($result){
            
            session()->flash("mensagem_sucesso", "Bairro cadastrado com sucesso.");
        }else{
            
            session()->flash('mensagem_erro', 'Erro ao cadastrar bairro.');
        }
        
        return redirect()->route('admin.eliverymotoboy.index');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:60',
            'telefone1' => 'required',
            'cpf' => 'required',
            'rg' => 'required',
            'endereco' => 'required'
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '60 caracteres maximos permitidos.',
            'telefone1.required' => 'Campo obrigatório',
            'cpf.required' => 'Campo obrigatório',
            'rg.required' => 'Campo obrigatório',
            'endereco.required' => 'Campo obrigatório',
            
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
        $dados["motoboy"] = Motoboy::find($id);
        return view('admin.Delivery.Motoboy.Create', $dados);
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
        Motoboy::where("id", $id)->update($req);
        return redirect()->route("deliverymotoboy.index");
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
            $h = Motoboy::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
