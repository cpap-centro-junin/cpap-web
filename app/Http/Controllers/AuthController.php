<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;



class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas'
        ]);
    }

    public function showRegister(Request $request)
{
    $token = $request->token;

    if (!$token) {
        abort(403, 'No tienes permiso para registrarte.');
    }

    $inv = \App\Models\Invitaciones::where('token', $token)->where('usado', false)->first();

    if (!$inv) {
        abort(403, 'Token inválido o ya usado.');
    }

    return view('auth.register', [
        'token' => $token,
        'inv' => $inv
    ]);

}


    public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'token' => 'required'
    ]);

    $inv = \App\Models\Invitaciones::where('token', $request->token)
        ->where('usado', false)
        ->first();

    if (!$inv) {
        return back()->withErrors(['token' => 'Token inválido o ya usado']);
    }

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $inv->email,
        'password' => bcrypt($request->password),
        'role' => 'directivo'
    ]);

    $inv->update(['usado' => true]);

    auth()->login($user);

    return redirect('/admin/dashboard');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }



    //Cambiar contraseña//
    public function showForgot(){
        return view('auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/reset-password/'.$token.'?email='.$request->email);

        Mail::raw("Recupera tu contraseña aquí: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Recuperación de contraseña - CPAP');
        });

        return back()->with('status', 'Te enviamos un enlace de recuperación.');
    }



    public function showResetForm($token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Token inválido o expirado']);
        }

        User::where('email', $request->email)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('reset_success', true);
    }


}


