<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactMessageMail;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto.index');
    }

    public function send(Request $request)
    {
        // --- CAPA 1: Honeypot (bots llenan campos ocultos) ---
        if ($request->filled('website')) {
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente.',
            ]);
        }

        // --- CAPA 2: Tiempo mínimo (bots envían instantáneamente) ---
        $timestamp = (int) $request->input('_timestamp', 0);
        $elapsed = time() - $timestamp;
        if ($timestamp === 0 || $elapsed < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, completa el formulario con calma e intenta de nuevo.',
            ], 422);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string|min:10',
            'recaptcha_token' => 'required|string',
        ]);

        // --- CAPA 3: Bloquear dominios de email desechables/spam ---
        $emailDomain = strtolower(substr(strrchr($request->email, '@'), 1));
        $blockedDomains = [
            'checkyourform.xyz', 'mailinator.com', 'guerrillamail.com',
            'tempmail.com', 'throwaway.email', 'yopmail.com', 'sharklasers.com',
            'guerrillamailblock.com', 'grr.la', 'dispostable.com', 'tempail.com',
            'fakeinbox.com', 'trashmail.com', 'maildrop.cc', 'getairmail.com',
        ];
        if (in_array($emailDomain, $blockedDomains)) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, utiliza un correo electrónico válido.',
            ], 422);
        }

        // --- CAPA 4: reCAPTCHA v2 (checkbox) ---
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->recaptcha_token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!($result['success'] ?? false)) {
            return response()->json([
                'success' => false,
                'message' => 'Verificación de seguridad fallida. Marca la casilla "No soy un robot".',
            ], 422);
        }

        $message = ContactMessage::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
        ]);

        // Enviar correo real
        Mail::to('juancarloschmm@gmail.com')
            ->send(new ContactMessageMail($message));

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente.'
        ]);
    }
}
?>