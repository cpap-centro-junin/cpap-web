@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<h1>Bienvenido, {{ auth()->user()->name }}</h1>
<p>Panel administrativo del Colegio de Antropólogos del Perú – Región Centro.</p>

<div class="cards">
    <div class="card">👥 Directivos</div>
    <div class="card">✉️ Invitaciones</div>
    <div class="card">🧑‍💼 Usuarios</div>
    <div class="card">📰 Contenido</div>
    <div class="card">📅 Eventos</div>
    <div class="card">📄 Documentos</div>
</div>

@endsection
