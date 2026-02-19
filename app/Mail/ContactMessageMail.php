<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactMessageMail extends Mailable
{
    public $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    public function build()
    {
        return $this->subject('Nuevo mensaje - CPAP Región Centro')
            ->view('emails.contact-message');
    }
}
