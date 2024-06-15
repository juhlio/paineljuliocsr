<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmaRequisicao extends Mailable
{
    use Queueable, SerializesModels;

    public $nomeSolicitante;
    public $nomeCliente;
    public $nomeTipo;
    public $produtos;
    public $idRequisicao;

    /**
     * Create a new message instance.
     *
     * @param string $nomeSolicitante
     * @param string $nomeCliente
     * @param string $nomeTipo
     */
    public function __construct($nomeSolicitante, $nomeCliente, $nomeTipo, $produtos, $idRequisicao)
    {
        $this->nomeSolicitante = $nomeSolicitante;
        $this->nomeCliente = $nomeCliente;
        $this->nomeTipo = $nomeTipo;
        $this->produtos = $produtos;
        $this->idRequisicao = $idRequisicao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirmarequisicao')
            ->subject('Requisição ' . $this->idRequisicao . ' criada');
    }
}
