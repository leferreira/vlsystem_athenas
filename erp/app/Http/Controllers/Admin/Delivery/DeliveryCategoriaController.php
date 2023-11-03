<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProdutoDelivery;
use Illuminate\Http\Request;


class DeliveryCategoriaController extends Controller
{
    public function __construct(){
    $this->middleware(function ($request, $next) {
      $value = session('user_logged');
      if(!$value){
        return redirect("/login");
      }
      return $next($request);
    });
    }
    
    public function index()
    {
        $dados["categorias"] = CategoriaProdutoDelivery::all();
        return view("Admin.Delivery.Categoria.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Delivery.Categoria.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $category = new CategoriaProdutoDelivery();        
        $this->_validate($request);        
        $file = $request->file('file');
        
        $extensao   = $file->getClientOriginalExtension();
        $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
        $request->merge([ 'path' => $nomeImagem ]);        
        $upload = $file->move(public_path('storage/upload/imagens_categorias'), $nomeImagem);
        
        if(!$upload){
            session()->flash('mensagem_erro', 'Erro ao realizar upload da imagem.');
        }else{
            $result = $category->create($request->all());
            if($result){
                
                session()->flash("mensagem_sucesso", "Categoria cadastrada com sucesso.");
            }else{
                
                session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
            }
        }              
        
        return redirect()->route('deliverycategoria.index');
    }

    private function _validate(Request $request, $fileExist = true){
        $rules = [
            'nome' => 'required|max:30',
            'descricao' => 'required|max:120',
            'file' => $fileExist ? 'required' : ''
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '50 caracteres maximos permitidos.',
            'descricao.required' => 'O campo descricao é obrigatório.',
            'descricao.max' => '120 caracteres maximos permitidos.',
            'file.required' => 'O campo imagem é obrigatório.'
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
        $dados["categoria"] = CategoriaProdutoDelivery::find($id);
        return view('admin.Delivery.Categoria.Create', $dados);
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
        CategoriaProdutoDelivery::where("id", $id)->update($req);
        return redirect()->route("deliverycategoria.index");
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
            $h = CategoriaProdutoDelivery::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
