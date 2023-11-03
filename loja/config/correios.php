<?php
return [
    'servico' => [
        'SEDEX'             => "04014", // Utilizada para indicar que um recurso/modelo está ATIVO
        'SEDEX_12'          => "04782", // Utilizada para indicar que um recurso/modelo Está em Digitacao
        'SEDEX_10'          => "04790", // Utilizada para indicar que um recurso/modelo é novo
        'SEDEX_HOJE'        => "04804", // Utilizada para indicar que um recurso/modelo é novo
        'PAC'               => "04510", // Indica que algo foi cancelado automaticamente ou via administrativa
          
    ],
    'formato' => [
        'CAIXA_PACOTE'      => 1, // Utilizada para indicar que um recurso/modelo está ATIVO
        'ROLO_PRISMA'       => 2, // Utilizada para indicar que um recurso/modelo Está em Digitacao
        'ENVELOPE'          => 3, // Utilizada para indicar que um recurso/modelo é novo
       ],
    

];
