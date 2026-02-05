<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
}
