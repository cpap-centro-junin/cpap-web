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
            // Stripear public/ prefix de la ruta en BD
            $ruta = $this->messageData->archivo_respuesta;
            if (str_starts_with($ruta, 'public/')) {
                $ruta = substr($ruta, 7);
            }
            
            $filePath = public_path($ruta);
            if (file_exists($filePath)) {
                $mail->attach($filePath);
            }
        }

        return $mail;
    }
}
