<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactMessage;

class ListMessages extends Command
{
    protected $signature = 'messages:list {--limit=5}';
    protected $description = 'Lista los últimos mensajes de contacto';

    public function handle()
    {
        $limit = $this->option('limit');
        $messages = ContactMessage::latest()->limit($limit)->get();

        if ($messages->isEmpty()) {
            $this->info('No hay mensajes');
            return;
        }

        $headers = ['ID', 'Nombre', 'Email', 'Asunto', 'Creado'];
        $rows = $messages->map(fn($m) => [
            $m->id,
            $m->nombre,
            $m->email,
            substr($m->asunto, 0, 30) . (strlen($m->asunto) > 30 ? '...' : ''),
            $m->created_at->format('d/m/Y H:i')
        ]);

        $this->table($headers, $rows);
    }
}
