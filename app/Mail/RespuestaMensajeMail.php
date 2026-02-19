<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespuestaMensajeMail extends Mailable
{
    use SerializesModels;

    public $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    public function build()
    {
        $mail = $this->subject('Respuesta - CPAP Región Centro')
                     ->view('emails.respuesta-mensaje');

        if ($this->messageData->archivo_respuesta) {
            $mail->attach(
                storage_path('app/public/' . $this->messageData->archivo_respuesta)
            );
        }

        return $mail;
    }
}
