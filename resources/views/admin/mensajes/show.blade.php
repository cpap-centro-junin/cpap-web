@extends('layouts.admin')

@section('title','Detalle Mensaje')
@section('page-title','Detalle del Mensaje')

@section('content')

<div class="message-wrapper">

    <!-- CABECERA -->
    <div class="message-header-card">

        <div class="message-avatar">
            {{ strtoupper(substr($message->nombre,0,2)) }}
        </div>

        <div class="message-meta">
            <h3>{{ $message->asunto }}</h3>
            <div class="meta-info">
                <span><i class="fas fa-user"></i> {{ $message->nombre }}</span>
                <span><i class="fas fa-envelope"></i> {{ $message->email }}</span>
                <span><i class="fas fa-phone"></i> {{ $message->telefono ?? 'No registrado' }}</span>
                <span><i class="fas fa-clock"></i> {{ $message->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="message-status {{ $message->leido ? 'read' : 'unread' }}">
            {{ $message->leido ? 'Leído' : 'Nuevo' }}
        </div>

    </div>

    <!-- MENSAJE ORIGINAL -->
    <div class="message-body-card">
        <h5>Mensaje recibido</h5>
        <div class="message-content">
            {{ $message->mensaje }}
        </div>
    </div>

    <!-- RESPUESTA -->
    <div class="message-reply-card">

        <h5>Responder mensaje</h5>

        <form method="POST"
              action="{{ route('admin.mensajes.responder', $message) }}"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <textarea name="respuesta"
                          class="reply-textarea"
                          placeholder="Escribe tu respuesta institucional aquí..."
                          rows="6"
                          required></textarea>
            </div>

            <div class="upload-wrapper mt-4">

                <label class="upload-box" for="archivoInput">
                    <div class="upload-content">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <p class="upload-text">
                            Arrastra tu archivo aquí o haz clic para seleccionar
                        </p>
                        <span class="upload-subtext">
                            PDF, DOC, JPG, PNG (máx. 5MB)
                        </span>
                    </div>
                </label>

                <input type="file" 
                    name="archivo" 
                    id="archivoInput" 
                    class="upload-input">

                <div class="file-preview" id="filePreview" style="display:none;">
                    <i class="fas fa-file-alt"></i>
                    <span id="fileName"></span>
                    <button type="button" class="remove-file" onclick="removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

            </div>


            <button type="submit" class="btn-reply mt-4">
                <i class="fas fa-paper-plane"></i>
                Enviar Respuesta
            </button>
        </form>
        @push('scripts')
        <script>
        const fileInput = document.getElementById("archivoInput");
        const filePreview = document.getElementById("filePreview");
        const fileName = document.getElementById("fileName");

        fileInput.addEventListener("change", function(){
            if(this.files.length > 0){
                fileName.textContent = this.files[0].name;
                filePreview.style.display = "flex";
            }
        });

        function removeFile(){
            fileInput.value = "";
            filePreview.style.display = "none";
        }
        </script>
        @endpush

    </div>

</div>

@endsection
