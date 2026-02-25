@extends('layouts.admin')

@section('title', 'Normativa Legal')
@section('page-title', 'Normativa Legal')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 4px;">Normativa Legal</h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;">{{ $documentos->count() }} documento{{ $documentos->count() !== 1 ? 's' : '' }} registrado{{ $documentos->count() !== 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.normativa.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i> Agregar Documento
    </a>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($documentos->count() === 0)
<div style="background:var(--warning-light);color:var(--warning);border:1px solid rgba(230,81,0,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:14px;">
    <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
    <div>
        <strong>No hay documentos normativos aún.</strong><br>
        La página pública de <em>Nosotros → Normativa Legal</em> mostrará un mensaje indicando que no hay documentos disponibles.
    </div>
</div>
@endif

<div class="admin-table">
    <table>
        <thead>
            <tr>
                <th style="width:50px;">Ícono</th>
                <th>Título</th>
                <th>Archivo PDF</th>
                <th>Orden</th>
                <th>Estado</th>
                <th style="text-align:center;width:140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $doc)
            <tr>
                <td>
                    <div style="width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="{{ $doc->icono }}" style="color:white;font-size:16px;"></i>
                    </div>
                </td>
                <td>
                    <div style="font-weight:600;color:var(--dark);font-size:14px;">{{ $doc->titulo }}</div>
                    @if($doc->descripcion)
                    <div style="font-size:12px;color:var(--medium-gray);margin-top:2px;">{{ Str::limit($doc->descripcion, 80) }}</div>
                    @endif
                </td>
                <td>
                    @if($doc->archivo_pdf)
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(46,125,50,0.08);color:var(--success);padding:4px 12px;border-radius:50px;font-size:12px;font-weight:600;">
                        <i class="fas fa-file-pdf" style="font-size:11px;"></i>
                        {{ Str::limit($doc->archivo_nombre, 30) }}
                    </span>
                    @else
                    <span style="color:var(--medium-gray);font-size:13px;font-style:italic;">Sin archivo</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="display:inline-block;width:28px;height:28px;background:var(--light-gray);border-radius:6px;text-align:center;line-height:28px;font-size:13px;font-weight:700;color:var(--dark);">
                        {{ $doc->orden }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $doc->activo ? 'published' : 'hidden' }}">
                        <i class="fas fa-circle" style="font-size:7px;"></i>
                        {{ $doc->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('admin.normativa.edit', $doc) }}"
                           style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:var(--warning-light);color:var(--warning);border-radius:var(--radius-sm);font-size:12px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.normativa.destroy', $doc) }}" method="POST" style="display:inline;" class="delete-form" id="form-delete-normativa-{{ $doc->id }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete('{{ addslashes($doc->titulo) }}', 'form-delete-normativa-{{ $doc->id }}')"
                                    style="display:inline-flex;align-items:center;padding:6px 10px;background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);font-size:12px;border:none;cursor:pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-gavel"></i>
                        <p>No hay documentos normativos registrados.<br>Agrega los documentos legales del CPAP.</p>
                        <a href="{{ route('admin.normativa.create') }}" class="primary-btn" style="display:inline-flex;">
                            <i class="fas fa-plus"></i> Agregar Documento
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;padding:14px 18px;background:var(--info-light);border-radius:var(--radius-sm);font-size:13px;color:var(--info);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-lightbulb"></i>
    <span>Los documentos activos se mostrarán en la página pública <strong>Nosotros → Normativa Legal</strong>. Sube archivos PDF de hasta 10 MB.</span>
</div>

@endsection
