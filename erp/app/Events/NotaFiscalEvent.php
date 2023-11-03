<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Venda;
use App\Models\NaturezaOperacao;
use App\Models\Tributacao;

class NotaFiscalEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $venda;
    public $natureza;
    public $tributacao;
    public function __construct(Venda $venda, NaturezaOperacao $natureza, Tributacao $tributacao)
    {
        $this->venda        = $venda;
        $this->natureza     = $natureza;
        $this->tributacao   = $tributacao;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
