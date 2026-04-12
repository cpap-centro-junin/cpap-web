<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespuestaMensajeMail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Envía un email de prueba';

    public function handle()
    {
        $email = $this->argument('email');
        $this->line("Intentando enviar email de prueba a: {$email}");

        try {
            Mail::to($email)->send(new RespuestaMensajeMail(
                nombre: 'Test User',
                respuesta: 'Este es un email de prueba del sistema CPAP',
                archivo_respuesta: null
            ));
            
            $this->info("✓ Email enviado correctamente a {$email}");
            return 0;
        } catch (\Exception $e) {
            $this->error("✗ Error al enviar email: " . $e->getMessage());
            \Log::error('Test email error: ' . $e->getMessage());
            return 1;
        }
    }
}
