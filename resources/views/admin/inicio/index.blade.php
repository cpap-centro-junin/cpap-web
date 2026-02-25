@extends('layouts.admin')

@section('title', 'Gestión de Inicio')
@section('page-title', 'Gestión de Inicio')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:24px;font-weight:700;color:var(--dark);margin:0 0 6px;display:flex;align-items:center;gap:12px;">
            <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--primary),#a8244d);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-home" style="color:white;font-size:22px;"></i>
            </div>
            Configuración de la Página Principal
        </h1>
        <p style="color:var(--medium-gray);font-size:14px;margin:0;padding-left:60px;">Personaliza los elementos que los visitantes ven al entrar al sitio web</p>
    </div>
</div>

@if(session('success'))
<div style="background:var(--success-light);color:var(--success);border:1px solid rgba(46,125,50,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Grid de Accesos Rápidos -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;margin-bottom:32px;">
    
    <!-- Banner Slider -->
    <a href="{{ route('admin.inicio.slides.index') }}" 
       style="display:block;background:white;border:2px solid #e3e3e3;border-radius:var(--radius);padding:28px;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.3s ease;"
       onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 24px rgba(139,21,56,0.12)';this.style.borderColor='var(--primary)'"
       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.borderColor='#e3e3e3'">
        <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:16px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,rgba(139,21,56,0.1),rgba(168,36,77,0.15));border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-images" style="font-size:26px;color:var(--primary);"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:19px;font-weight:700;margin:0 0 6px;color:var(--dark);">Carrusel de Imágenes</h3>
                <p style="font-size:13px;color:var(--medium-gray);margin:0;line-height:1.5;">Diapositivas que rotan automáticamente al inicio</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid #f0f0f0;">
            <div style="display:flex;gap:12px;">
                <span style="background:rgba(76,175,80,0.12);color:#2E7D32;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                    <i class="fas fa-check-circle" style="font-size:10px;"></i> {{ $slides->where('activo', true)->count() }} activas
                </span>
                <span style="background:rgba(33,150,243,0.12);color:#1565C0;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                    {{ $slides->count() }} total
                </span>
            </div>
            <i class="fas fa-arrow-right" style="color:var(--primary);font-size:16px;"></i>
        </div>
    </a>

    <!-- Título y Botones -->
    <a href="{{ route('admin.inicio.hero.edit') }}" 
       style="display:block;background:white;border:2px solid #e3e3e3;border-radius:var(--radius);padding:28px;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.3s ease;"
       onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 24px rgba(33,150,243,0.12)';this.style.borderColor='#2196F3'"
       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.borderColor='#e3e3e3'">
        <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:16px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,rgba(33,150,243,0.1),rgba(21,101,192,0.15));border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-text-height" style="font-size:26px;color:#2196F3;"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:19px;font-weight:700;margin:0 0 6px;color:var(--dark);">Título y Botones</h3>
                <p style="font-size:13px;color:var(--medium-gray);margin:0;line-height:1.5;">Texto de bienvenida y botones principales</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid #f0f0f0;">
            <span style="font-size:12px;color:var(--medium-gray);">
                <i class="fas fa-font" style="color:#2196F3;margin-right:6px;"></i>Personalizar mensaje de inicio
            </span>
            <i class="fas fa-arrow-right" style="color:#2196F3;font-size:16px;"></i>
        </div>
    </a>

    <!-- Números y Cifras -->
    <a href="{{ route('admin.inicio.estadisticas.edit') }}" 
       style="display:block;background:white;border:2px solid #e3e3e3;border-radius:var(--radius);padding:28px;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.3s ease;"
       onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 24px rgba(76,175,80,0.12)';this.style.borderColor='#4CAF50'"
       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.borderColor='#e3e3e3'">
        <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:16px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,rgba(76,175,80,0.1),rgba(46,125,50,0.15));border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-chart-bar" style="font-size:26px;color:#4CAF50;"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:19px;font-weight:700;margin:0 0 6px;color:var(--dark);">Números y Cifras</h3>
                <p style="font-size:13px;color:var(--medium-gray);margin:0;line-height:1.5;">Estadísticas institucionales que se muestran</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid #f0f0f0;">
            <div style="font-size:12px;color:var(--medium-gray);">
                <strong style="color:#4CAF50;font-size:18px;margin-right:6px;">{{ $config->stat_colegiados }}</strong>colegiados
                <span style="margin:0 8px;color:#ddd;">•</span>
                <strong style="color:#4CAF50;font-size:18px;margin-right:6px;">{{ $config->stat_años }}</strong>años
            </div>
            <i class="fas fa-arrow-right" style="color:#4CAF50;font-size:16px;"></i>
        </div>
    </a>

    <!-- Anuncios Emergentes -->
    <a href="{{ route('admin.anuncios.index') }}" 
       style="display:block;background:white;border:2px solid #e3e3e3;border-radius:var(--radius);padding:28px;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all 0.3s ease;"
       onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 24px rgba(255,152,0,0.12)';this.style.borderColor='#FF9800'"
       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.borderColor='#e3e3e3'">
        <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:16px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,rgba(255,152,0,0.1),rgba(230,81,0,0.15));border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-bell" style="font-size:26px;color:#FF9800;"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:19px;font-weight:700;margin:0 0 6px;color:var(--dark);">Anuncios Emergentes</h3>
                <p style="font-size:13px;color:var(--medium-gray);margin:0;line-height:1.5;">Ventana que aparece al entrar al sitio</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid #f0f0f0;">
            <span style="font-size:12px;color:var(--medium-gray);">
                <i class="fas fa-image" style="color:#FF9800;margin-right:6px;"></i>Gestionar popup de inicio
            </span>
            <i class="fas fa-arrow-right" style="color:#FF9800;font-size:16px;"></i>
        </div>
    </a>

</div>

<!-- Información -->
<div style="background:#f8f9fa;border:1px solid #e3e3e3;padding:20px 24px;border-radius:var(--radius);">
    <div style="display:flex;align-items:flex-start;gap:14px;">
        <div style="width:40px;height:40px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-info-circle" style="color:white;font-size:18px;"></i>
        </div>
        <div style="color:var(--dark);font-size:14px;line-height:1.6;">
            <strong style="display:block;margin-bottom:8px;font-size:15px;">💡 ¿Qué puedes configurar aquí?</strong>
            <p style="margin:0 0 10px;color:var(--medium-gray);">Todos los elementos visuales que los visitantes ven al entrar a tu sitio web:</p>
            <ul style="margin:0;padding-left:20px;color:var(--medium-gray);">
                <li style="margin-bottom:6px;"><strong style="color:var(--dark);">Carrusel de Imágenes:</strong> Diapositivas rotativas con imágenes y textos principales</li>
                <li style="margin-bottom:6px;"><strong style="color:var(--dark);">Título y Botones:</strong> Mensaje de bienvenida y botones de acceso rápido</li>
                <li style="margin-bottom:6px;"><strong style="color:var(--dark);">Números y Cifras:</strong> Estadísticas institucionales (colegiados, años, eventos...)</li>
                <li><strong style="color:var(--dark);">Anuncios Emergentes:</strong> Ventanas que aparecen al cargar la página</li>
            </ul>
        </div>
    </div>
</div>

@endsection
