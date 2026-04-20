@extends('layouts.admin')

@section('title', 'Editar Hero')
@section('page-title', 'Título y Botones de Bienvenida')

@push('styles')
<style>
.hero-editor-toolbar {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.hero-editor-btn {
    padding: 8px 14px;
    background: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    font-weight: 500;
}

.hero-editor-btn:hover {
    background: #e8e8e8;
    border-color: #ccc;
}

.hero-editor-btn.gradient {
    background: linear-gradient(135deg, #e3a953, #d4941c);
    color: white;
    border: none;
}

.hero-editor-btn.gradient:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(212, 148, 28, 0.25);
}

.hero-rich-editor {
    min-height: 120px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px;
    background: #fff;
    font-size: 15px;
    line-height: 1.6;
    color: var(--dark);
    outline: none;
    white-space: pre-wrap;
}

.hero-rich-editor:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.12);
}

.hero-rich-editor.gradient-preview .gradient-text {
    background: linear-gradient(135deg, #e3a953, #d4941c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: #d4941c;
    font-weight: 700;
}

@media (max-width: 768px) {
    .admin-form-card > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
    
    .form-group label {
        font-size: 13px !important;
    }
    
    .form-control, .admin-input, textarea {
        font-size: 14px !important;
    }
    
    /* Mejorar visibilidad del campo de ícono */
    .form-group input[type="text"] {
        min-height: 44px;
        padding: 12px 14px !important;
    }
    
    /* Botones de formato en columna */
    .hero-editor-toolbar .hero-editor-btn {
        flex: 1 1 100%;
        min-width: 100%;
    }
}
</style>
@endpush

@section('content')

<div style="margin-bottom:24px;">
    <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
        <i class="fas fa-arrow-left"></i> Volver a Gestión de Inicio
    </a>
</div>

<form action="{{ route('admin.inicio.hero.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- SECCIÓN 0: IMAGEN DE FONDO --}}
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 24px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-image" style="color:var(--primary);margin-right:10px;"></i>
            Imagen de Fondo del Hero
        </h2>

        <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:24px;margin-bottom:24px;">
            {{-- Imagen ACTUAL --}}
            <div>
                <h3 style="font-size:14px;font-weight:600;color:var(--dark);margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-check-circle" style="color:#4CAF50;"></i> Imagen Actual
                </h3>
                @if($config->hero_imagen)
                <div id="imagenActualContainer" style="position:relative;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <img src="{{ $config->heroImagenUrl }}" alt="Hero Background" 
                         style="width:100%;height:200px;object-fit:cover;display:block;">
                    <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top, rgba(0,0,0,0.8), transparent);padding:12px;color:white;">
                        <p style="margin:0;font-size:12px;font-weight:500;">
                            <i class="fas fa-image"></i> En uso
                        </p>
                    </div>
                </div>
                @else
                <div style="border:2px dashed #ddd;border-radius:12px;padding:60px 20px;text-align:center;background:#f9f9f9;">
                    <i class="fas fa-image" style="font-size:40px;color:#ccc;margin-bottom:12px;display:block;"></i>
                    <p style="color:var(--medium-gray);font-size:13px;margin:0;">Sin imagen configurada</p>
                </div>
                @endif
            </div>

            {{-- PREVIEW de NUEVA imagen --}}
            <div>
                <h3 style="font-size:14px;font-weight:600;color:var(--dark);margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-eye" style="color:#2196F3;"></i> Vista Previa (Nueva)
                </h3>
                <div id="previewContainer" style="border:2px dashed #2196F3;border-radius:12px;padding:60px 20px;text-align:center;background:#f0f7ff;min-height:200px;display:flex;align-items:center;justify-content:center;">
                    <div id="previewPlaceholder">
                        <i class="fas fa-cloud-upload-alt" style="font-size:40px;color:#2196F3;margin-bottom:12px;display:block;"></i>
                        <p style="color:#1976D2;font-size:13px;margin:0;font-weight:500;">Selecciona una imagen para ver preview</p>
                    </div>
                    <img id="previewImage" src="" alt="Preview" style="display:none;width:100%;height:200px;object-fit:cover;border-radius:8px;">
                </div>
            </div>
        </div>

        {{-- Campo de subida --}}
        <div>
            <div class="form-group" style="margin-bottom:16px;">
                <label for="hero_imagen" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                    <i class="fas fa-upload"></i> Subir Nueva Imagen
                </label>
                <input type="file" id="hero_imagen" name="hero_imagen" accept="image/jpeg,image/png,image/jpg,image/webp"
                       class="form-control" style="font-size:14px;padding:12px;" onchange="previewHeroImage(event)">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:10px;line-height:1.6;">
                    📸 <strong>Recomendaciones:</strong><br>
                    • Tamaño recomendado: <strong>1920x1080px</strong> o superior (Full HD / 4K / 8K)<br>
                    • Formatos aceptados: JPG, PNG, WEBP<br>
                    • <strong style="color:#4CAF50;">✓ Hasta 256MB</strong> - Carga imágenes HD sin problemas<br>
                    • Imagen con buena iluminación para que el texto se lea bien
                </small>
                @error('hero_imagen')
                    <p style="color:var(--danger);font-size:13px;margin:10px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            @if($config->hero_imagen)
            <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:14px;">
                <p style="color:#856404;font-size:13px;margin:0;line-height:1.6;">
                    <i class="fas fa-exclamation-triangle" style="color:#ffc107;"></i>
                    <strong>Nota:</strong> Al subir una nueva imagen, la anterior será reemplazada automáticamente.
                </p>
            </div>
            @endif
        </div>
    </div>

    <script>
    function previewHeroImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImage');
        const placeholder = document.getElementById('previewPlaceholder');
        const container = document.getElementById('previewContainer');
        
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
                container.style.padding = '0';
                container.style.border = '2px solid #4CAF50';
                container.style.background = '#E8F5E9';
            };
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
            container.style.padding = '60px 20px';
            container.style.border = '2px dashed #2196F3';
            container.style.background = '#f0f7ff';
        }
    }
    </script>

    {{-- SECCIÓN 1: TEXTOS DE BIENVENIDA --}}
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 24px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-heading" style="color:var(--primary);margin-right:10px;"></i>
            1. Textos de Bienvenida
        </h2>

        {{-- Badge --}}
        <div class="form-group" style="margin-bottom:20px;">
            <label for="hero_badge" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                Etiqueta Superior
            </label>
            <input type="text" id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $config->hero_badge) }}" 
                   placeholder="Bienvenidos" maxlength="50" class="form-control" style="font-size:15px;">
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                💡 Texto pequeño que aparece arriba del título principal
            </small>
            @error('hero_badge')
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Título Principal --}}
        <div class="form-group" style="margin-bottom:20px;">
            <label for="hero_titulo" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                Título Principal <span style="color:var(--danger);">*</span>
            </label>
            
            {{-- Editor visual --}}
            <div class="hero-editor-toolbar">
                <button type="button" class="hero-editor-btn" onclick="heroInsertLineBreak()">
                    <i class="fas fa-level-down-alt" style="color:var(--primary);"></i>
                    <span>Salto de Línea</span>
                </button>
                <button type="button" class="hero-editor-btn" onclick="heroToggleBold()">
                    <i class="fas fa-bold" style="color:var(--primary);"></i>
                    <span>Negrita</span>
                </button>
                <button type="button" class="hero-editor-btn" onclick="heroToggleItalic()">
                    <i class="fas fa-italic" style="color:var(--primary);"></i>
                    <span>Cursiva</span>
                </button>
                <button type="button" class="hero-editor-btn gradient" onclick="heroApplyGradient()">
                    <span>Aplicar Degradado Dorado</span>
                </button>
            </div>

            <div id="hero_titulo_editor" class="hero-rich-editor gradient-preview" contenteditable="true"></div>
            <textarea id="hero_titulo" name="hero_titulo" rows="3" style="display:none;">{{ old('hero_titulo', $config->hero_titulo) }}</textarea>
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;padding:12px;background:#f0f7ff;border-left:3px solid var(--primary);border-radius:6px;line-height:1.6;">
                <strong style="color:var(--dark);display:block;margin-bottom:6px;">💡 Cómo darle formato:</strong>
                <div style="margin-bottom:8px;padding:8px;background:white;border-radius:4px;">
                    <strong style="color:var(--primary);">Para dos líneas:</strong> Presiona Enter o usa el botón "Salto de Línea"
                </div>
                <div style="padding:8px;background:white;border-radius:4px;">
                    <strong style="color:#d4941c;">Para resaltar:</strong> Selecciona texto y usa Negrita, Cursiva o Degradado Dorado
                </div>
            </small>
            @error('hero_titulo')
                <p style="color:var(--danger);font-size:13px;margin:6px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Subtítulo --}}
        <div class="form-group" style="margin-bottom:0;">
            <label for="hero_subtitulo" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                Descripción
            </label>
            <textarea id="hero_subtitulo" name="hero_subtitulo" rows="3" class="form-control"
                      placeholder="Región Centro - Promoviendo la excelencia profesional..." 
                      style="font-size:14px;line-height:1.6;">{{ old('hero_subtitulo', $config->hero_subtitulo) }}</textarea>
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                💡 Texto descriptivo que aparece debajo del título
            </small>
            @error('hero_subtitulo')
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- SECCIÓN 2: BOTÓN PRIMARIO --}}
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 24px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-mouse-pointer" style="color:var(--primary);margin-right:10px;"></i>
            2. Botón Primario (Principal)
        </h2>

        {{-- Botón 1: Texto --}}
        <div class="form-group" style="margin-bottom:20px;">
            <label for="hero_btn1_texto" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                Texto del Botón
            </label>
            <input type="text" id="hero_btn1_texto" name="hero_btn1_texto" value="{{ old('hero_btn1_texto', $config->hero_btn1_texto) }}" 
                   placeholder="Quiero Colegiarme" maxlength="50" class="form-control" style="font-size:15px;">
            @error('hero_btn1_texto')
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:0;">
            {{-- Botón 1: URL --}}
            <div class="form-group" style="margin-bottom:0;">
                <label for="hero_btn1_url" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                    Enlace (¿A dónde va?)
                </label>
                <input type="text" id="hero_btn1_url" name="hero_btn1_url" value="{{ old('hero_btn1_url', $config->hero_btn1_url) }}" 
                       placeholder="#colegiatura" maxlength="500" class="form-control" style="font-size:15px;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;background:#f0f7ff;padding:12px;border-radius:6px;line-height:1.6;border-left:3px solid var(--primary);">
                    <strong style="color:var(--dark);display:block;margin-bottom:8px;">📍 Ejemplos:</strong>
                    <div style="margin-bottom:6px;padding:8px;background:white;border-radius:4px;">
                        <strong style="color:var(--primary);">Sección:</strong> <code style="background:#f5f5f5;padding:3px 8px;border-radius:3px;font-size:13px;">#colegiatura</code>
                    </div>
                    <div style="margin-bottom:6px;padding:8px;background:white;border-radius:4px;">
                        <strong style="color:var(--primary);">Página interna:</strong> <code style="background:#f5f5f5;padding:3px 8px;border-radius:3px;font-size:13px;">/nosotros</code>
                    </div>
                    <div style="padding:8px;background:white;border-radius:4px;">
                        <strong style="color:var(--primary);">Externo:</strong> <code style="background:#f5f5f5;padding:3px 8px;border-radius:3px;font-size:13px;">https://ejemplo.com</code>
                    </div>
                </small>
                @error('hero_btn1_url')
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón 1: Ícono --}}
            <div class="form-group" style="margin-bottom:0;">
                <label for="hero_btn1_icono" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                    Ícono
                </label>
                <input type="text" id="hero_btn1_icono" name="hero_btn1_icono" value="{{ old('hero_btn1_icono', $config->hero_btn1_icono) }}" 
                       placeholder="fas fa-user-plus" maxlength="50" class="form-control" style="font-size:15px;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                    <a href="https://fontawesome.com/icons" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:500;">
                        <i class="fas fa-external-link-alt" style="font-size:11px;"></i> Ver íconos
                    </a>
                </small>
                @error('hero_btn1_icono')
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- SECCIÓN 3: BOTÓN SECUNDARIO --}}
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 24px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-hand-pointer" style="color:var(--primary);margin-right:10px;"></i>
            3. Botón Secundario (Opcional)
        </h2>

        {{-- Botón 2: Texto --}}
        <div class="form-group" style="margin-bottom:20px;">
            <label for="hero_btn2_texto" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                Texto del Botón
            </label>
            <input type="text" id="hero_btn2_texto" name="hero_btn2_texto" value="{{ old('hero_btn2_texto', $config->hero_btn2_texto) }}" 
                   placeholder="Conocer Más" maxlength="50" class="form-control" style="font-size:15px;">
            @error('hero_btn2_texto')
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:0;">
            {{-- Botón 2: URL --}}
            <div class="form-group" style="margin-bottom:0;">
                <label for="hero_btn2_url" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                    Enlace (¿A dónde va?)
                </label>
                <input type="text" id="hero_btn2_url" name="hero_btn2_url" value="{{ old('hero_btn2_url', $config->hero_btn2_url) }}" 
                       placeholder="#nosotros" maxlength="500" class="form-control" style="font-size:15px;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;background:#f8f9fa;padding:12px;border-radius:6px;line-height:1.5;border-left:3px solid var(--medium-gray);">
                    <strong style="color:var(--dark);display:block;margin-bottom:8px;">📍 Ejemplos:</strong>
                    <div style="margin-bottom:4px;padding:6px;background:white;border-radius:3px;"><code style="background:#f5f5f5;padding:2px 8px;border-radius:3px;font-size:13px;">#nosotros</code></div>
                    <div style="margin-bottom:4px;padding:6px;background:white;border-radius:3px;"><code style="background:#f5f5f5;padding:2px 8px;border-radius:3px;font-size:13px;">#servicios</code></div>
                    <div style="padding:6px;background:white;border-radius:3px;"><code style="background:#f5f5f5;padding:2px 8px;border-radius:3px;font-size:13px;">/biblioteca</code></div>
                </small>
                @error('hero_btn2_url')
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón 2: Ícono --}}
            <div class="form-group" style="margin-bottom:0;">
                <label for="hero_btn2_icono" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:10px;">
                    Ícono
                </label>
                <input type="text" id="hero_btn2_icono" name="hero_btn2_icono" value="{{ old('hero_btn2_icono', $config->hero_btn2_icono) }}" 
                       placeholder="fas fa-info-circle" maxlength="50" class="form-control" style="font-size:15px;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                    Ej: <code style="background:#f5f5f5;padding:3px 8px;border-radius:3px;">fas fa-info-circle</code>
                </small>
                @error('hero_btn2_icono')
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- BOTONES DE ACCIÓN --}}
    <div style="display:flex;gap:12px;justify-content:flex-end;padding:20px;background:white;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <a href="{{ route('admin.inicio.index') }}" class="secondary-btn">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="primary-btn">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </div>
</form>

{{-- INFO BOX --}}
<div style="background:#f8f9fa;border-left:4px solid var(--secondary);padding:18px 20px;border-radius:8px;margin-top:24px;">
    <div style="display:flex;align-items:flex-start;gap:14px;">
        <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--secondary),#9c27b0);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-lightbulb" style="color:white;font-size:20px;"></i>
        </div>
        <div style="color:#495057;font-size:14px;line-height:1.6;">
            <strong style="display:block;margin-bottom:8px;color:var(--dark);font-size:15px;">💡 Consejos Útiles</strong>
            <ul style="margin:0;padding-left:20px;">
                <li style="margin-bottom:6px;">El <strong>botón primario</strong> es el más importante (ej: "Quiero Colegiarme")</li>
                <li style="margin-bottom:6px;">El <strong>botón secundario</strong> es opcional y menos destacado (ej: "Conocer Más")</li>
                <li>Explora íconos en <a href="https://fontawesome.com/icons" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:500;">FontAwesome</a></li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const heroTitleEditor = document.getElementById('hero_titulo_editor');
const heroTitleInput = document.getElementById('hero_titulo');

function normalizeHeroHtml(html) {
    if (!html) return '';

    let normalized = html
        .replace(/<div><br><\/div>/gi, '<br>')
        .replace(/<div>/gi, '')
        .replace(/<\/div>/gi, '<br>')
        .replace(/<p>/gi, '')
        .replace(/<\/p>/gi, '<br>')
        .replace(/&nbsp;/g, ' ')
        .replace(/(<br\s*\/?>\s*){3,}/gi, '<br><br>')
        .trim();

    normalized = normalized.replace(/^(<br\s*\/?>\s*)+|(<br\s*\/?>\s*)+$/gi, '');
    return normalized;
}

function syncHeroTitleInput() {
    if (!heroTitleEditor || !heroTitleInput) return;
    heroTitleInput.value = normalizeHeroHtml(heroTitleEditor.innerHTML);
}

function initHeroTitleEditor() {
    if (!heroTitleEditor || !heroTitleInput) return;

    const initial = heroTitleInput.value && heroTitleInput.value.trim() !== ''
        ? heroTitleInput.value
        : 'Colegio Profesional de Antropólogos del Perú';

    heroTitleEditor.innerHTML = initial;

    heroTitleEditor.addEventListener('input', syncHeroTitleInput);
    heroTitleEditor.addEventListener('blur', syncHeroTitleInput);
    heroTitleEditor.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            heroInsertLineBreak();
        }
    });

    const form = heroTitleEditor.closest('form');
    if (form) {
        form.addEventListener('submit', syncHeroTitleInput);
    }

    syncHeroTitleInput();
}

function getSelectionRangeInsideHeroEditor() {
    if (!heroTitleEditor) return null;

    const selection = window.getSelection();
    if (!selection || selection.rangeCount === 0) return null;

    const range = selection.getRangeAt(0);
    if (!heroTitleEditor.contains(range.commonAncestorContainer)) return null;

    return range;
}

function heroInsertLineBreak() {
    if (!heroTitleEditor) return;

    heroTitleEditor.focus();
    const range = getSelectionRangeInsideHeroEditor();

    if (!range) {
        heroTitleEditor.innerHTML += '<br>';
        syncHeroTitleInput();
        return;
    }

    range.deleteContents();
    const br = document.createElement('br');
    range.insertNode(br);
    range.setStartAfter(br);
    range.collapse(true);

    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    syncHeroTitleInput();
}

function heroToggleBold() {
    heroTitleEditor?.focus();
    document.execCommand('bold', false, null);
    syncHeroTitleInput();
}

function heroToggleItalic() {
    heroTitleEditor?.focus();
    document.execCommand('italic', false, null);
    syncHeroTitleInput();
}

function heroApplyGradient() {
    if (!heroTitleEditor) return;

    heroTitleEditor.focus();
    const range = getSelectionRangeInsideHeroEditor();

    if (!range || range.collapsed) {
        Swal.fire({
            icon: 'info',
            title: 'Selecciona texto',
            text: 'Selecciona una parte del título para aplicar el degradado dorado.',
            confirmButtonColor: '#8B1538'
        });
        return;
    }

    const selectedContent = range.extractContents();
    const span = document.createElement('span');
    span.className = 'gradient-text';
    span.appendChild(selectedContent);
    range.insertNode(span);

    const selection = window.getSelection();
    selection.removeAllRanges();

    syncHeroTitleInput();
}

document.addEventListener('DOMContentLoaded', initHeroTitleEditor);
</script>
@endpush
