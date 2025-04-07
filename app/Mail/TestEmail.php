<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nombre ="";
    protected $objetivo ="";
    protected $descripcion ="";


    public function __construct($nombre,$objetivo,$descripcion)
    {
        $this->nombre = $nombre;
        $this->objetivo = $objetivo;
        $this->descripcion = $descripcion;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notificación SIIBien',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
           view: 'mails.solicitud',            
           with:[
            "nombre" => $this->nombre,
            "objetivo" => $this->objetivo,
            "descripcion" => $this->descripcion
           ]
        );     
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
