@extends('layouts.admin')

@section('title','Detalle Mensaje')
@section('page-title','Detalle del Mensaje')

@section('content')

<div class="msg-detail-wrap">

    {{-- CARD REMITENTE --}}
    <div class="msg-detail-card msg-sender-card">
        <div class="msg-detail-avatar">
            {{ strtoupper(substr($message->nombre,0,2)) }}
        </div>
        <div class="msg-detail-meta">
            <div class="msg-detail-top">
                <h3>{{ $message->asunto }}</h3>
                <span class="msg-detail-status {{ $message->leido ? 'msg-detail-status--read' : 'msg-detail-status--new' }}">
                    <i class="fas {{ $message->leido ? 'fa-check-double' : 'fa-circle' }}"></i>
                    {{ $message->leido ? 'Leído' : 'Nuevo' }}
                </span>
            </div>
            <div class="msg-detail-info">
                <span><i class="fas fa-user"></i> {{ $message->nombre }}</span>
                <a href="mailto:{{ $message->email }}" class="msg-detail-link">
                    <i class="fas fa-envelope"></i> {{ $message->email }}
                </a>
                @if($message->telefono)
                <a href="tel:{{ $message->telefono }}" class="msg-detail-link">
                    <i class="fas fa-phone"></i> {{ $message->telefono }}
                </a>
                @else
                <span class="msg-detail-muted"><i class="fas fa-phone"></i> Sin teléfono</span>
                @endif
                <span><i class="fas fa-calendar-alt"></i> {{ $message->created_at->format('d/m/Y h:i A') }}</span>
            </div>
        </div>
    </div>

    {{-- MENSAJE ORIGINAL --}}
    <div class="msg-detail-card">
        <div class="msg-section-label">
            <i class="fas fa-comment-alt"></i> Mensaje recibido
        </div>
        <div class="msg-body-text">
            {!! nl2br(e($message->mensaje)) !!}
        </div>
    </div>

    @if($message->respuesta)
    {{-- RESPUESTA ENVIADA --}}
    <div class="msg-detail-card msg-replied-card">
        <div class="msg-section-label msg-section-label--success">
            <i class="fas fa-paper-plane"></i> Respuesta enviada
        </div>
        <div class="msg-body-text">
            {!! nl2br(e($message->respuesta)) !!}
        </div>
        @if($message->archivo_respuesta)
        <a href="{{ asset('storage/' . $message->archivo_respuesta) }}" target="_blank" class="msg-file-link">
            <i class="fas fa-paperclip"></i> Ver archivo adjunto
        </a>
        @endif
    </div>
    @else
    {{-- RESPONDER --}}
    <div class="msg-detail-card">
        <div class="msg-section-label">
            <i class="fas fa-reply"></i> Responder mensaje
        </div>

        <form method="POST"
              action="{{ route('admin.mensajes.responder', $message) }}"
              enctype="multipart/form-data"
              class="msg-reply-form">
            @csrf

            <div class="msg-reply-field">
                <label>Texto de respuesta <span class="msg-required">*</span></label>
                <textarea name="respuesta"
                          class="msg-reply-textarea"
                          placeholder="Redacta la respuesta institucional aquí..."
                          rows="7"
                          required></textarea>
            </div>

            <div class="msg-upload-area">
                <label class="msg-upload-label" for="archivoInput">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Adjuntar archivo (opcional)</span>
                    <small>PDF, DOC, JPG, PNG — máx. 5 MB</small>
                </label>
                <input type="file" name="archivo" id="archivoInput" class="msg-upload-input">
                <div class="msg-file-preview" id="filePreview" style="display:none;">
                    <i class="fas fa-file-alt"></i>
                    <span id="fileName"></span>
                    <button type="button" class="msg-remove-file" onclick="removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="msg-reply-btn">
                <i class="fas fa-paper-plane"></i>
                Enviar Respuesta
            </button>
        </form>
    </div>
    @endif

    <div class="msg-back-row">
        <a href="{{ route('admin.mensajes.index') }}" class="msg-back-link">
            <i class="fas fa-arrow-left"></i> Volver a mensajes
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
const fileInput = document.getElementById("archivoInput");
if(fileInput){
    const filePreview = document.getElementById("filePreview");
    const fileName    = document.getElementById("fileName");
    fileInput.addEventListener("change", function(){
        if(this.files.length > 0){
            fileName.textContent = this.files[0].name;
            filePreview.style.display = "flex";
        }
    });
}
function removeFile(){
    document.getElementById("archivoInput").value = "";
    document.getElementById("filePreview").style.display = "none";
}
</script>
@endpush
