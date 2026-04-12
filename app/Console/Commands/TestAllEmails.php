<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
use App\Mail\RespuestaMensajeMail;
use App\Models\ContactMessage;

class TestAllEmails extends Command
{
    protected $signature = 'test:all-emails';
    protected $description = 'Prueba envío de ambos tipos de email';

    public function handle()
    {
        // Crear un mensaje de prueba
        $testMessage = new \stdClass();
        $testMessage->id = 999;
        $testMessage->nombre = 'Juan Carlos Test';
        $testMessage->email = 'test@ejemplo.com';
        $testMessage->asunto = 'Test del sistema';
        $testMessage->mensaje = 'Este es un mensaje de prueba';

        $this->info('═══════════════════════════════════════');
        $this->info('Probando EMAIL DEL FORMULARIO DE CONTACTO');
        $this->info('═══════════════════════════════════════');
        $this->line('De: ' . config('mail.from.address'));
        $this->line('Para: contacto@cpapregioncentro.com');
        
        try {
            Mail::to('contacto@cpapregioncentro.com')
                ->send(new ContactMessageMail($testMessage));
            $this->info('✓ Email del formulario enviado correctamente');
        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
        }

        $this->line('');
        $this->info('═══════════════════════════════════════');
        $this->info('Probando EMAIL DE RESPUESTA');
        $this->info('═══════════════════════════════════════');
        $this->line('De: ' . config('mail.from.address'));
        $this->line('Para: test@ejemplo.com');

        try {
            Mail::to('test@ejemplo.com')
                ->send(new RespuestaMensajeMail(
                    nombre: 'Juan Carlos Test',
                    respuesta: 'Esta es una respuesta de prueba del sistema CPAP.',
                    archivo_respuesta: null
                ));
            $this->info('✓ Email de respuesta enviado correctamente');
        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
        }

        $this->line('');
        $this->info('═══════════════════════════════════════');
        $this->info('Configuración actual:');
        $this->info('═══════════════════════════════════════');
        $this->table(['Parámetro', 'Valor'], [
            ['Mailer', config('mail.default')],
            ['Host', config('mail.mailers.smtp.host')],
            ['Port', config('mail.mailers.smtp.port')],
            ['Username', config('mail.mailers.smtp.username')],
            ['Encryption', config('mail.mailers.smtp.encryption')],
            ['From Address', config('mail.from.address')],
            ['From Name', config('mail.from.name')],
        ]);
    }
}
