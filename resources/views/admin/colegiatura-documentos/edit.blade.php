@extends('layouts.admin')

@section('title', 'Documentos de Colegiatura')
@section('page-title', 'Documentos de Colegiatura')

@section('content')

<div style="width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('admin.dashboard') }}"
           style="width:36px;height:36px;border-radius:50%;background:var(--light-gray);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--medium-gray);text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:700;color:var(--dark);margin:0 0 2px;">Documentos de Colegiatura</h1>
            <p style="color:var(--medium-gray);font-size:13px;margin:0;">Gestiona los 3 documentos oficiales</p>
        </div>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
    <div style="background:var(--danger-light);color:var(--danger);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;">
        <strong style="display:flex;align-items:center;gap:8px;margin-bottom:8px;"><i class="fas fa-exclamation-circle"></i> Corrige los errores:</strong>
        <ul style="margin:0;padding-left:20px;font-size:13px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.colegiatura-documentos.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- INFO GENERAL --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 12px;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-info-circle" style="color:var(--primary);"></i> Acerca de esta sección
            </h3>
            <p style="font-size:13px;color:var(--medium-gray);margin:0 0 8px;">
                Aquí solo puedes <strong>reemplazar</strong> los 3 documentos oficiales utilizados en la página de colegiatura.
                No se crean nuevos registros ni nuevos nombres de archivo.
            </p>
            <p style="font-size:13px;color:var(--medium-gray);margin:0;">
                El archivo <strong>proceso-colegiacion.pdf</strong> también alimenta el botón
                <strong>"Descargar Guía Completa"</strong> en el home.
            </p>
        </div>

        {{-- DOCUMENTOS --}}
        @foreach($documents as $doc)
        <div class="admin-card" style="margin-bottom:16px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
                <div style="flex:1;">
                    <h3 style="font-size:14px;font-weight:700;color:var(--dark);margin:0 0 4px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-file-pdf" style="color:var(--danger);"></i> {{ $doc['title'] }}
                    </h3>
                    <p style="font-size:13px;color:var(--medium-gray);margin:0;">{{ $doc['description'] }}</p>
                </div>
                <span class="badge {{ $doc['exists'] ? 'badge-success' : 'badge-danger' }}" style="white-space:nowrap;margin-left:12px;">
                    {{ $doc['exists'] ? '✓ Disponible' : '✗ No encontrado' }}
                </span>
            </div>

            {{-- DETALLES ACTUALES --}}
            @if($doc['exists'])
            <div style="background:var(--light-gray);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-bottom:14px;">
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;font-size:12px;">
                    <div>
                        <div style="color:var(--medium-gray);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;margin-bottom:2px;">Archivo</div>
                        <div style="color:var(--dark);font-weight:600;word-break:break-word;">{{ $doc['filename'] }}</div>
                    </div>
                    <div>
                        <div style="color:var(--medium-gray);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;margin-bottom:2px;">Tamaño</div>
                        <div style="color:var(--dark);font-weight:600;">{{ $doc['size_kb'] }} KB</div>
                    </div>
                    <div>
                        <div style="color:var(--medium-gray);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;margin-bottom:2px;">Actualizado</div>
                        <div style="color:var(--dark);font-weight:600;">{{ $doc['updated_at'] }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ $doc['url'] }}" target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;margin-bottom:14px;padding:6px 12px;background:var(--light-gray);border-radius:6px;border:1px solid var(--border);transition:all 0.2s;">
                <i class="fas fa-eye"></i> Ver PDF actual
            </a>
            @endif

            {{-- UPLOAD --}}
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    Subir nuevo PDF para reemplazar
                </label>

                <div id="dropZone-{{ $doc['key'] }}"
                     onclick="document.getElementById('file-{{ $doc['key'] }}').click()"
                     style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;background:transparent;">
                    <div id="dropContent-{{ $doc['key'] }}">
                        <i class="fas fa-cloud-upload-alt" style="font-size:24px;color:var(--border);display:block;margin-bottom:6px;"></i>
                        <p style="font-size:13px;color:var(--medium-gray);margin:0;font-weight:600;">Clic para seleccionar un PDF</p>
                        <p style="font-size:11px;color:var(--medium-gray);margin:4px 0 0;">Máx. 20MB</p>
                    </div>
                </div>

                <input
                    type="file"
                    id="file-{{ $doc['key'] }}"
                    name="{{ $doc['key'] }}"
                    accept=".pdf"
                    class="admin-input"
                    style="display:none;"
                    onchange="updateFileName(this, '{{ $doc['key'] }}', '{{ $doc['filename'] }}')"
                >

                @error($doc['key'])
                <div style="background:var(--danger-light);color:var(--danger);border-radius:6px;padding:8px 12px;margin-top:8px;font-size:12px;">
                    {{ $message }}
                </div>
                @enderror

                <p style="font-size:11px;color:var(--medium-gray);margin:8px 0 0;">
                    Si seleccionas un archivo, reemplazará a <strong>{{ $doc['filename'] }}</strong>.
                </p>
            </div>
        </div>
        @endforeach

        {{-- ACCIONES --}}
        <div style="display:flex;gap:10px;align-items:center;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Guardar cambios
            </button>
            <a href="{{ route('colegiatura.index') }}" target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;background:var(--light-gray);color:var(--medium-gray);border:1px solid var(--border);border-radius:6px;text-decoration:none;font-weight:600;font-size:13px;transition:all 0.2s;">
                <i class="fas fa-external-link-alt"></i>
                Ver página de colegiatura
            </a>
        </div>
    </form>
</div>

<script>
function updateFileName(input, docKey, originalName) {
    const dropZone = document.getElementById('dropZone-' + docKey);
    const content = document.getElementById('dropContent-' + docKey);
    
    if (input.files.length > 0) {
        const file = input.files[0];
        content.innerHTML = `<i class="fas fa-check-circle" style="font-size:24px;color:var(--success);display:block;margin-bottom:6px;"></i><p style="font-size:13px;color:var(--dark);margin:0;font-weight:600;">${file.name}</p><p style="font-size:11px;color:var(--medium-gray);margin:4px 0 0;">${(file.size / 1024).toFixed(1)} KB</p>`;
        dropZone.style.borderColor = 'var(--success)';
        dropZone.style.background = 'var(--success-light)';
    } else {
        content.innerHTML = `<i class="fas fa-cloud-upload-alt" style="font-size:24px;color:var(--border);display:block;margin-bottom:6px;"></i><p style="font-size:13px;color:var(--medium-gray);margin:0;font-weight:600;">Clic para seleccionar un PDF</p><p style="font-size:11px;color:var(--medium-gray);margin:4px 0 0;">Máx. 20MB</p>`;
        dropZone.style.borderColor = 'var(--border)';
        dropZone.style.background = 'transparent';
    }
}
</script>

@endsection
