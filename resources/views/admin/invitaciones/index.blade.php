@extends('layouts.admin')

@section('title', 'Invitaciones')

@section('content')

<h1>Invitaciones</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('admin.invitaciones.enviar') }}" method="POST">
    @csrf
    <label>Correo del invitado:</label>
    <input type="email" name="email" required>
    <button type="submit">Enviar invitación</button>
</form>

<hr>

<h2>Invitaciones enviadas</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Email</th>
        <th>Token</th>
        <th>Usado</th>
        <th>Fecha</th>
    </tr>

    @foreach($invitaciones as $inv)
        <tr>
            <td>{{ $inv->email }}</td>
            <td>{{ $inv->token }}</td>
            <td>{{ $inv->usado ? 'Sí' : 'No' }}</td>
            <td>{{ $inv->created_at }}</td>
        </tr>
    @endforeach
</table>

@endsection
