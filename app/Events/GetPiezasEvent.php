<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetPiezasEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $idPieza;
    public $left;
    public $top;
    public $idJuego;
    public $idParticipante;

    
    public function __construct($idPieza,$left,$top,$idJuego,$idParticipante)
    {
        $this->idPieza = $idPieza;
        $this->left = $left;
        $this->top = $top;
        $this->idJuego = $idJuego;
        $this->idParticipante = $idParticipante;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('PiezasEventTriggered');
    }
}
