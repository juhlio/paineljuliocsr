<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequisicaoRejeitada extends Mailable
{
    use Queueable, SerializesModels;

    public $obs;
    public $id;
    public $requisicao;
    public $cliente;
    public $produtos;
    public $solicitante;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obs, $id, $requisicao, $cliente, $produtos, $solicitante)
    {
        $this->obs = $obs;
        $this->id = $id;
        $this->requisicao = $requisicao;
        $this->cliente = $cliente;
        $this->produtos = $produtos;
        $this->solicitante = $solicitante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.requisicaorejeitada')
            ->subject('A Requisição ' . $this->id . ' foi rejeitada');
    }
}
