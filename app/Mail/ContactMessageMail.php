<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;

class ContactMessageMail extends Mailable
{
    public $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    public function build()
    {
        Log::info('Enviando email del formulario de contacto');
        Log::info('De: ' . $this->messageData->email);
        Log::info('Para: contacto@cpapregioncentro.com');
        Log::info('Asunto: ' . $this->messageData->asunto);
        
        return $this->subject('Nuevo mensaje - CPAP Región Centro')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->view('emails.contact-message');
    }
}
