<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\EnderecoDelivery;
use Illuminate\Http\Request;

class EnderecoWebController extends Controller
{
  
    public function index()
    {
        $dados["bairros"] = EnderecoDelivery::all();
        return view("Admin.Delivery.Endereco.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.Endereco.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request['data'];
        
        $bairroNome = '';
        $bairroId = 0;
        
        $bairro = explode(":", $data['bairro']);
        if(isset($bairro[0]) && $bairro[0] == 'id'){
            $bairroId = $bairro[1];
        }else{
            $bairroNome = $data['bairro'];
        }
        
        $result = EnderecoDelivery::create([
            'cliente_id'=> $data['cliente_id'],
            'rua'       => $data['rua'],
            'numero'    => $data['numero'],
            
            'bairro'    => $bairroNome,
            'bairro_id' => $bairroId,
            
            'referencia'=> $data['referencia'],
            'latitude'  => $data['latitude'] ? substr($data['latitude'], 0, 10) : '',
            'longitude' => $data['longitude'] ? substr($data['longitude'], 0, 10) : ''
        ]);
        if($result) 
            echo json_encode($result);
        else 
            echo json_encode(false);
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
        $dados["bairro"] = EnderecoDelivery::find($id);
        return view('admin.Delivery.Endereco.Create', $dados);
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
        EnderecoDelivery::where("id", $id)->update($req);
        return redirect()->route("deliverybairro.index");
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
            $h = EnderecoDelivery::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
