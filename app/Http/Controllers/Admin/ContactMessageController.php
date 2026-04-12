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
            'respuesta' => 'required',
            'archivo' => 'nullable|file|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $dir = public_path('respuestas');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('respuesta_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $filePath = 'public/respuestas/' . $nombre;
        }

        $message->update([
            'respuesta' => $request->respuesta,
            'archivo_respuesta' => $filePath
        ]);

        Mail::to($message->email)
            ->send(new RespuestaMensajeMail($message));

        return back()->with('success', 'Respuesta enviada correctamente.');
    }
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Mensaje eliminado correctamente.');
    }

    public function descargarRespuesta(ContactMessage $message)
    {
        if (!$message->archivo_respuesta) {
            abort(404, 'El archivo no está disponible.');
        }

        // Stripear public/ prefix de la ruta en BD antes de usar public_path()
        $ruta = $message->archivo_respuesta;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7);
        }

        $filePath = public_path($ruta);
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no se encontró.');
        }

        $filename = basename($filePath);
        return response()->download($filePath, $filename);
    }

}
