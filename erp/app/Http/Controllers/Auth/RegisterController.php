<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CertificadoDigital;
use App\Models\Emitente;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\PlanoPreco;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {    
           
        
        $planopreco = PlanoPreco::find($data["plano_preco_id"]);
        // Cria uma empresa
        $empresa = Empresa::Create([
            "plano_preco_id"    =>$planopreco->id,
            "razao_social"      =>$data["empresa"],
            "fone"              =>tira_mascara($data["celular"]),
            "email"             =>$data["email"],
            "pasta"             =>Str::uuid() ,
            "uuid"              =>Str::uuid() ,
            "forma_pagto_id"    =>config('constantes.status.DEPOSITO_BANCARIO'),
            "data_aquisicao"    =>hoje(),
            "valor_contrato"    =>$planopreco->preco,
            "configurado"       =>'N',
            "data_vencimento"   =>somarData(hoje(),15),
            "data_inicial_vencimento"=>hoje(),
            "valor_recorrente"  =>$planopreco->preco,
            "dias_bloqueia"     =>0,
            "status_id"         =>config("constantes.status.PROSPECTO"),
            "status_plano_id"   =>config("constantes.status.DEMO")
        ]);       
       
        
        //Criando a tabela de parâmetros da empresa
        $parametro = new \stdClass();
        $parametro->empresa_id  = $empresa->id;
        Parametro::Create(objToArray($parametro));
        
        //Criando a tabela de emitente da empresa
        
        $emitente                     =  new \stdClass();
        $emitente->empresa_id         = $empresa->id;
        $emit                         = Emitente::Create(objToArray($emitente));
        
        $certificado                  = new \stdClass();
        $certificado->empresa_id      = $empresa->id;
        $certificado->emitente_id     = $emit->id;
        CertificadoDigital::Create(objToArray($certificado));
        
        // Cria um usuario       
        
        return User::create([
            'name'          => $data['name'],
            'empresa_id'    => $empresa->id,
            'uuid'          => Str::uuid(),
            'telefone'      => $data['celular'],
            'email'         => $data['email'],
            'eh_admin'      => "S",
            'status_id'     => config("constantes.status.ATIVO"),
            'password'      => Hash::make($data['password']),
        ]);
      
    }
    
    protected function registered(Request $request, $user)
    {
       /* Mail::to($user->email)->send(new UserRegisteredEmail($user));
        
        if($user->role == 'ROLE_OWNER')
            return redirect()->route('admin.stores.index');
            
            if($user->role == 'ROLE_USER' && session()->has('cart')) {
                return redirect()->route('checkout.index');
            } else {
                return redirect()->route('home');
            }
            
            return null;*/
    }
}
