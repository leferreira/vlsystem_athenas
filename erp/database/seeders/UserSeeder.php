<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
       User::Create([
                'name'      =>"Gerado pelo Sistema",
                'email'     =>"sistema@sistema.com.br",
                'password'  =>bcrypt("sistema"),
                'uuid'      =>Str::uuid() ,
                'telefone'  =>'989898989898',
                'eh_admin'  =>'S',
                'status_id' =>Config('constantes.status.ATIVO'),
                'empresa_id'=>1
            ]);
            
        
                  
        
        
    }
}
