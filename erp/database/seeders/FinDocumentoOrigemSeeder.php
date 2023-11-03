<?php

namespace Database\Seeders;

use App\Models\FinDocumentoOrigem;
use Illuminate\Database\Seeder;

class FinDocumentoOrigemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinDocumentoOrigem::firstOrCreate([
            'codigo' => '55',
            'sigla' => 'NFE',
            'documento_origem' => 'Nota Fiscal Eletrônica'
        ]);
    }
}

