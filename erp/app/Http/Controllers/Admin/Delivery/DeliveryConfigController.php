<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\DeliveryConfig;
use App\Models\Motoboy;
use Illuminate\Http\Request;

class DeliveryConfigController extends Controller
{
        
    
    public function index()
    {
        $dados["deliveryconfig"] = DeliveryConfig::first();
        return view("Admin.Delivery.Config", $dados);
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
        
        $result = false;
        if($request->id == 0){
            $result = DeliveryConfig::create([
                'link_face'             => $request->link_face ?? '',
                'link_twiteer'          => $request->link_twiteer ?? '',
                'link_google'           => $request->link_google ?? '',
                'link_instagram'        => $request->link_instagram ?? '',
                'telefone'              => sanitizeString($request->telefone),
                'endereco'              => sanitizeString($request->endereco),
                'tempo_medio_entrega'   => sanitizeString($request->tempo_medio_entrega),
                'valor_entrega'         => str_replace(",", ".", $request->valor_entrega),
                'tempo_maximo_cancelamento' => $request->tempo_maximo_cancelamento,
                'nome_exibicao_web'     => $request->nome_exibicao_web,
                'latitude'              => $request->latitude,
                'longitude'             => $request->longitude,
                'politica_privacidade'  => $request->politica_privacidade ?? '',
                'entrega_gratis_ate'    => $request->entrega_gratis_ate ?? 0,
                'valor_km'              => $request->valor_km ? str_replace(",", ".", $request->valor_km) : 0,
                'maximo_km_entrega'     => $request->maximo_km_entrega ? true : false,
                'maximo_adicionais'     => $request->maximo_adicionais,
                'maximo_adicionais_pizza' => $request->maximo_adicionais_pizza
            ]);
        }else{
            $config = DeliveryConfig::
            first();
            
            $config->link_face      = $request->link_face ?? '';
            $config->link_twiteer   = $request->link_twiteer ?? '';
            $config->link_google    = $request->link_google ?? '';
            $config->link_instagram = $request->link_instagram ?? '';
            $config->telefone       = sanitizeString($request->telefone);
            $config->endereco       = sanitizeString($request->endereco);
            $config->tempo_medio_entrega = sanitizeString($request->tempo_medio_entrega);
            $config->valor_entrega  = str_replace(",", ".", $request->valor_entrega);
            $config->tempo_maximo_cancelamento = $request->tempo_maximo_cancelamento;
            $config->nome_exibicao_web = $request->nome_exibicao_web;
            $config->latitude       = $request->latitude;
            $config->longitude      = $request->longitude;
            $config->politica_privacidade = $request->politica_privacidade ?? '';
            $config->entrega_gratis_ate = $request->entrega_gratis_ate ?? 0;
            $config->valor_km       = $request->valor_km ?? 0;
            $config->maximo_km_entrega = $request->maximo_km_entrega ?? 0;
            $config->maximo_adicionais = $request->maximo_adicionais;
            $config->maximo_adicionais_pizza = $request->maximo_adicionais_pizza;
            
            $result = $config->save();
        }
        
        if($request->hasFile('file')){
            //unlink anterior
            $file       = $request->file('file');
            $nomeImagem = "logo.png";
            $upload = $file->move(public_path('storage/upload/images'), $nomeImagem);
        }
        
        if($result){
            session()->flash("mensagem_sucesso", "Configurado com sucesso!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao configurar!');
        }
        
        return redirect()->route('deliveryconfig.create');
    }
    
    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'link_face' => 'max:255',
            'link_twiteer' => 'max:255',
            'link_google' => 'max:255',
            'link_instagram' => 'max:255',
            'telefone' => 'required|max:20',
            'endereco' => 'required|max:80',
            'tempo_medio_entrega' => 'required|max:10',
            'tempo_maximo_cancelamento' => 'required',
            'valor_entrega' => 'required',
            'nome_exibicao_web' => 'required|max:30',
            'latitude' => 'required|max:10',
            'longitude' => 'required|max:10',
            'politica_privacidade' => 'max:400',
            'maximo_adicionais' => 'required',
            'maximo_adicionais_pizza' => 'required'
        ];
        
        $messages = [
            'link_face.max' => '255 caracteres maximos permitidos.',
            'link_twiteer.max' => '255 caracteres maximos permitidos.',
            'link_google.max' => '255 caracteres maximos permitidos.',
            'link_instagram.max' => '255 caracteres maximos permitidos.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'telefone.max' => '20 caracteres maximos permitidos.',
            'endereco.required' => 'O campo endereço é obrigatório.',
            'endereco.max' => '90 caracteres maximos permitidos.',
            'tempo_medio_entrega.required' => 'O campo Tempo Medio de Entrega é obrigatório.',
            'tempo_maximo_cancelamento.required' => 'O campo Tempo Maximo de Cancelamento é obrigatório.',
            'tempo_medio_entrega.max' => '10 caracteres maximos permitidos.',
            'valor_entrega.required' => 'O campo Valor de Entrega é obrigatório.',
            'nome_exibicao_web.required' => 'O campo Nome Exibição é obrigatório.',
            'nome_exibicao_web.max' => '30 caracteres maximos permitidos.',
            'latitude.required' => 'O campo Latitude é obrigatório.',
            'latitude.max' => '10 caracteres maximos permitidos.',
            'longitude.required' => 'O campo Longitude é obrigatório.',
            'longitude.max' => '10 caracteres maximos permitidos.',
            'politica_privacidade.max' => '400 caracteres maximos permitidos.',
            
            'maximo_adicionais.required' => 'Campo obrigatório.',
            'maximo_adicionais_pizza.required' => 'Campo obrigatório.',
            
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
