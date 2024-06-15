<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailObsReqCompra extends Mailable
{
    use Queueable, SerializesModels;

    public $obs;
    public $reqcompra;
    public $dadosSolicitante;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reqcompra, $obs, $dadosSolicitante)
    {
        $this->obs = $obs;
        $this->reqcompra = $reqcompra;
        $this->dadosSolicitante = $dadosSolicitante;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.obsreqcompra')
            ->subject('Nova Observação na Requisição nº ' . $this->reqcompra);
    }
}
