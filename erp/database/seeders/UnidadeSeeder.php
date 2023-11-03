<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidade::firstOrCreate(['unidade'    => "UNID",  'abrev'  => "UNID"  ]);
        Unidade::firstOrCreate(['unidade'    => "KG", 'abrev'  => "KG"  ]);
        Unidade::firstOrCreate(['unidade'    => "SACO", 'abrev'  => "SACO"  ]);
        Unidade::firstOrCreate(['unidade'    => "AMPOLA", 'abrev'  => "AMPOLA"  ]);
        Unidade::firstOrCreate(['unidade'    => "BALDE", 'abrev'  => "BALDE"  ]);
        Unidade::firstOrCreate(['unidade'    => "BANDEJ", 'abrev'  => "BANDEJ"  ]);
        Unidade::firstOrCreate(['unidade'    => "BARRA", 'abrev'  => "BARRA"  ]);
        Unidade::firstOrCreate(['unidade'    => "BISNAG", 'abrev'  => "BISNAG"  ]);
        Unidade::firstOrCreate(['unidade'    => "BLOCO", 'abrev'  => "BLOCO"  ]);
        Unidade::firstOrCreate(['unidade'    => "BOBINA", 'abrev'  => "BOBINA"  ]);
        Unidade::firstOrCreate(['unidade'    => "BOMB", 'abrev'  => "BOMB"  ]);
        Unidade::firstOrCreate(['unidade'    => "CAPS", 'abrev'  => "CAPS"  ]);
        Unidade::firstOrCreate(['unidade'    => "CART", 'abrev'  => "CART"  ]);
        Unidade::firstOrCreate(['unidade'    => "CENTO", 'abrev'  => "CENTO"  ]);
        Unidade::firstOrCreate(['unidade'    => "CJ", 'abrev'  => "CJ"  ]);
        Unidade::firstOrCreate(['unidade'    => "CM", 'abrev'  => "CM"  ]);
        Unidade::firstOrCreate(['unidade'    => "CM2", 'abrev'  => "CM2"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX", 'abrev'  => "CX"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX2", 'abrev'  => "CX2"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX3", 'abrev'  => "CX3"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX5", 'abrev'  => "CX5"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX10", 'abrev'  => "CX10"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX15", 'abrev'  => "CX15"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX20", 'abrev'  => "CX20"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX25", 'abrev'  => "CX25"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX50", 'abrev'  => "CX50"  ]);
        Unidade::firstOrCreate(['unidade'    => "CX100", 'abrev'  => "CX100"  ]);
        Unidade::firstOrCreate(['unidade'    => "DISP", 'abrev'  => "DISP"  ]);
        Unidade::firstOrCreate(['unidade'    => "DUZIA", 'abrev'  => "DUZIA"  ]);
        Unidade::firstOrCreate(['unidade'    => "EMBAL", 'abrev'  => "EMBAL"  ]);
        Unidade::firstOrCreate(['unidade'    => "FARDO", 'abrev'  => "FARDO"  ]);
        Unidade::firstOrCreate(['unidade'    => "FOLHA", 'abrev'  => "FOLHA"  ]);
        Unidade::firstOrCreate(['unidade'    => "FRASCO", 'abrev'  => "FRASCO"  ]);
        Unidade::firstOrCreate(['unidade'    => "GALAO", 'abrev'  => "GALAO"  ]);
        Unidade::firstOrCreate(['unidade'    => "GF", 'abrev'  => "GF"  ]);
        Unidade::firstOrCreate(['unidade'    => "GRAMAS", 'abrev'  => "GRAMAS"  ]);
        Unidade::firstOrCreate(['unidade'    => "JOGO", 'abrev'  => "JOGO"  ]);        
        Unidade::firstOrCreate(['unidade'    => "KIT", 'abrev'  => "KIT"  ]);
        Unidade::firstOrCreate(['unidade'    => "LATA", 'abrev'  => "LATA"  ]);
        Unidade::firstOrCreate(['unidade'    => "LITRO", 'abrev'  => "LITRO"  ]);
        Unidade::firstOrCreate(['unidade'    => "M", 'abrev'  => "M"  ]);
        Unidade::firstOrCreate(['unidade'    => "M2", 'abrev'  => "M2"  ]);
        Unidade::firstOrCreate(['unidade'    => "M3", 'abrev'  => "M3"  ]);
        Unidade::firstOrCreate(['unidade'    => "MILHEI", 'abrev'  => "MILHEI"  ]);
        Unidade::firstOrCreate(['unidade'    => "ML", 'abrev'  => "ML"  ]);
        Unidade::firstOrCreate(['unidade'    => "MWH", 'abrev'  => "MWH"  ]);
        Unidade::firstOrCreate(['unidade'    => "PACOTE", 'abrev'  => "PACOTE"  ]);
        Unidade::firstOrCreate(['unidade'    => "PALETE", 'abrev'  => "PALETE"  ]);
        Unidade::firstOrCreate(['unidade'    => "PARES", 'abrev'  => "PARES"  ]);
        Unidade::firstOrCreate(['unidade'    => "PC", 'abrev'  => "PC"  ]);
        Unidade::firstOrCreate(['unidade'    => "POTE", 'abrev'  => "POTE"  ]);
        Unidade::firstOrCreate(['unidade'    => "RESMA", 'abrev'  => "RESMA"  ]);
        Unidade::firstOrCreate(['unidade'    => "ROLO", 'abrev'  => "ROLO"  ]);
        
        
    }
}
