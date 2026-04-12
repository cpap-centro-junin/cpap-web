<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactMessage;
use App\Mail\RespuestaMensajeMail;
use Illuminate\Support\Facades\Mail;

class TestEmailResponse extends Command
{
    protected $signature = 'test:response {messageId}';
    protected $description = 'Prueba enviar respuesta a un mensaje de contacto específico';

    public function handle()
    {
        $messageId = $this->argument('messageId');
        $message = ContactMessage::find($messageId);

        if (!$message) {
            $this->error("Mensaje no encontrado: {$messageId}");
            return 1;
        }

        $this->info("Información del mensaje:");
        $this->table(['Campo', 'Valor'], [
            ['ID', $message->id],
            ['Nombre', $message->nombre],
            ['Email', $message->email],
            ['Asunto', $message->asunto],
        ]);

        if (!$message->email) {
            $this->error("El mensaje no tiene email");
            return 1;
        }

        $this->line("\nIntentando enviar respuesta de prueba a: {$message->email}");

        try {
            Mail::to($message->email)->send(new RespuestaMensajeMail(
                nombre: $message->nombre,
                respuesta: '❗ ESTE ES UN EMAIL DE PRUEBA ❗\n\nSi recibiste este email, significa que el sistema está funcionando correctamente y tu email fue guardado correctamente en la base de datos.' ,
                archivo_respuesta: null
            ));

            $this->info("✓ Email enviado correctamente a: {$message->email}");
            return 0;
        } catch (\Exception $e) {
            $this->error("✗ Error: " . $e->getMessage());
            return 1;
        }
    }
}
