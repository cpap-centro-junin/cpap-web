<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactMessage;
use App\Mail\RespuestaMensajeMail;
use Illuminate\Support\Facades\Mail;

class TestOutlookEmail extends Command
{
    protected $signature = 'test:outlook {messageId}';
    protected $description = 'Prueba enviar respuesta a un email Outlook para verificar compatibilidad';

    public function handle()
    {
        $messageId = $this->argument('messageId');
        $message = ContactMessage::find($messageId);

        if (!$message) {
            $this->error("Mensaje no encontrado: {$messageId}");
            return 1;
        }

        $this->info("═══════════════════════════════════════════");
        $this->info("PRUEBA DE EMAIL CON CORRECCIÓN OUTLOOK");
        $this->info("═══════════════════════════════════════════");
        
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

        if (!filter_var($message->email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Email inválido: {$message->email}");
            return 1;
        }

        $this->line("\n📧 Enviando respuesta de prueba...\n");

        try {
            Mail::to($message->email)->send(new RespuestaMensajeMail(
                nombre: $message->nombre,
                respuesta: "✅ PRUEBA DE COMPATIBILIDAD OUTLOOK\n\n" .
                           "Este email ha sido enviado con las siguientes mejoras:\n" .
                           "• Headers MIME explícitos configurados\n" .
                           "• Escapado correcto de caracteres especiales\n" .
                           "• Formato de texto con soporte para saltos de línea\n" .
                           "• Compatibilidad mejorada con Outlook\n\n" .
                           "Si recibes este mensaje correctamente, el problema se ha resuelto.",
                archivo_respuesta: null
            ));

            $this->info("✅ Email de prueba enviado correctamente a: {$message->email}");
            $this->line("\n💡 Revisa tu bandeja de entrada (incluye spam/junk)");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Error al enviar: " . $e->getMessage());
            \Log::error('Test outlook error: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
