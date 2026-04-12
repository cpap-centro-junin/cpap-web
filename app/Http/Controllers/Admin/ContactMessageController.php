<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespuestaMensajeMail;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        // Manejar parámetro de items per page
        if ($request->has('perpage')) {
            $perpage = (int) $request->get('perpage');
            if (in_array($perpage, [10, 20, 50, 100])) {
                session(['pagination_perpage' => $perpage]);
            }
        }
        
        $perpage = session('pagination_perpage', 10);
        
        $query = ContactMessage::query();

        // Search by subject or message
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('asunto', 'like', "%{$buscar}%")
                  ->orWhere('mensaje', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        // Filter by read status
        if ($request->filled('estado')) {
            $query->where('leido', $request->estado === 'leido');
        }

        $messages = $query->latest()->paginate($perpage)->withQueryString();

        return view('admin.mensajes.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['leido' => true]);

        return view('admin.mensajes.show', compact('message'));
    }

    public function responder(Request $request, ContactMessage $message)
    {
        $request->validate([
            'respuesta' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
        ]);

        // Verificar que el mensaje tiene email válido
        if (!$message->email || !filter_var($message->email, FILTER_VALIDATE_EMAIL)) {
            \Log::error('ContactMessage sin email válido. ID: ' . $message->id . ', Email: ' . ($message->email ?? 'null'));
            return back()->withErrors('Error: El mensaje no tiene un correo electrónico válido guardado.');
        }

        $filePath = null;

        if ($request->hasFile('archivo')) {
            try {
                $file = $request->file('archivo');
                $dir = public_path('respuestas');
                
                // Crear directorio si no existe
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                
                $nombre = uniqid('respuesta_') . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $nombre);
                $filePath = 'public/respuestas/' . $nombre;
                
                \Log::info('Archivo guardado correctamente: ' . $filePath);
            } catch (\Exception $e) {
                \Log::error('Error al guardar archivo adjunto: ' . $e->getMessage());
                return back()->withErrors('Error al guardar el archivo adjunto');
            }
        }

        $message->update([
            'respuesta' => $request->respuesta,
            'archivo_respuesta' => $filePath
        ]);

        try {
            $destinoEmail = $message->email;
            \Log::info('=== ENVIANDO EMAIL DE RESPUESTA ===');
            \Log::info('Destinatario: ' . $destinoEmail);
            \Log::info('Nombre del contacto: ' . $message->nombre);
            \Log::info('Archivo adjunto: ' . ($filePath ?? 'ninguno'));
            
            \Mail::to($destinoEmail)
                ->send(new RespuestaMensajeMail(
                    nombre: $message->nombre,
                    respuesta: $message->respuesta,
                    archivo_respuesta: $message->archivo_respuesta
                ));
            
            \Log::info('✓ Email enviado correctamente a: ' . $destinoEmail);
        } catch (\Exception $e) {
            \Log::error('✗ Error al enviar email: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('warning', 'Respuesta guardada pero error al enviar email: ' . $e->getMessage());
        }

        return back()->with('success', 'Respuesta enviada correctamente a ' . $message->email. '.');
    }
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Mensaje eliminado correctamente.');
    }

    public function bulkToggle(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:contact_messages,id',
            'action' => 'required|in:eliminar'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $count = count($ids);

        switch($action) {
            case 'eliminar':
                ContactMessage::whereIn('id', $ids)->delete();
                $message = "{$count} mensaje(s) eliminado(s) correctamente.";
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

}
