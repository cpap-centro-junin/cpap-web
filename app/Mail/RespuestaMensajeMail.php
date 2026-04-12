<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;

class RespuestaMensajeMail extends Mailable
{
    public $nombre;
    public $respuesta;
    public $archivo_respuesta;

    public function __construct(
        string $nombre,
        string $respuesta,
        ?string $archivo_respuesta = null
    ) {
        $this->nombre = $nombre;
        $this->respuesta = $respuesta;
        $this->archivo_respuesta = $archivo_respuesta;
    }

    public function build()
    {
        $mail = $this->subject('Respuesta - CPAP Región Centro')
                     ->from(config('mail.from.address'), config('mail.from.name'))
                     ->view('emails.respuesta-mensaje');

        if ($this->archivo_respuesta) {
            // Stripear public/ prefix de la ruta en BD
            $ruta = $this->archivo_respuesta;
            if (str_starts_with($ruta, 'public/')) {
                $ruta = substr($ruta, 7);
            }
            
            $filePath = public_path($ruta);
            if (file_exists($filePath)) {
                $filename = basename($filePath);
                $mail->attach($filePath, ['as' => $filename]);
                Log::info('Email attachment added: ' . $filename);
            } else {
                Log::warning('Email attachment not found: ' . $filePath);
            }
        }

        return $mail;
    }
}
