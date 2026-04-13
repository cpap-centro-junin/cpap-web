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
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        
        $mail = $this->subject('Respuesta - CPAP Región Centro')
                     ->from($fromAddress, $fromName)
                     ->replyTo($fromAddress, $fromName)
                     ->mailer('smtp')
                     ->view('emails.respuesta-mensaje')
                     ->with([
                         'nombre' => $this->nombre,
                         'respuesta' => $this->respuesta,
                     ]);

        // Agregar headers MIME explícitos para compatibilidad con Outlook
        $mail->withSymfonyMessage(function (\Symfony\Component\Mime\Email $message) {
            $message->getHeaders()
                ->addTextHeader('X-Priority', '3')
                ->addTextHeader('X-Mailer', 'CPAP Sistema Institucional')
                ->addTextHeader('X-MSMail-Priority', 'Normal');
        });

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
