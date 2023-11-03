<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\FuncionamentoDelivery;

class FuncionamentoDeliveryController extends Controller
{
    	
    public function index()
    {        
        $dados["lista"]             = FuncionamentoDelivery::all();
        $dados["dias"]              = $this->verificaDiasInserido();
        $dados["js_controle_horario"] = true;
        
        return view("Admin.Delivery.Funcionamento.Index", $dados);
    }

    private function verificaDiasInserido(){
		
		$temp = [];
		$dias = FuncionamentoDelivery::dias();
		foreach($dias as $d){
			$v = FuncionamentoDelivery::where('dia', $d)->first();
			if(!$v){
				array_push($temp, $d);
			}
		}
		return $temp;
	}
    public function create()
    {
        return view("Admin.Categoria.Create");
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
        if($request->id == 0){
            $result = FuncionamentoDelivery::create([
                'dia' => $request->dia,
                'ativo' => true,
                'inicio_expediente' => $request->inicio,
                'fim_expediente' => $request->fim
            ]);
        }else{
            $f = FuncionamentoDelivery::
            where('id', $request->id)
            ->first();
            
            $f->inicio_expediente = $request->inicio;
            $f->fim_expediente = $request->fim;
            $result = $f->save();
        }
        
        if($result){
            session()->flash('color', 'green');
            session()->flash("message", "Configurado com sucesso!");
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro ao configurar!');
        }
        return redirect()->route('admin.funcionamentodelivery.index');
    }

    private function _validate(Request $request){
		$rules = [
			'inicio' => 'required|min:5',
			'fim' => 'required|min:5',
			
		];

		$messages = [
			'inicio.required' => 'O campo Inicio é obrigatório.',
			'fim.required' => 'O campo Fim é obrigatório.',
			'inicio.min' => 'Campo inválido.',
			'fim.min' => 'Campo inválido.',


		];
		$this->validate($request, $rules, $messages);
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
        $dados["categoria"] = Categoria::find($id);
        return view('admin.Categoria.Create', $dados);
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
        Categoria::where("id", $id)->update($req);
        return redirect()->route("categoria.index");
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
            $h = Categoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
